<?php

namespace App\Tests\Api\User;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use PHPUnit\Framework\TestCase;

// This class is use to create a token for a user
class UserToken extends ApiTestCase
{
    private $token;
    private $clientWithCredentials;

    // We send the token in the user through the bearer
    protected function createClientWithCredentials($token = null): Client
    {
        $token = $token ?: $this->getToken();

        return static::createClient([], ['headers' => ['authorization' => 'Bearer ' . $token]]);
    }

    // Methode to create a token
    protected function getToken($json = []): string
    {
        // If a token already existe, send it back
        if ($this->token) {
            return $this->token;
        }
        // We give the user send in parameter through the login_check, if no user is send, we use the default one
        $response = static::createClient()->request('POST', '/api/login_check', ['json' => $json ?: [
            'username' => 'admin@admin.com',
            'password' => 'admin',
        ]]);

        $this->assertResponseIsSuccessful();
        // We get the token that has been createed
        $data = json_decode($response->getContent());
        // We increment it in the token variable
        $this->token = $data->token;

        // And we send it back to us it
        return $data->token;
    }
}
