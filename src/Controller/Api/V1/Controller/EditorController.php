<?php

namespace App\Controller\Api\V1\Controller;

use App\Entity\Editor;
use App\Form\EditorType;
use App\Repository\EditorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/editor", name="api_v1_editor_", requirements={"id"="\d+"})
 */
class EditorController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(EditorRepository $editorRepository): Response
    {
        return $this->json($editorRepository->findAll(), 200, [], ["groups" => "editor_browse"]);
    }

    /**
     * @Route("/{id}", name="read", methods={"GET"})
     */
    public function read(Editor $editor)
    {

        return $this->json($editor, 200, [], ["groups" => "editor_read"]);
    }

}
