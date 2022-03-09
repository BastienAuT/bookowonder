<?php

namespace App\Controller\Api\V1\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/category", name="api_v1_category_", requirements={"id"="\d+"})
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(CategoryRepository $categoryRepository): Response
    {
        return $this->json($categoryRepository->findAll(), 200, [], ["groups" => "category_browse"]);
    }

    /**
     * @Route("/{id}", name="read", methods={"GET"})
     */
    public function read(Category $category)
    {
        return $this->json($category, 200, [], ["groups" => "category_read"]);
    }

    // ---------------------------------------------------------------------------
    // -------------------------------- AUDIO ------------------------------------
    // ---------------------------------------------------------------------------

    /**
     * @Route("/audio", name="browseAudio", methods={"GET"})
     */
    public function browseAudio(CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findAll();

        return $this->json($category, 200, [], ["groups" => "category_readAudio"]);
    }

    /**
     * @Route("/audio/{id}", name="readAudio", methods={"GET"})
     */
    public function readAudio(Category $category)
    {
        return $this->json($category, 200, [], ["groups" => "category_readAudio"]);
    }

    // ---------------------------------------------------------------------------
    // ---------------------------------------------------------------------------
    // ---------------------------------------------------------------------------

    /**
     * Method to use in order to get the most read category
     * 
     * @Route("/mostread", name="mostread", methods={"GET"})
     */
    public function mostReadCategory(CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findMostRead();

        // dd($category);

        return $this->json($category, 200, [], ['groups' => ['most_read_category']]);
    }
}
