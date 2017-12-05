<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Playlist;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class PlaylistFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($u = 0; $u < 4; $u++) {
            for ($p = 0; $p < 4; $p++) {
                $playlist = new Playlist();
                $playlist->setUser($this->getReference("User_{$u}"));

                for($a=0; $a<4; $a++) {
                    $playlist->addAudio($this->getReference("Audio_{$u}{$p}{$a}"));
                }
                $playlist->setName("Playlist_{$p}");
                $manager->persist($playlist);
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
        return 3;
    }
}