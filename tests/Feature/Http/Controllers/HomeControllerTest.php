<?php

namespace Tests\Feature\Http\Controllers;

use App\Profile;
use App\User;
use Tests\TestCase;


class HomeControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndexWithLoginedUser()
    {   
        // $this->withoutMiddleware(Authenticate::class);

        $user = factory(User::class)->create();
                factory(Profile::class)->create(['user_id' => $user->id]);
        
        
        $response = $this->actingAs($user)
                         ->get('/');
        
        $response->assertStatus(200);
        $response->assertViewIs('home');
        $response->assertViewHas('users');
    }


    public function testIndexWithLogeedOutUser()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
        $response->assertRedirect('login');
    }
}
