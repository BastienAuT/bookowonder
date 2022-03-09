<?php

namespace App\Controller\Api\V1\Controller;

use App\Entity\Pinnedpage;
use App\Form\PinnedpageType;
use App\Repository\PinnedpageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/pinnedpage", name="api_v1_pinnedpage_", requirements={"id"="\d+"})
 */
class PinnedpageController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(PinnedpageRepository $pinnedpageRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->json($pinnedpageRepository->findAll(), 200, [], ["groups" => "pinnedpage_browse"]);
    }

    /**
     * @Route("/{id}", name="read", methods={"GET"})
     */
    public function read(Pinnedpage $pinnedpage)
    {
        $this->denyAccessUnlessGranted('PINNEDPAGE_READ', $pinnedpage);

        return $this->json($pinnedpage, 200, [], ["groups" => "pinnedpage_read"]);
    }

    /**
     * @Route("", name="add", methods={"POST"})
     */
    public function add(EntityManagerInterface $manager, Request $request, PinnedpageRepository $pinnedpage)
    {

        $this->denyAccessUnlessGranted('ROLE_USER');

        $pinnedpage = new Pinnedpage;
        $form = $this->createForm(PinnedpageType::class, $pinnedpage, ['csrf_protection' => false]);

        $json = $request->getContent();
        $jsonArray = json_decode($json, true);

        $form->submit($jsonArray);

        if ($form->isValid()) {
            $manager->persist($pinnedpage);
            $manager->flush();

            return $this->json($pinnedpage, 200, [], ['groups' => ['pinnedpage_read']]);
        }

        $errorMessages = (string) $form->getErrors(true);
        return $this->json($errorMessages, 400);
    }

    /**
     * @Route("/{id}", name="edit", methods={"PUT", "PATCH"})
     */
    public function edit(EntityManagerInterface $manager, Request $request, Pinnedpage $pinnedpage)
    {
        $this->denyAccessUnlessGranted('PINNEDPAGE_EDIT', $pinnedpage);

        $form = $this->createForm(PinnedpageType::class, $pinnedpage, ['csrf_protection' => false]);

        $json = $request->getContent();
        $jsonArray = json_decode($json, true);

        $form->submit($jsonArray);

        if ($form->isValid()) {
            $manager->flush();

            return $this->json($pinnedpage, 200, [], ['groups' => ['pinnedpage_read']]);
        }

        $errorMessages = (string) $form->getErrors(true);
        return $this->json($errorMessages, 400);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Pinnedpage $pinnedpage, EntityManagerInterface $manager)
    {

        $this->denyAccessUnlessGranted('PINNEDPAGE_EDIT', $pinnedpage);

        $manager->remove($pinnedpage);
        $manager->flush();

        return $this->json(null, 204);
    }

    /**
     * Method to use in order to get the most pinned book
     * 
     * @Route("/mostpinned", name="mostpinned", methods={"GET"})
     */
    public function mostPinned(PinnedpageRepository $pinnedpageRepository): Response
    {
        $pinnedpage = $pinnedpageRepository->findMostPinned();

        return $this->json($pinnedpage, 200, [], ['groups' => ['most_pinned']]);
    }

   
}
