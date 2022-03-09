<?php

namespace App\Controller\Admin;

use App\Entity\Favorite;
use App\Form\FavoriteType;
use App\Repository\FavoriteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/favorite")
 * @IsGranted("ROLE_ADMIN")
 */
class FavoriteController extends AbstractController
{
    /**
     * @Route("/", name="admin_favorite_browse", methods={"GET"})
     */
    public function browse(FavoriteRepository $favoriteRepository): Response
    {
        return $this->render('admin/favorite/browse.html.twig', [
            'favorites' => $favoriteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="admin_favorite_add", methods={"GET", "POST"})
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $favorite = new Favorite();
        $form = $this->createForm(FavoriteType::class, $favorite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($favorite);
            $entityManager->flush();

            return $this->redirectToRoute('admin_favorite_browse', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/favorite/add.html.twig', [
            'favorite' => $favorite,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_favorite_read", methods={"GET"})
     */
    public function read(Favorite $favorite): Response
    {
        return $this->render('admin/favorite/read.html.twig', [
            'favorite' => $favorite,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_favorite_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Favorite $favorite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FavoriteType::class, $favorite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_favorite_browse', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/favorite/edit.html.twig', [
            'favorite' => $favorite,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_favorite_delete", methods={"POST"})
     */
    public function delete(Request $request, Favorite $favorite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$favorite->getId(), $request->request->get('_token'))) {
            $entityManager->remove($favorite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_favorite_browse', [], Response::HTTP_SEE_OTHER);
    }
}
