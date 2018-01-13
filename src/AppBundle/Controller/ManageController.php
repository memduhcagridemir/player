<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Audio;
use AppBundle\Entity\Playlist;
use AppBundle\Form\AudioType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Vich\UploaderBundle\Entity\File;


/**
 * @Route("/manage")
 */
class ManageController extends Controller
{
    /**
     * @Route("/", name="manage_index", defaults={"folder" = "4"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /** $playlists =  */
        $playlists = $em->getRepository('AppBundle:Playlist')->findBy(['user' => $this->getUser()->getId()]);

        $playlist = new Playlist();
        $playlist->setName('All');

        $audios = $em->getRepository('AppBundle:Audio')->findBy(['user' => $this->getUser()->getId()]);
        foreach($audios as &$audio) {
            $playlist->addAudio($audio);
        }
        $playlists[] = $playlist;

        return $this->render(':manage:index.html.twig', ['playlists' => $playlists]);
    }
}
