<?php

namespace App\Controller\Admin;

use App\Entity\Pinnedpage;
use App\Form\PinnedpageType;
use App\Repository\PinnedpageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/pinnedpage")
 * @IsGranted("ROLE_ADMIN")
 */
class PinnedpageController extends AbstractController
{
    /**
     * @Route("/", name="admin_pinnedpage_browse", methods={"GET"})
     */
    public function browse(PinnedpageRepository $pinnedpageRepository): Response
    {
        return $this->render('admin/pinnedpage/browse.html.twig', [
            'pinnedpages' => $pinnedpageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="admin_pinnedpage_add", methods={"GET", "POST"})
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pinnedpage = new Pinnedpage();
        $form = $this->createForm(PinnedpageType::class, $pinnedpage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pinnedpage);
            $entityManager->flush();

            return $this->redirectToRoute('admin_pinnedpage_browse', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/pinnedpage/add.html.twig', [
            'pinnedpage' => $pinnedpage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_pinnedpage_read", methods={"GET"})
     */
    public function read(Pinnedpage $pinnedpage): Response
    {
        return $this->render('admin/pinnedpage/read.html.twig', [
            'pinnedpage' => $pinnedpage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_pinnedpage_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Pinnedpage $pinnedpage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PinnedpageType::class, $pinnedpage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_pinnedpage_browse', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/pinnedpage/edit.html.twig', [
            'pinnedpage' => $pinnedpage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_pinnedpage_delete", methods={"POST"})
     */
    public function delete(Request $request, Pinnedpage $pinnedpage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pinnedpage->getId(), $request->request->get('_token'))) {
            $entityManager->remove($pinnedpage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_pinnedpage_browse', [], Response::HTTP_SEE_OTHER);
    }
}
