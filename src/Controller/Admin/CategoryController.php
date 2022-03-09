<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Service\ImageDeleter;
use App\Service\ImageUploader;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/category")
 * @IsGranted("ROLE_ADMIN")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="admin_category_browse", methods={"GET"})
     */
    public function browse(CategoryRepository $categoryRepository): Response
    {
        return $this->render('admin/category/browse.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="admin_category_add", methods={"GET", "POST"})
     */
    public function add(Request $request, ImageUploader $uploader, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('image')->getData()){

                $uploader->uploadCategoryImage($form);
            }
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('admin_category_browse', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/category/add.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_category_read", methods={"GET"})
     */
    public function read(Category $category): Response
    {
        return $this->render('admin/category/read.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_category_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request,ImageUploader $uploader, Category $category, EntityManagerInterface $entityManager, Filesystem $files, ImageDeleter $imageDeleter): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('image')->getData()){

                // $imageDeleter->deleteCategoryImage($category, $files);
                $uploader->uploadCategoryImage($form);
            }
            $entityManager->flush();

            return $this->redirectToRoute('admin_category_browse', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_category_delete", methods={"POST"})
     */
    public function delete(Request $request, Category $category, EntityManagerInterface $entityManager, Filesystem $files, ImageDeleter $imageDeleter): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            // $imageDeleter->deleteCategoryImage($category, $files);
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_category_browse', [], Response::HTTP_SEE_OTHER);
    }
}
