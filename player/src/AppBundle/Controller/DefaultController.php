<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render(':default:index.html.twig');
    }

    /**
     * @Route("/listen", name="listen")
     */
    public function listenAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if($this->getUser()) {
            $playlists = $em->getRepository('AppBundle:Playlist')->findBy([
                'user' => $this->getUser()
            ]);
        }
        else {
            $user = $em->getRepository('AppBundle:User')->findOneBy(['username' => 'public']);
            $playlists = $em->getRepository('AppBundle:Playlist')->findBy([
                'user' => $user
            ]);
        }

        return $this->render(':default:listen.html.twig', [
            'playlists' => $playlists
        ]);
    }
}
