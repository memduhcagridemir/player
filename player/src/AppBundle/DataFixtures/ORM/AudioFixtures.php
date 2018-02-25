<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Audio;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class AudioFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($u = 0; $u < 4; $u++) {
            for($p = 0; $p < 4; $p++) {
                for ($a = 0; $a < 4; $a++) {
                    $file = new Audio();
                    $file->setName("Audio_{$u}{$p}{$a}");
                    $file->setHash("xyz_{$a}");
                    $file->setLength(94);
                    $file->setUser($this->getReference("User_{$u}"));
                    $file->setSize(1536);
                    $file->setMimeType('audio/mpeg');
                    $file->setFilename('audio.mp3');
                    $file->setOriginalName('audio.mp3');
                    $manager->persist($file);

                    $this->addReference("Audio_{$u}{$p}{$a}", $file);
                }
            }
        }

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 2;
    }
}