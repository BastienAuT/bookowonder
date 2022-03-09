<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Component\Panther\PantherTestCase;

class BackofficeAccessTest extends PantherTestCase
{
    public function testBackofficeAccess(): void
    {
        $client = static::createClient();

        // when not logged in, must redirect to /login
        $crawler = $client->request('GET', '/');
        $this->assertResponseRedirects("/login");
        $crawler = $client->request('GET', '/admin/user/1');
        $this->assertResponseRedirects("/login");


        // we check that only admins can use the backoffice
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->findOneBy(['email' => 'admin@admin.com']); // ROLE_ADMIN
        $client->loginUser($user);
        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $client->request('GET', '/admin/user/1');
        $this->assertResponseIsSuccessful();

        // we check that users of the frontoffice can't use the backoffice
        $user = $userRepository->findOneBy(['email' => 'user@user.com']); // ROLE_USER
        $client->loginUser($user);
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(403);
        $client->request('GET', '/admin/user/1');
        $this->assertResponseStatusCodeSame(403);
        

    }
}
