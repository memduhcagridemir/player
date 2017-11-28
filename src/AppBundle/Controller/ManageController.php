<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Audio;
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
    public function indexAction()
    {
        return $this->render(':manage:upload.html.twig');
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
            // $file stores the uploaded PDF file
            /** @var \Symfony\Component\HttpFoundation\File\File $file */
            $file = $audio->getAudioFile();

            echo '<br/><br/><br/><br/><br/>' . $file->getFilename();
        }

        return $this->render(':manage:upload.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
