<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Should load successfully.");
        $this->assertCount(1, $crawler->filter('#nav-login'), "Should include a link to login page.");
        $this->assertCount(1, $crawler->filter('#nav-register'), "Should include a link to register page.");
    }

    public function testListen()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/listen');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Should load successfully.");
        $this->assertCount(1, $crawler->filter('#playBtn'), "Should include a play button.");
    }
}
