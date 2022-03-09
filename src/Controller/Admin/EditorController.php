<?php

namespace App\Controller\Admin;

use App\Entity\Editor;
use App\Form\EditorType;
use App\Repository\EditorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/editor")
 * @IsGranted("ROLE_ADMIN")
 */
class EditorController extends AbstractController
{
    /**
     * @Route("/", name="admin_editor_browse", methods={"GET"})
     */
    public function browse(EditorRepository $editorRepository): Response
    {
        return $this->render('admin/editor/browse.html.twig', [
            'editors' => $editorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="admin_editor_add", methods={"GET", "POST"})
     */
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $editor = new Editor();
        $form = $this->createForm(EditorType::class, $editor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($editor);
            $entityManager->flush();

            return $this->redirectToRoute('admin_editor_browse', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/editor/add.html.twig', [
            'editor' => $editor,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_editor_read", methods={"GET"})
     */
    public function read(Editor $editor): Response
    {
        return $this->render('admin/editor/read.html.twig', [
            'editor' => $editor,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_editor_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Editor $editor, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EditorType::class, $editor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_editor_browse', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/editor/edit.html.twig', [
            'editor' => $editor,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_editor_delete", methods={"POST"})
     */
    public function delete(Request $request, Editor $editor, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$editor->getId(), $request->request->get('_token'))) {
            $entityManager->remove($editor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_editor_browse', [], Response::HTTP_SEE_OTHER);
    }
}
