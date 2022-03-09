<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Form\BookType;
use App\Entity\Favorite;
use App\Entity\Pinnedpage;
use App\Service\ImageDeleter;
use App\Entity\Recommendation;
use App\Service\ImageUploader;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/book")
 * @IsGranted("ROLE_ADMIN")
 */
class BookController extends AbstractController
{
    /**
     * @Route("/", name="admin_book_browse", methods={"GET"})
     */
    public function browse(BookRepository $bookRepository): Response
    {
        return $this->render('admin/book/browse.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="admin_book_add", methods={"GET", "POST"})
     */
    public function add(ImageUploader $uploader, Request $request, EntityManagerInterface $entityManager): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('picture')->getData()) {

                $uploader->uploadBookImage($form);
            }
            if ($form->get('frontPic')->getData()) {

                $uploader->uploadBookFrontImage($form);
            }
            if ($form->get('epub')->getData()) {

                $uploader->uploadEpub($form);
            }

            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('admin_book_browse', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/book/add.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_book_read", methods={"GET"})
     */
    public function read(Book $book): Response
    {
        return $this->render('admin/book/read.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_book_edit", methods={"GET", "POST"})
     */
    public function edit(ImageUploader $uploader, Request $request, Book $book, EntityManagerInterface $entityManager, Filesystem $files, ImageDeleter $imageDeleter): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('picture')->getData()) {
                // $imageDeleter->deleteBookCover($book, $files);
                $uploader->uploadBookImage($form);
                
            }
            if ($form->get('frontPic')->getData()) {
                // $imageDeleter->deleteBookFrontImage($book, $files);
                $uploader->uploadBookFrontImage($form);
            }
            if ($form->get('epub')->getData()) {
                // $imageDeleter->deleteBookEpub($book, $files);
                $uploader->uploadEpub($form);
            }

            $entityManager->flush();

            return $this->redirectToRoute('admin_book_browse', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/book/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_book_delete", methods={"POST"})
     */
    public function delete(Request $request, Book $book, EntityManagerInterface $entityManager, Filesystem $files, ImageDeleter $imageDeleter): Response
    {
        if ($this->isCsrfTokenValid('delete' . $book->getId(), $request->request->get('_token'))) {

            // On supprime toutes les relations qui empêchent la suppression d'un livre ( ça nettoie en même temps la base de données, ne laissant plus d'orphelins)

            if ($book->getRecommendations()) {
                $recommendations = $entityManager->getRepository(Recommendation::class)->findByBook($book->getId());

                foreach ($recommendations as $key => $recommendation) {

                    $entityManager->remove($recommendation);
                }
            }
            if ($book->getPinnedpages()) {
                $pinnedpages = $entityManager->getRepository(Pinnedpage::class)->findByBook($book->getId());

                foreach ($pinnedpages as $key => $pinnedpage) {

                    $entityManager->remove($pinnedpage);
                }
            }
            if ($book->getFavorites()) {
                $favorites = $entityManager->getRepository(Favorite::class)->findByBook($book->getId());

                foreach ($favorites as $key => $favorite) {

                    $entityManager->remove($favorite);
                }
            }

            // on supprime les fichiers liés au livre
            // $imageDeleter->deleteBookImages($book, $files);

            $entityManager->remove($book);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_book_browse', [], Response::HTTP_SEE_OTHER);
    }
}
