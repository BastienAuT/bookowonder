<?php

namespace App\Tests\Api\Controller;

use App\Entity\Book;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

// Here we test the common road, accessible from everyone
class ApiControllerTest extends ApiTestCase
{

    public function testBookSecurity(): void
    {
        // We check if one guest user get  to the main page
        $response = static::createClient()->request('GET', '/api/v1/book');
        $this->assertResponseIsSuccessful();

        // We check if one guest user get to the synopsis
        $response = static::createClient()->request('GET', '/api/v1/book/1');
        $this->assertResponseIsSuccessful();

        // We check if one guest user get the book on home page
        $response = static::createClient()->request('GET', '/api/v1/book/ishome');
        $this->assertResponseIsSuccessful();
    }

    public function testAudioSecurity(): void
    {
        // We check if one guest user can get all the audio
        $response = static::createClient()->request('GET', '/api/v1/audio');
        $this->assertResponseIsSuccessful();

        // We check if one guest user get to the synopsis
        $response = static::createClient()->request('GET', '/api/v1/audio/1');
        $this->assertResponseIsSuccessful();
    }

    /**
     */
    public function testRecommendation(): void
    {
        // We check if one guest user can see all the recommendation on a book
        $response = static::createClient()->request('GET', '/api/v1/recommendation');
        $this->assertResponseIsSuccessful();

        // We check if one guest user can se one recommendation on a book
        $response = static::createClient()->request('GET', '/api/v1/recommendation/1');
        $this->assertResponseIsSuccessful();

        // We check if one guest cannot create a recommendation if he is not connected
        $response = static::createClient()->request('POST', '/api/v1/recommendation');
        $this->assertResponseStatusCodeSame(401);
    }
}
