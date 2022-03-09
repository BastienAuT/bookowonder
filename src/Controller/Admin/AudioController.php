<?php

namespace App\Controller\Admin;

use App\Entity\Audio;
use App\Form\AudioType;
use App\Form\Audio1Type;
use App\Service\ImageDeleter;
use App\Service\ImageUploader;
use App\Repository\AudioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/audio")
 *  @IsGranted("ROLE_ADMIN")
 */
class AudioController extends AbstractController
{
    /**
     * @Route("/", name="admin_audio_browse", methods={"GET"})
     */
    public function browse(AudioRepository $audioRepository): Response
    {
        return $this->render('admin/audio/browse.html.twig', [
            'audios' => $audioRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="admin_audio_add", methods={"GET", "POST"})
     */
    public function add(ImageUploader $uploader, Request $request, EntityManagerInterface $entityManager): Response
    {
        $audio = new Audio();
        $form = $this->createForm(AudioType::class, $audio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('image')->getData()){

                $uploader->uploadAudioImage($form);
            }
            $entityManager->persist($audio);
            $entityManager->flush();

            return $this->redirectToRoute('admin_audio_browse', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/audio/add.html.twig', [
            'audio' => $audio,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_audio_read", methods={"GET"})
     */
    public function read(Audio $audio): Response
    {
        return $this->render('admin/audio/read.html.twig', [
            'audio' => $audio,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_audio_edit", methods={"GET", "POST"})
     */
    public function edit(ImageUploader $uploader, Request $request, Audio $audio, EntityManagerInterface $entityManager, Filesystem $files, ImageDeleter $imageDeleter): Response
    {
        $form = $this->createForm(AudioType::class, $audio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('image')->getData()){
                // $imageDeleter->deleteAudioImage($audio, $files);
                $uploader->uploadAudioImage($form);
            }
            $entityManager->flush();

            return $this->redirectToRoute('admin_audio_browse', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/audio/edit.html.twig', [
            'audio' => $audio,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_audio_delete", methods={"POST"})
     */
    public function delete(Request $request, Audio $audio, EntityManagerInterface $entityManager, Filesystem $files, ImageDeleter $imageDeleter): Response
    {
        if ($this->isCsrfTokenValid('delete'.$audio->getId(), $request->request->get('_token'))) {
            // $imageDeleter->deleteAudioImage($audio, $files);
            $entityManager->remove($audio);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_audio_browse', [], Response::HTTP_SEE_OTHER);
    }
}
