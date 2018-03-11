<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\Traits\LoginTrait;

class ManageControllerTest extends WebTestCase
{
    use LoginTrait;

    public function testNew()
    {
        $client = static::createClient();

        $this->logIn($client);

        $crawler = $client->request('GET', '/manage/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Should load successfully.");
        $this->assertCount(1, $crawler->filter('#playlists'), "Should a list of playlists.");
        $this->assertCount(1, $crawler->filter('#new-audio'), "Should include a form for uploading new audio.");
    }
}
