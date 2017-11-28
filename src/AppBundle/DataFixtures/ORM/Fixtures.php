<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use AppBundle\Entity\AudioFile;

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
            $manager->persist($user);

            for ($h = 0; $h < 3; $h++) {
                $file = new AudioFile();
                $file->setName('song' . $h);
                $file->setHash('123_' . $h);
                $file->setLength(22);
                $file->setUser($user);
                $manager->persist($file);
            }
        }

        $manager->flush();
    }
}