<?php

namespace App\Controller\Api\V1\Controller;

use App\Entity\Favorite;
use App\Form\FavoriteType;
use App\Repository\FavoriteRepository;
use App\Service\FavoriteChecker;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/favorite", name="api_v1_favorite_", requirements={"id"="\d+"})
 */
class FavoriteController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(FavoriteRepository $favoriteRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->json($favoriteRepository->findAll(), 200, [], ["groups" => "favorite_browse"]);
    }

    /**
     * @Route("/{id}", name="read", methods={"GET"})
     */
    public function read(Favorite $favorite)
    {
        $this->denyAccessUnlessGranted('FAVORITE_READ', $favorite);
        return $this->json($favorite, 200, [], ["groups" => "favorite_read"]);
    }

    /**
     * @Route("", name="add", methods={"POST"})
     */
    public function add(EntityManagerInterface $manager, Request $request, FavoriteRepository $favoriteRepository)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $favorite = new Favorite;
        $form = $this->createForm(FavoriteType::class, $favorite, ['csrf_protection' => false]);

        $json = $request->getContent();
        $jsonArray = json_decode($json, true);

        $form->submit($jsonArray);

        if ($form->isValid()) {

            // $favoriteCheck = $favoriteChecker->checkFavorite($form, $favoriteRepository);

            // dd($favoriteCheck);

            $manager->persist($favorite);
            $manager->flush();

            return $this->json($favorite, 200, [], ['groups' => ['favorite_read']]);
        }

        $errorMessages = (string) $form->getErrors(true);
        return $this->json($errorMessages, 400);
    }

    /**
     * @Route("/{id}", name="edit", methods={"PUT", "PATCH"})
     */
    public function edit(EntityManagerInterface $manager, Request $request, Favorite $favorite)
    {

        $this->denyAccessUnlessGranted('FAVORITE_EDIT', $favorite);

        $form = $this->createForm(FavoriteType::class, $favorite, ['csrf_protection' => false]);

        $json = $request->getContent();
        $jsonArray = json_decode($json, true);

        // dd($favorite->getUser());

        $form->submit($jsonArray);

        if ($form->isValid()) {
            $manager->flush();

            return $this->json($favorite, 200, [], ['groups' => ['favorite_read']]);
        }

        $errorMessages = (string) $form->getErrors(true);
        return $this->json($errorMessages, 400);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Favorite $favorite, EntityManagerInterface $manager)
    {

        $this->denyAccessUnlessGranted('FAVORITE_EDIT', $favorite);

        $manager->remove($favorite);
        $manager->flush();

        return $this->json(null, 204);
    }

    /**
     * Method to use in order to get the most favorite book
     * @Route("/mostfavorite", name="mostfavorite", methods={"GET"})
     */
    public function mostFavorite(FavoriteRepository $favoriteRepository): Response
    {
        $favorite = $favoriteRepository->findMostFavorite();
        // dd($favorite);

        return $this->json($favorite, 200, [], ['groups' => ['most_favorite']]);
    }
}
