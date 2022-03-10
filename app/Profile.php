<?php

namespace App;

use App\Exceptions\NotLoggedInException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Profile extends Model
{

    protected $fillable = [
        'phone', 'address', 'job', 'status', 'avatar', 'vk', 'telegram', 'instagram',
    ];

    public function user() :object
    {
        return $this->belongsTo('App\User');
    }

    
    public static function create($request, $id)
    {   
        if (Auth::check() && Auth::user()->role == 'admin') {

            $profile = new Profile($request);

            $profile->user_id = $id;
            $profile->avatar = $request['avatar']->store('uploads'); // Одновременно присваеваем полю avatar значение и сохраняем файл в папку uploads.
            $profile->save();
        }
        else {

			throw new NotLoggedInException("You are not an administrator.");
		}
    }
}
