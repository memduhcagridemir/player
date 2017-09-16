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
        return $this->render('AppBundle::index.html.twig');
    }

    /**
     * @Route("/listen", name="listen")
     */
    public function listenAction(Request $request)
    {
        return $this->render('AppBundle::listen.html.twig');
    }
}
