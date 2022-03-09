<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/author")
 * @IsGranted("ROLE_ADMIN")
 */
class AuthorController extends AbstractController
{
    /**
     * @Route("/", name="admin_author_browse", methods={"GET"})
     */
    public function browse(AuthorRepository $authorRepository): Response
    {
        return $this->render('admin/author/browse.html.twig', [
            'authors' => $authorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="admin_author_add", methods={"GET", "POST"})
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($author);
            $entityManager->flush();

            return $this->redirectToRoute('admin_author_browse', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/author/add.html.twig', [
            'author' => $author,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_author_read", methods={"GET"})
     */
    public function read(Author $author): Response
    {
        return $this->render('admin/author/read.html.twig', [
            'author' => $author,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_author_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Author $author, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_author_browse', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/author/edit.html.twig', [
            'author' => $author,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_author_delete", methods={"POST"})
     */
    public function delete(Request $request, Author $author, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$author->getId(), $request->request->get('_token'))) {
            $entityManager->remove($author);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_author_browse', [], Response::HTTP_SEE_OTHER);
    }
}
