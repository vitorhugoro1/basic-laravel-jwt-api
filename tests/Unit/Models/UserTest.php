<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @var \App\Models\User */
    protected $user;

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCanCreate()
    {
        $response = $this->json('POST', route('users.store'), [
            'name' => 'Vitor',
            'email' => 'vmerencio@uplexis.com.br',
            'password' => 'secret',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'name',
                'email',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function testCanNotCreate()
    {
        $response = $this->json('POST', route('users.store'), [
            'name' => '',
            'email' => 'uhsaush@suha@',
            'password' => 'secret',
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'name',
            'email',
        ]);
    }

    public function testCanSeeUser()
    {
        factory(User::class, 3)->create();

        $response = $this->json('POST', route('auth.login'), [
            'email' => $this->user->email,
            'password' => 'secret',
        ]);

        $data = $response->decodeResponseJson();

        $token = $data['access_token'];

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->json('GET', route('users.show', User::all()->pluck('id')->random()));

        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'created_at',
            'updated_at',
            'deleted_at',
        ]);
    }
}
