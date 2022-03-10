<?php

namespace Tests\Unit;

use App\Profile;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A basic test example.
     *
     * @return void
     */


    public function setUp()
    {
        parent::setUp();
        

    }

     /** @test */

     
    public function testGetStatuses()
    {   
        $statuses =
        [   
            'online' => 'онлайн',
            'moved_away' => 'отошел',
            'not_disturb' => 'не беспокоить'
        ];

        $result = User::getStatuses();

        $this->assertSame($statuses, $result);
    }

   
    public function testEditMainInfoById()
    {   
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);
        
        $this->actingAs($user);

        $name = 'new name';

        $data = [

            'job' => 'new job',
            'phone' => '8 800 800 80 80',
            'address' => 'new address',
            'vk' => 'vk',
            'telegram' => 'tel',
            'instagram' => 'insta',
        ];

        User::editMainInfoById($user->id, $name,  $data);

        $this->assertDatabaseHas('users', [

            "id" => $user->id,
            'name' => 'new name',
            'email' => $user->email,
            'password' => $user->password,
            'role' => $user->role,
        ]);

        $this->assertDatabaseHas('profiles', [
            
            'user_id' => $user->id,
            'job' => 'new job',
            'phone' => '8 800 800 80 80',
            'address' => 'new address',
            'vk' => 'vk',
            'telegram' => 'tel',
            'instagram' => 'insta',
        ]);
    }

    public function testEditSecurityInfoByIdWithLoginedUser()
    {
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);
                
        $this->actingAs($user);

        $email = 'test@mail.ru';
        $password = 'secret';

        User::editSecurityInfoById($user->id, $email, $password);

        $this->assertDatabaseHas('users', [

            'id' => $user->id,
            'email' => 'test@mail.ru',
        ]);
    }

    public  function testEditStatusById()
    {
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);
        
        $this->actingAs($user);
        $this->assertEquals('online', $user->profile->status);

        $status = 'not_disturb';
             
        User::editStatusById($user->id, $status);

        $this->assertDatabaseHas('profiles', [

            'user_id' => $user->id,
            'status' => 'not_disturb',
        ]);
    }


    public function testEditAvatarById()
    {   
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);

        $this->actingAs($user);

        Storage::fake('local');
        $avatar = UploadedFile::fake()->image('avatar.jpg');
    

        $response = $this->json('POST', "/edit/avatar/$user->id", [
            'avatar' => $avatar
        ]);

        User::editAvatarById($user->id, $avatar);
        
        $this->assertDatabaseHas('profiles', [

            'user_id' => $user->id,
            'avatar' => 'uploads/' . $avatar->hashName()
        ]);

        Storage::disk('local')->assertExists('uploads/' . $avatar->hashName());
    }


    public function  testCreateNewUser()
    {
        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);

        $user->role = 'admin';
        $this->actingAs($user);

        Storage::fake('local');
        $avatar = UploadedFile::fake()->image('avatar.jpg');
        
        $response = $this->json('POST', '/create-user', [
            'avatar' => $avatar
        ]);

        $userData = [

            'name' => 'new name',
            'email' => 'new@mail.ru',
            'password' => 'secret'
        ];

        $profileData = [
            
            'job' => 'new job',
            'phone' => '8 800 800 80 80',
            'address' => 'new address',
            'status' => 'online',
            'avatar' => $avatar,
            'vk' => 'vk',
            'telegram' => 'tel',
            'instagram' => 'insta',
        ];

        $userId = User::createNewUser($userData);
                  Profile::create($profileData, $userId);

        $this->assertDatabaseHas('users', [

            'name' => 'new name',
            'email' => 'new@mail.ru',
        ]);
        
        $this->assertDatabaseHas('profiles', [

            'user_id' => $userId,
            'job' => 'new job',
            'phone' => '8 800 800 80 80',
            'address' => 'new address',
            'status' => 'online',
            'avatar' => 'uploads/' . $avatar->hashName(),
            'vk' => 'vk',
            'telegram' => 'tel',
            'instagram' => 'insta',
        ]);

        Storage::disk('local')->assertExists('uploads/' . $avatar->hashName());
    }

}