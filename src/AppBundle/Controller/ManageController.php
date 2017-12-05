<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Audio;
use AppBundle\Form\AudioType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Vich\UploaderBundle\Entity\File;
use getID3;

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

        return $this->render(':manage:index.html.twig', ['playlists' => $playlists]);
    }

    /**
     * @Route("/upload/", name="manage_upload")
     */
    public function uploadAction(Request $request)
    {
        $audio = new Audio();
        $audio->setUser($this->getUser());

        $form = $this->createForm(AudioType::class, $audio);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $getID3 = new getID3();
            $em = $this->getDoctrine()->getManager();

            $audio->setHash(hash_file('sha1', $audio->getAudioFile()));

            $audioInfo = $getID3->analyze($audio->getAudioFile());
            $audio->setLength((int) $audioInfo['playtime_seconds']);

            $em->persist($audio);
            $em->flush();
        }

        return $this->render(':manage:upload.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
