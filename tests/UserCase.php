<?php

namespace Tests;

use App\Models\User;

trait UserCase
{
    /**
     * @var string|null
     */
    protected $jwtKey;

    /**
     * @var \App\Models\User
     */
    protected $user;

    /**
     * This generated an jwt key for active user
     *
     * @return void
     */
    protected function generateJwtKey()
    {
        if (is_null($this->user)) {
            $this->user = factory(User::class)->create();
        }

        $response = $this->json('POST', route('auth.login'), [
            'email' => $this->user->email,
            'password' => 'secret',
        ]);

        $data = $response->decodeResponseJson();

        $this->jwtKey = $data['access_token'];
    }
}
