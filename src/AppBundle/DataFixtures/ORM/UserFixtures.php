<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class UserFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($u = 0; $u < 4; $u++) {
            $user = new User();
            $user->setUsername("user_{$u}");
            $user->setPlainPassword('123');
            $user->setName("Name_{$u}");
            $user->setEmail("email{$u}@gmail.com");
            $user->setEnabled(true);
            $manager->persist($user);

            $this->addReference("User_{$u}", $user);
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
        return 1;
    }
}