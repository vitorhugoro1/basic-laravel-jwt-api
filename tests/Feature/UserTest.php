<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanLoginAndGetSelfData()
    {
        $user = factory(User::class)->create();

        $response = $this->json('POST', route('auth.login'), [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
        ]);

        $data = $response->decodeResponseJson();

        $token = $data['access_token'];

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->json('GET', route('auth.me'));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'created_at',
            'updated_at',
            'deleted_at',
        ]);

        $response->assertJsonFragment($user->only(['id', 'name', 'email']));
    }
}
