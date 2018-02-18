<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Audio;
use AppBundle\Form\AudioType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

use getID3;

/**
 * Audio controller.
 *
 * @Route("/manage/audio")
 */
class AudioController extends Controller
{
    /**
     * Creates a new audio entity.
     *
     * @Route("/new", name="audio_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $audio = new Audio();
        $audio->setUser($this->getUser());
        $form = $this->createForm(AudioType::class, $audio, [
            'user' => $this->getUser(),
            'form_type' => AudioType::$TYPE_CREATE
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $getID3 = new getID3();

            $em = $this->getDoctrine()->getManager();
            $audio->setHash(hash_file('sha1', $audio->getAudioFile()));

            $audioInfo = $getID3->analyze($audio->getAudioFile());
            $audio->setLength((int) $audioInfo['playtime_seconds']);

            $em->persist($audio);
            $em->flush();

            return $this->redirectToRoute('manage_index');
        }

        return $this->render(':audio:upload.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing audio entity.
     *
     * @Route("/{id}/edit", name="audio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Audio $audio)
    {
        $deleteForm = $this->createDeleteForm($audio);
        $editForm = $this->createForm('AppBundle\Form\AudioType', $audio, [
            'user' => $this->getUser(),
            'form_type' => AudioType::$TYPE_UPDATE
        ]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($audio);
            $em->flush();

            return $this->redirectToRoute('manage_index');
        }

        return $this->render(':audio:edit.html.twig', array(
            'audio' => $audio,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a audio entity.
     *
     * @Route("/{id}", name="audio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Audio $audio)
    {
        $form = $this->createDeleteForm($audio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($audio);
            $em->flush();

            return $this->redirectToRoute('manage_index');
        }

        return $this->redirectToRoute('audio_index');
    }

    /**
     * Creates a form to delete a audio entity.
     *
     * @param Audio $audio The audio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Audio $audio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('audio_delete', array('id' => $audio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
