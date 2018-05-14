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
        $this->assertEquals(0, $crawler->filter('div#all tr.audio')->count(), 'Number of audios should be zero before upload.');

        $crawler = $client->request('GET', '/manage/audio/new');

        $audio = new UploadedFile(
            './uploads/test.mp3',
            'test.mp3',
            'audio/mpeg',
            198658
        );

        $form = $crawler->filter('form[name=appbundle_audio]')->form();

        // set some values
        $form['appbundle_audio[audioFile]'] = $audio;

        // submit the form
        $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Should redirect to manage index.");

        $crawler = $client->request('GET', '/manage/');
        $this->assertEquals(1, $crawler->filter('div#all tr.audio')->count(), 'Number of audios should be 1 after upload.');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $this->logIn($client);

        $crawler = $client->request('GET', '/manage/');
        $this->assertEquals(1, $crawler->filter('div#all tr.audio')->count(), 'Number of audios should be zero before upload.');

        // TODO :: complete this function.
    }
}
