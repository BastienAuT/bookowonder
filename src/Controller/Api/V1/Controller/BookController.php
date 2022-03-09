<?php

namespace App\Controller\Api\V1\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/book", name="api_v1_book_", requirements={"id"="\d+"})
 */
class BookController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(BookRepository $bookRepository): Response
    {
        return $this->json($bookRepository->findAll(), 200, [], ["groups" => "book_browse"]);
    }

    /**
     * @Route("/{id}", name="read", methods={"GET"})
     */
    public function read(Book $book)
    {
        return $this->json($book, 200, [], ["groups" => "book_read"]);
    }

    /**
     * @Route("/ishome", name="ishome", methods={"GET"})
     */
    public function isHome(BookRepository $bookRepository){

        // We get the booklist sorted by the one with the booleen isHome at true
        $book = $bookRepository->findBy(array('isHome' => 'true'));

        return $this->json($book, 200, [], ["groups" => "book_read"]);
    }

}
