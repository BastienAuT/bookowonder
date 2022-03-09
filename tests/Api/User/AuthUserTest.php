<?php

namespace App\Tests\Api\User;

use PHPUnit\Framework\TestCase;

// we extends to our class to create a token
class AuthUserTest extends UserToken
{
    public function testUserProfil()
    {
        // We send the user connexion information to the class we created to create token
        $token = $this->getToken([
            'username' => 'admin@admin.com',
            'password' => 'admin'
        ]);

        // We send the new token in the client which has a bearer for auth
        $response = $this->createClientWithCredentials($token)->request('GET', '/api/v1/user/user');
        $this->assertResponseIsSuccessful();
    }
}
