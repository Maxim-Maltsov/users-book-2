<?php

namespace App;

use App\Exceptions\NotLoggedInException;
use App\Exceptions\UnknownIdException;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function profile() :object
    {
        return $this->hasOne('App\Profile');
    }


    public static function getStatuses() : array
    {
        $statuses =
        [   
            'online' => 'онлайн',
            'moved_away' => 'отошел',
            'not_disturb' => 'не беспокоить'
        ];

        return $statuses;
    }


    public static function editMainInfoById($id, $name, $data)
    {   
        DB::table('users')->where('id', $id)->update(['name' => $name]);
        DB::table('profiles')->where('user_id', $id)->update($data);
    }


    public static function editSecurityInfoById($id, $email, $password)
    {
        if (Auth::check()) {

            $hashed = Hash::make($password);
            
            $user = User::find($id);
            $user->email = $email;
            $user->password = $hashed;
            $user->save();
        } 
        else {

			throw new NotLoggedInException("Attempt to change email or password by a user who is not logged in.");
		}
    }


    public static function editStatusById($id, $status)
    {
        Profile::where('user_id', $id)->update(['status' => $status]);
    }


    public static function editAvatarById($id, $avatar)
    {   
        $profile = Profile::where('user_id', $id)->first();
        
        Storage::delete([$profile->avatar]);

        $path = $avatar->store('uploads');

        Profile::where('user_id', $id)->update(['avatar' => $path]);
    }


    public static function deleteById($id)
    {
        $user = User::find($id);
        $profile = $user->profile;

        DB::table('users')->where('id', $id)->delete();

        if ($user == null) {

            throw new UnknownIdException("The user with ID = {$id} not found");
        }
        
        DB::table('profiles')->where('user_id', $id)->delete();
        Storage::delete([$profile->avatar]);
    }


    public static function createNewUser($request)
    {   
        if (Auth::check() && Auth::user()->role == 'admin') {

            $user = new User($request);

            $user->role = 'user';
            $user->password = Hash::make($request['password']);
            $user->save();

            return $user->id;
        }
        else {

			throw new NotLoggedInException("You are not an administrator.");
		}
    }


    
}
