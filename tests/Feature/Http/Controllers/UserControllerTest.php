<?php

namespace Tests\Feature\Http\Controllers;

use App\Profile;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;


class UserControllerTest extends TestCase
{
    use RefreshDatabase;

        /**
     * A basic test example.
     *
     * @return void
     */


    // ProfileTests
    public function testProfilePageWithLoginedUser()
    {
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);
        
        $response = $this->actingAs($user)
                         ->get("/profile/{$user->id}");

        $response->assertStatus(200);
        $response->assertViewIs('profile');
        $response->assertViewHas(['user', 'avatarStub']);
    }

    public function testProfilePageWithLoggedOutUser()
    {
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);

        $response = $this->get("/profile/{$user->id}");

        $response->assertStatus(302);
        $response->assertRedirect('login');
    }



    // InfoTests
    public function testInfoPageWithLoginedUser() 
    {
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
                         ->get("/edit/info/{$user->id}");

        $response->assertStatus(200);
        $response->assertViewIs('info');
        $response->assertViewHas(['user']);  
    }

    public function testEditInfoWithLoginedUserOnValidationSuccess()
    {   
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);

        $this->actingAs($user)
             ->get("/edit/info/{$user->id}");

        $response = $this->post("/edit/info/$user->id", [
            
            'name' => 'new name',
            'job' => 'new job',
            'phone' => '8 800 800 80 80',
            'address' => 'new address',
            'vk' => 'vk',
            'telegram' => 'telegram',
            'instagram' => 'instagram',
        ]);

        $response->assertRedirect("/profile/$user->id");
    }

    public function testEditInfoWithLoginedUserOnValidationError()
    {   
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);
                
        
        $this->actingAs($user)
             ->get("/edit/info/{$user->id}");

        $response = $this->post("/edit/info/$user->id", [
            
            'name' => 'name',
            'job' => 'new',
            'phone' => '8',
            'address' => 'new',
            'vk' => 'vk',
            'telegram' => 'telegram',
            'instagram' => 'instagram',
        ]);

        $response->assertRedirect("/edit/info/$user->id");
    }

    public function testInfoPageWithLoggedOutUser()
    {
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);

        $response = $this->get("/edit/info/{$user->id}");

        $response->assertStatus(302);
        $response->assertRedirect('login');
    }



    // SecurityTests
    public function testSecurityPageWithLoginedUser()
    {
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
                         ->get("/edit/security/{$user->id}");

        $response->assertStatus(200);
        $response->assertViewIs('security');
        $response->assertViewHas(['user']);

    }

    public function testEditSecurityWithLoginedUserOnValidationSuccess()
    {
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);

        $this->actingAs($user)
             ->get("/edit/security/$user->id");

        $response = $this->post("/edit/security/$user->id", [

            'email' => 'example@mail.com',
            'password' => 'secret'
        ]);

        $response->assertRedirect("/profile/$user->id");
    }

    public function testEditSecurityWithLoginedUserOnValidationError()
    {
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);

        $this->actingAs($user)
             ->get("/edit/security/$user->id");

        $response = $this->post("/edit/security/$user->id", [

            'email' => 'example@mail',
            'password' => ''
        ]);

        $response->assertRedirect("/edit/security/$user->id");
    }

    public function testSecurityPageWithLoggedOutUser()
    {
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);

        $response = $this->get("/edit/security/{$user->id}");

        $response->assertStatus(302);
        $response->assertRedirect('login');
    }



    // StatusTests
    public function testStatusPageWithLoginedUser()
    {
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
                         ->get("/edit/status/{$user->id}");

        $response->assertStatus(200);
        $response->assertViewIs('status');
        $response->assertViewHas(['user', 'userCurrentStatus', 'statuses']);
    }

    public function testEditStatusWithLoginedUserValidationOnSuccess()
    {
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);

        $this->actingAs($user)
             ->get("/edit/status/{$user->id}");

        $response = $this->post("/edit/status/$user->id", [

            'status' => 'online'
        ]);

        $response->assertRedirect("/profile/$user->id");
    }

    public function testStatusPageWithLoggedOutUser()
    {
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);

        $response = $this->get("/edit/status/{$user->id}");

        $response->assertStatus(302);
        $response->assertRedirect('login');
    }


    // AvatarTests
    public function testAvatarPageWithLoginedUser()
    {
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
                         ->get("/edit/avatar/{$user->id}");

        $response->assertStatus(200);
        $response->assertViewIs('avatar');
        $response->assertViewHas(['user', 'avatarStub']);
    }

    public function testEditAvatarWithLoginedUserOnValidationSuccess()
    {
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);

        $this->actingAs($user)
             ->get("/edit/avatar/{$user->id}");

        $response = $this->post("/edit/avatar/$user->id", [

            'avatar' => UploadedFile::fake()->image('avata.jpg')  
        ]);

        $response->assertRedirect("/profile/$user->id");
    }

    public function testEditAvatarWithLoginedUserOnValidationError()
    {
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);

        $this->actingAs($user)
             ->get("/edit/avatar/{$user->id}");

        $response = $this->post("/edit/avatar/$user->id", [

            'avatar' => null
        ]);

        $response->assertRedirect("/edit/avatar/$user->id");
    }

    public function testAvatarPageWithLoggedOutUser()
    {
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);

        $response = $this->get("/edit/avatar/{$user->id}");

        $response->assertStatus(302);
        $response->assertRedirect('login');
    }

    

    public function testCreateUserPageWithLoginedUser()
    {
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);

        $user->role = 'admin';

        $response = $this->actingAs($user)
                         ->get("/create-user");

        $response->assertStatus(200);
        $response->assertViewIs('create-user');
        $response->assertViewHas(['statuses']);
    }

    public function testCreateUserWithLoginedUserOnValidationSuccess()
    {
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);

        $user->role = 'admin';

        $this->actingAs($user)
             ->get("/create-user");

        $response = $this->post('/create-user', [

            'name' => 'new name',
            'job' => 'new job',
            'phone' => '8 800 800 80 80',
            'address' => 'new address',
            'avatar' => UploadedFile::fake()->image('avata.jpg'),
            'vk' => 'vk',
            'telegram' => 'telegram',
            'instagram' => 'instagram',
        ]);

        
        $response->assertRedirect('/create-user');
    }


    public function testCreateUserPageWithLoginedUserButIsNotAdmin()
    {
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);

        $user->role = 'user';

        $response = $this->actingAs($user)
                         ->get("/create-user");
               
        $response->assertStatus(302);
        $response->assertRedirect('/');  
    }

    public function testCreateUserPageWithLoggedOutUser()
    {
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);

        $response = $this->get("/create-user");
            
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }



    public function testDeleteUser()
    {
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);
                
        $response = $this->actingAs($user)
                         ->get("/");

        $response->assertStatus(200);
        $response->assertViewIs('home');

        $this->assertDatabaseHas('users', [ 'id' => $user->id]);

        $this->get("/edit/delete-user/$user->id");

        $this->assertDatabaseMissing('users', [ 'id' => $user->id]);
    }
}
