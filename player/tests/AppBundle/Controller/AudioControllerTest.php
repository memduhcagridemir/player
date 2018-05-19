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
        $numberOfAudiosBefore = $crawler->filter('div#all tr.audio')->count();

        $crawler = $client->request('GET', '/manage/audio/new');
        $audio = new UploadedFile(
            './uploads/test.mp3',
            'test.mp3',
            'audio/mpeg',
            198658
        );

        $form = $crawler->filter('form[name=appbundle_audio]')->form();
        $form['appbundle_audio[audioFile]'] = $audio;
        $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Should redirect to manage index.");

        $crawler = $client->request('GET', '/manage/');
        $this->assertEquals($numberOfAudiosBefore + 1, $crawler->filter('div#all tr.audio')->count(), 'Number of audios should be 1 more after upload.');
    }

    public function testEdit()
    {
        $client = static::createClient();

        $this->logIn($client);

        $crawler = $client->request('GET', '/manage/');
        $this->assertEquals(1, $crawler->filter('div#all tr.audio')->count(), "# of audios should be 1")

        // TODO :: complete this function

    }

    public function testDelete()
    {
        $client = static::createClient();

        $this->logIn($client);

        $crawler = $client->request('GET', '/manage/');
        $numberOfAudiosBefore = $crawler->filter('div#all tr.audio')->count();

        $this->assertGreaterThan(0, $numberOfAudiosBefore, 'Number of audios should be more than 0 before delete.');

        $form = $crawler->filter('div#all tr.audio .delete-form')->form();
        $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Should redirect to manage index.");

        $crawler = $client->request('GET', '/manage/');
        $this->assertEquals($numberOfAudiosBefore - 1, $crawler->filter('div#all tr.audio')->count(), 'Number of audios should be 1 less after upload.');
    }
}
