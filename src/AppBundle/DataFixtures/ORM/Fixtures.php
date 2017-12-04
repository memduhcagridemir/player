<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Playlist;
use AppBundle\Entity\User;
use AppBundle\Entity\Audio;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 3; $i++) {
            $user = new User();
            $user->setUsername('name_' . $i);
            $user->setPlainPassword('123');
            $user->setName('name_' . $i);
            $user->setEmail('email@gmail.com' . $i);
            $user->setEnabled(true);

            for ($h = 0; $h < 3; $h++) {
                $playlist = new Playlist();
                $playlist->setUser($user);
                $playlist->setName('platlist_' . $h);

                for ($c = 0; $c < 3; $c++) {
                    $file = new Audio();
                    $file->setName('song' . $c);
                    $file->setHash('123_' . $c);
                    $file->setLength(22);
                    $file->setUser($user);
                    $file->setSize(123);
                    $file->setMimeType('aws');
                    $file->setOriginalName('qwe');
                    $manager->persist($file);
                }

                $manager->persist($playlist);
            }
            $manager->persist($user);
        }

        $manager->flush();
    }
}