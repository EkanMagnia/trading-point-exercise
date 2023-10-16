<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuoteControllerTest extends WebTestCase
{
    public function testFormAndData(): void
    {
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request('GET', '/');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Quotes');

    }
}