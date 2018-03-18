<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/manage")
 * @Security("has_role('ROLE_USER')")
 */
class ManageController extends Controller
{
    /**
     * @Route("/", name="manage_index")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $playlists = $em->getRepository('AppBundle:Playlist')->findBy(['user' => $this->getUser()->getId()], ['createdAt' => 'DESC']);
        return $this->render(':manage:index.html.twig', [
            'playlists' => $playlists,
            'user' => $this->getUser()
        ]);
    }
}
