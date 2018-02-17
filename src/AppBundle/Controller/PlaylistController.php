<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Audio;
use AppBundle\Entity\Playlist;
use AppBundle\Form\AudioType;
use AppBundle\Form\PlaylistType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Audio controller.
 *
 * @Route("/manage/playlist")
 */
class PlaylistController extends Controller
{
    /**
     * Creates a new playlist entity.
     *
     * @Route("/new", name="playlist_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $playlist = new Playlist();
        $playlist->setUser($this->getUser());
        $form = $this->createForm(PlaylistType::class, $playlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($playlist);
            $em->flush();

            return $this->redirectToRoute('manage_index');
        }

        return $this->render(':manage:playlist_new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing playlist entity.
     *
     * @Route("/{id}/edit", name="playlist_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Playlist $playlist)
    {
        $editForm = $this->createForm('AppBundle\Form\PlaylistType', $playlist);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('manage_index');
        }

        return $this->render(':manage:playlist_edit.html.twig', array(
            'playlist' => $playlist,
            'form' => $editForm->createView()
        ));
    }

    /**
     * Deletes a playlist entity.
     *
     * @Route("/{id}", name="playlist_delete")
     * @Method({"GET", "DELETE"})
     */
    public function deleteAction(Request $request, Playlist $playlist)
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('playlist_delete', array('id' => $playlist->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($playlist);
            $em->flush();

            return $this->redirectToRoute('manage_index');
        }

        return $this->render(':manage:playlist_delete.html.twig', [
            'playlist' => $playlist,
            'form' => $form->createView()
        ]);
    }
}
