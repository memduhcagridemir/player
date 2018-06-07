<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Playlist;
use AppBundle\Form\PlaylistType;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\View\View;
use AppBundle\Exception\InvalidFormException;

/**
 * Playlist REST controller.
 *
 * @Route("/api/playlist")
 */
class PlaylistRestController extends FOSRestController
{
    /**
     * @FOSRest\Get("/", name="rest_playlist_list")
     */
    public function listAction()
    {
        $playlists = $this->getDoctrine()->getRepository('AppBundle:Playlist')->findAll();
        if ($playlists === null) {
            return new View("there are no playlists exist", Response::HTTP_NOT_FOUND);
        }
        return $playlists;
    }

    /**
     * @FOSRest\Get("/{id}", name="rest_playlist_get")
     */
    public function getAction(int $id)
    {
        $playlist = $this->getDoctrine()->getRepository('AppBundle:Playlist')->findOneBy(["id" => $id]);
        if ($playlist === null) {
            return new View("there are no playlists exist", Response::HTTP_NOT_FOUND);
        }
        return $playlist;
    }

    private function processForm(Playlist $playlist, array $data, $method = 'PUT') {
        $form = $this->createForm("AppBundle\Form\PlaylistType", $playlist, ['method' => $method, 'csrf_protection' => false]);

        $form->submit($data, 'PATCH' !== $method);

        if ($form->isValid()) {
            /** @var Playlist $playlist */
            $playlist = $form->getData();

            $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(['id' => 9]);
            $playlist->setUser($user); // TODO

            /** @var \Doctrine\Common\Persistence\ObjectManager $em */
            $em = $this->getDoctrine()->getManager();
            $em->persist($playlist);
            $em->flush();

            return $playlist;
        }

        throw new InvalidFormException($form);
    }

    /**
     * @FOSRest\Post("/", name="rest_playlist_new")
     */
    public function newAction(Request $request)
    {
        try {
            $playlist = $this->processForm(new Playlist(), $request->request->all(), 'POST');

            $routeOptions = [ 'id' => $playlist->getId(), '_format' => $request->get('_format') ];
            return $this->routeRedirectView('rest_playlist_get', $routeOptions, Response::HTTP_CREATED);
        }
        catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
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

        return $this->render(':playlist:edit.html.twig', array(
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

        return $this->render(':playlist:delete.html.twig', [
            'playlist' => $playlist,
            'form' => $form->createView()
        ]);
    }
}
