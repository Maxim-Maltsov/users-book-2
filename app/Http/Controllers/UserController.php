<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Mail\CreatedUserInfo;
use App\Mail\UserSecurityInfo;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;



class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function profile($id)
    {
       $user = User::find($id);
       $avatarStub = 'img/demo/avatars/avatar-m.png';

        return view('profile', ['user' => $user, 'avatarStub' => $avatarStub]);
    }


    public function editInfo($id, Request $request)
    {   
        $user = User::find($id);
        
        if ($request->isMethod('post')) {
           
            $this->validate( $request, [
            
                'name' => 'required|min:2|max:40',
                'job' => 'required|min:5|max:100',
                'phone' => ['required', 'regex:/^(\+7|7|8)?[\s\-]?\(?[489][0-9]{2}\)?[\s\-]?[0-9]{3}[\s\-]?[0-9]{2}[\s\-]?[0-9]{2}$/'],
                'address' => 'required|min:8|max:100',
                'vk' => 'required',
                'telegram' => 'required',
                'instagram' => 'required',
            ]);

            $name = $request->name;
            $data = $request->except('name', '_token');

            User::editMainInfoById($id, $name, $data);

            return redirect("profile/$id")->with("message",' Данные успешно обновлены.')
                                          ->with("message-type","success");
        }

        return view('info', ['user' => $user]);
    }


    public function editSecurity($id, Request $request)
    {
        $user = User::find($id);

        if ($request->isMethod('post')) {

            $this->validate( $request, [
            
                'email' => ['required', 'email', Rule::unique('users')->ignore($user->id),],
                'password' => 'required|string|min:6',
            ]);

            $email = $request->email;
            $password = $request->password;

            try {

                User::editSecurityInfoById($id, $email, $password);
                Mail::to($request->user())->send(new UserSecurityInfo($request));

                return redirect("profile/$id")->with("message",' Данные успешно обновлены.')
                                              ->with("message-type","success");
            }
            catch (\App\Exceptions\NotLoggedInException $e) {

                Log::info($e->getMessage());
                return redirect()->route('home')
                                    ->with("message"," Для смены логина или пароля необходимо войти в систему.")
                                    ->with("message-type","danger");
            }
        }

        return view('security', ['user' => $user]);
    }


    public function editStatus($id, Request $request)
    {
        $user = User::find($id);

        $userCurrentStatus = $user->profile->status;
        $statuses = User::getStatuses();

        if ($request->isMethod('post')) {
            
            $status = $request->status;
        
            User::editStatusById($id, $status);
            return redirect("profile/$id")->with("message",' Данные успешно обновлены.')
                                          ->with("message-type","success");
        }

        return view('status', ['user' => $user, 'userCurrentStatus' => $userCurrentStatus, 'statuses' => $statuses]);
    }

    
    public function editAvatar($id, Request $request)
    {
        $user = User::find($id);
        $avatarStub = 'img/demo/avatars/avatar-m.png';

        if ($request->isMethod('post')) {

            $this->validate( $request, [
            
                'avatar' => [
                    
                    'required',
                ]
            ]);
            
            $avatar = $request->avatar;
            
            User::editAvatarById($id, $avatar);
            return redirect("profile/$id")->with("message",' Данные успешно обновлены.')
                                          ->with("message-type","success");
        }

        return view('avatar', ['user' => $user, 'avatarStub' => $avatarStub]);
    }


    public function deleteUser($id)
    { 
        try {

            User::deleteById($id);
            return redirect()->route('home')
                             ->with("message",' Пользователь успешно удалён.')
                             ->with("message-type","success");
        }
        catch (\App\Exceptions\UnknownIdException $e) {

            Log::error($e->getMessage());
            return redirect()->route('home')
                             ->with("message"," Пользователь не найден.")
                             ->with("message-type","danger");
        }
    }


    public function createUser(Request $request) 
    {  
        $statuses = User::getStatuses();

        if ($request->isMethod('post')) {

            $this->validate( $request, [

                'email' => ['required', 'email', 'unique:users,email'],
                'password' => 'required|string|min:6',
                'name' => 'required|min:2|max:40',
                'phone' => ['required', 'regex:/^(\+7|7|8)?[\s\-]?\(?[489][0-9]{2}\)?[\s\-]?[0-9]{3}[\s\-]?[0-9]{2}[\s\-]?[0-9]{2}$/'],
                'address' => 'required|min:8|max:100',
                'job' => 'required|min:5|max:100',
                'status' => 'nullable|string',
                'avatar' => ['nullable','image', 'dimensions:min_width=100,min_height=100'],
                'vk' => 'required',
                'telegram' => 'required',
                'instagram' => 'required',
            ]);

            $userData = $request->only('name', 'email', 'password');
            $profileData = $request->only('phone', 'address', 'job', 'status', 'avatar', 'vk', 'telegram', 'instagram' );

            try {

                $userId = User::createNewUser($userData);
                          Profile::create($profileData, $userId);
                
                Mail::to($request->user())->send(new CreatedUserInfo($request));
                
                return redirect()->route('create')
                                 ->with("message",' Новый пользователь успешно зарегистрирован.')
                                 ->with("message-type","success");
            }
            catch (\App\Exceptions\NotLoggedInException $e) {

                Log::info($e->getMessage());
                return redirect()->route('login')
                                 ->with("message"," Для дальнейших действий необходимо войти в систему.")
                                 ->with("message-type","danger");
            } 
        }

        return view('create-user', ['statuses' => $statuses]);
    }
}
