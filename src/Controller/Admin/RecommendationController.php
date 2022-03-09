<?php

namespace App\Controller\Admin;

use App\Entity\Recommendation;
use App\Form\RecommendationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RecommendationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/recommendation")
 * @IsGranted("ROLE_ADMIN")
 */
class RecommendationController extends AbstractController
{
    /**
     * @Route("/", name="admin_recommendation_browse", methods={"GET"})
     */
    public function browse(RecommendationRepository $recommendationRepository): Response
    {
        return $this->render('admin/recommendation/browse.html.twig', [
            'recommendations' => $recommendationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="admin_recommendation_add", methods={"GET", "POST"})
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $recommendation = new Recommendation();
        $form = $this->createForm(RecommendationType::class, $recommendation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($recommendation);
            $entityManager->flush();

            return $this->redirectToRoute('admin_recommendation_browse', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/recommendation/add.html.twig', [
            'recommendation' => $recommendation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_recommendation_read", methods={"GET"})
     */
    public function read(Recommendation $recommendation): Response
    {
        return $this->render('admin/recommendation/read.html.twig', [
            'recommendation' => $recommendation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_recommendation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Recommendation $recommendation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RecommendationType::class, $recommendation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_recommendation_browse', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/recommendation/edit.html.twig', [
            'recommendation' => $recommendation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_recommendation_delete", methods={"POST"})
     */
    public function delete(Request $request, Recommendation $recommendation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recommendation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($recommendation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_recommendation_browse', [], Response::HTTP_SEE_OTHER);
    }
}
