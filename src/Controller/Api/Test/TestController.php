<?php

namespace App\Controller\Api\Test;

use App\Entity\Recommendation;
use App\Form\RecommendationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RecommendationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/api/test/", name="api_test_")
 */
class TestController extends AbstractController
{
    /**
     * @Route("recommendation", name="recommendation")
     */
    public function recommendation(RecommendationRepository $recommendationRepository): Response
    {
        return $this->json($recommendationRepository->findAll(), 200, [], ['groups' => 'recommendation']);
    }

    /**
     * @Route("add", name="add", methods={"POST"})
     */
    public function addrecommendation(EntityManagerInterface $manager, Request $request, RecommendationRepository $recommendationRepository)
    {
        $recommendation = new Recommendation;
        $form = $this->createForm(RecommendationType::class, $recommendation, ['csrf_protection' => false]);


        $json = $request->getContent();
        $jsonArray = json_decode($json, true);

        $form->submit($jsonArray);

        if ($form->isValid()) {
            $manager->persist($recommendation);
            $manager->flush();

            return $this->json($recommendation, 200, [], [
                'groups' => ['recommendation'],
            ]);
        }

        $errorMessages = (string) $form->getErrors(true);
        return $this->json($errorMessages, 400);
    }
}
