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
        return $this->render('::index.html.twig');
    }

    /**
     * @Route("/listen", name="listen")
     */
    public function listenAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $playlists = $em->getRepository('AppBundle:Playlist')->findBy([
            'user' => $this->getUser()
        ]);

        return $this->render('::listen.html.twig', [
            'playlists' => $playlists
        ]);
    }
}
