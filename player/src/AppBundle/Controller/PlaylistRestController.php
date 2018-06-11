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
    public function listAction(Request $request)
    {
        $limit = $request->get('limit') ?? 10;
        $offset = $request->get('offset') ?? 0;

        return $this->getDoctrine()->getRepository('AppBundle:Playlist')->findBy([], null, $limit, $offset);
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
     * @FOSRest\Post("/", name="rest_playlist_post")
     */
    public function postAction(Request $request)
    {
        try {
            $playlist = $this->processForm(new Playlist(), $request->request->all(), $request->getMethod());

            $routeOptions = [ 'id' => $playlist->getId(), '_format' => $request->get('_format') ];
            return $this->routeRedirectView('rest_playlist_get', $routeOptions, Response::HTTP_CREATED);
        }
        catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
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

    /**
     * @FOSRest\Put("/{id}", name="rest_playlist_put")
     */
    public function putAction(Request $request)
    {
        try {
            /** @var Playlist $playlist */
            $playlist = $this->getDoctrine()->getRepository('AppBundle:Playlist')->findOneBy([ 'id' => $request->get('id') ]);
            $playlist = $this->processForm($playlist, $request->request->all(), $request->getMethod());

            $routeOptions = [ 'id' => $playlist->getId(), '_format' => $request->get('_format') ];
            return $this->routeRedirectView('rest_playlist_get', $routeOptions, Response::HTTP_CREATED);
        }
        catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

    /**
     * @FOSRest\Patch("/{id}", name="rest_playlist_patch")
     */
    public function patchAction(Request $request)
    {
        try {
            /** @var Playlist $playlist */
            $playlist = $this->getDoctrine()->getRepository('AppBundle:Playlist')->findOneBy([ 'id' => $request->get('id') ]);
            $playlist = $this->processForm($playlist, $request->request->all(), $request->getMethod());

            $routeOptions = [ 'id' => $playlist->getId(), '_format' => $request->get('_format') ];
            return $this->routeRedirectView('rest_playlist_get', $routeOptions, Response::HTTP_CREATED);
        }
        catch (InvalidFormException $exception) {
            return $exception->getForm();
        }
    }

    /**
     * Deletes a playlist entity.
     *
     * @FOSRest\Delete("/{id}", name="rest_playlist_delete")
     */
    public function deleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $playlist = $em->getRepository('AppBundle:Playlist')->findOneBy(["id" => $request->get('id')]);
        if ($playlist === null) {
            return new View("there are no playlists exist", Response::HTTP_NOT_FOUND);
        }

        $playlist->remove();
        $em->flush();

        return new View("", Response::HTTP_OK);
    }
}
