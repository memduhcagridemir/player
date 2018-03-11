<?php

namespace Tests\Traits;

use AppBundle\Entity\User;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

trait LoginTrait
{
    /**
     * Log in logic for tests.
     *
     * @param Client $client
     */
    private function logIn($client)
    {
        $session = $client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'main';

        /** @var User $user */
        $user = $client->getContainer()->get('doctrine')->getRepository('AppBundle:User')->findOneByEmail('email1@gmail.com');

        $token = new UsernamePasswordToken($user, null, $firewallContext, ['ROLE_ADMIN']);
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
    }
}