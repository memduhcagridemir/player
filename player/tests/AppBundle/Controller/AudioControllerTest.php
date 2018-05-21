<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tests\Traits\LoginTrait;

class AudioControllerTest extends WebTestCase
{
    use LoginTrait;

    public function testNew()
    {
        $client = static::createClient();
        $this->logIn($client);

        $crawler = $client->request('GET', '/manage/');
        $this->assertCount(0, $crawler->filter('div#all tr.audio'), "Number of audios should be 0 before upload.");

        $crawler = $client->request('GET', '/manage/audio/new');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "New audio form should be displayed.");

        $form = $crawler->filter('form[name=appbundle_audio]')->form();
        $form['appbundle_audio[audioFile]'] = new UploadedFile(
            './uploads/test.mp3',
            'test.mp3',
            'audio/mpeg',
            198658
        );
        $client->submit($form);
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Successful upload should redirect to manage index.");

        $crawler = $client->request('GET', '/manage/');
        $this->assertCount(1, $crawler->filter('div#all tr.audio'), "Number of audios should be 1 after upload.");
    }

    public function testEdit()
    {
        $client = static::createClient();
        $this->logIn($client);

        $crawler = $client->request('GET', '/manage/');
        $this->assertCount(1, $crawler->filter('div#all tr.audio'), "Number of audios should be 1 before edit.");

        $crawler = $client->request('GET', '/manage/audio/69/edit');

        // TODO :: complete this function

    }

    public function testDelete()
    {
        $client = static::createClient();
        $this->logIn($client);

        $crawler = $client->request('GET', '/manage/');
        $this->assertCount(1, $crawler->filter('div#all tr.audio'), "Number of audios should be 1 before delete.");

        $form = $crawler->filter('div#all tr.audio .delete-form')->form();
        $client->submit($form);
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Should redirect to manage index.");

        $crawler = $client->request('GET', '/manage/');
        $this->assertCount(0, $crawler->filter('div#all tr.audio'), "Number of audios should be 0 after deletion.");
    }
}
