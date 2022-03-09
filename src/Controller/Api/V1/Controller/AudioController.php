<?php

namespace App\Controller\Api\V1\Controller;

use App\Entity\Audio;
use App\Form\AudioType;
use App\Repository\AudioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/audio", name="api_v1_audio_", requirements={"id"="\d+"})
 */
class AudioController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(AudioRepository $audioRepository): Response
    {
        return $this->json($audioRepository->findAll(), 200, [], ["groups" => "audio_browse"]);
    }

    /**
     * @Route("/{id}", name="read", methods={"GET"})
     */
    public function read(Audio $audio)
    {

        return $this->json($audio, 200, [], ["groups" => "audio_read"]);
    }


    /**
     * @Route("/category", name="category", methods={"GET"})
     */
    public function orderByCategory(AudioRepository $audioRepository): Response
    {
        $audio = $audioRepository->findByCategory();

        return $this->json($audio, 200, [], ["groups" => "audio_browse"]);
    }
}
