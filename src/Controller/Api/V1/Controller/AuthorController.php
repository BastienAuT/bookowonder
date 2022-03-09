<?php

namespace App\Controller\Api\V1\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/author", name="api_v1_author_", requirements={"id"="\d+"})
 */
class AuthorController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(AuthorRepository $authorRepository): Response
    {
        return $this->json($authorRepository->findAll(), 200, [], ["groups" => "author_browse"]);
    }

    /**
     * @Route("/{id}", name="read", methods={"GET"})
     */
    public function read(Author $author)
    {

        return $this->json($author, 200, [], ["groups" => "author_read"]);
    }

}
