<?php

namespace App\Controller\Api\V1\Controller;

use App\Entity\Recommendation;
use App\Form\RecommendationType;
use App\Repository\RecommendationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/recommendation", name="api_v1_recommendation_", requirements={"id"="\d+"})
 */
class RecommendationController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(RecommendationRepository $recommendationRepository): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->json($recommendationRepository->findAll(), 200, [], ["groups" => "recommendation_browse"]);
    }

    /**
     * @Route("/{id}", name="read", methods={"GET"})
     */
    public function read(Recommendation $recommendation)
    {
        // $this->denyAccessUnlessGranted('RECOMMENDATION_READ', $recommendation);

        return $this->json($recommendation, 200, [], ["groups" => "recommendation_read"]);
    }

    /**
     * @Route("", name="add", methods={"POST"})
     */
    public function add(EntityManagerInterface $manager, Request $request, RecommendationRepository $recommendation)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $recommendation = new Recommendation;
        $form = $this->createForm(RecommendationType::class, $recommendation, ['csrf_protection' => false]);

        $json = $request->getContent();
        $jsonArray = json_decode($json, true);

        $form->submit($jsonArray);


        if ($form->isValid()) {
            $manager->persist($recommendation);
            $manager->flush();

            return $this->json($recommendation, 200, [], ['groups' => ['recommendation_read']]);
        }

    
        $errorMessages = (string) $form->getErrors(true);
        return $this->json($errorMessages, 400);
    }

    /**
     * @Route("/{id}", name="edit", methods={"PUT", "PATCH"})
     */
    public function edit(EntityManagerInterface $manager, Request $request, Recommendation $recommendation)
    {
        $this->denyAccessUnlessGranted('RECOMMENDATION_EDIT', $recommendation);

        $form = $this->createForm(RecommendationType::class, $recommendation, ['csrf_protection' => false]);

        $json = $request->getContent();
        $jsonArray = json_decode($json, true);

        $form->submit($jsonArray);

        if ($form->isValid()) {
            $manager->flush();

            return $this->json($recommendation, 200, [], ['groups' => ['recommendation_read']]);
        }

        $errorMessages = (string) $form->getErrors(true);
        return $this->json($errorMessages, 400);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Recommendation $recommendation, EntityManagerInterface $manager)
    {
        $this->denyAccessUnlessGranted('RECOMMENDATION_EDIT', $recommendation);
        
        $manager->remove($recommendation);
        $manager->flush();

        return $this->json(null, 204);
    }

    /**
     * Method to use in order to get the most favorite book
     * 
     * @Route("/mostrecommendated", name="mostrecommendation", methods={"GET"})
     */
    public function mostRecommendated(RecommendationRepository $recommendationRepository): Response
    {
        $recommendation = $recommendationRepository->findMostRecommendated();
        // dd($recommendation);
        
        return $this->json($recommendation, 200, [], ['groups' => ['most_recommendated']]);
    }
}
