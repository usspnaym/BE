<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    public function test_register(){
        $response = $this->post('/api/auth/register',[
            'name' => 'test user',
            'account' => 'user',
            'password' => 'userpassword',
            'email' => 'user@admin.com'
        ]);
        echo $response->baseResponse;
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type'
        ]);
    }

    public function test_login(){
        $user = User::factory()->create();
        $response = $this->post('/api/auth/login', [
            'account' => $user->account,
            'password' => 'password'
        ]);

        echo $response->baseResponse;
        $response->assertStatus(200);
        $response->assertJsonStructure([

        ]);

    }
}
