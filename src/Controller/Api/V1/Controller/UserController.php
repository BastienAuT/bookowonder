<?php

namespace App\Controller\Api\V1\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\ImageDeleter;
use App\Repository\UserRepository;
use App\Service\ImageUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;

/**
 * @Route("/api/v1/user", name="api_v1_user_", requirements={"id"="\d+"})
 */
class UserController extends AbstractController
{
    /**
     * @Route("", name="browse", methods={"GET"})
     */
    public function browse(UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->json($userRepository->findAll(), 200, [], ["groups" => "user_browse"]);
    }

    /**
     * @Route("/user", name="read", methods={"GET"})
     */
    public function read()
    {
        $user = $this->getUser();

        return $this->json($user, 200, [], ["groups" => "user_read"]);
    }


    /**
     * @Route("/{id}", name="edit", methods={"PUT", "PATCH"})
     */
    public function edit(EntityManagerInterface $manager, Request $request, User $user, ImageUploader $imageUploader, ImageDeleter $imageDeleter, Filesystem $files)
    {
        $this->denyAccessUnlessGranted('USER_EDIT', $user);

        $form = $this->createForm(UserType::class, $user, ['csrf_protection' => false]);

        //$request->file()
        $json = $request->getContent();
        $jsonArray = json_decode($json, true);

        $form->submit($jsonArray);

        if ($form->isSubmitted() && $form->isValid()) {
            // We check if there is data in the form
            if ($form->get('profilePic')->getData()) {

                // If there is a picture, we delete the old one from the folder
                $imageDeleter->deleteImage($user, $files);
                // And we upload the new one from the form
                $imageUploader->uploadUserAvatar($form);
            }

            // We send every thing in the data base
            $manager->flush();

            return $this->json($user, 200, [], ['groups' => ['user_read']]);
        }

        $errorMessages = (string) $form->getErrors(true);
        return $this->json($errorMessages, 400);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(User $user, EntityManagerInterface $manager, ImageDeleter $imageDeleter, Filesystem $files)
    {
        $this->denyAccessUnlessGranted('USER_EDIT', $user);

        // We delete the image in the folder too, we don't wan't to keep it
        $imageDeleter->deleteImage($user, $files);

        $manager->remove($user);
        $manager->flush();

        return $this->json(null, 204);
    }

    /**
     * @Route("/profilpic/{id}", name="profilpic", methods={"PUT", "PATCH"})
     */
    public function editProfilPic(User $user, ImageDeleter $imageDeleter, Request $request, Filesystem $filesystem, EntityManagerInterface $manager)
    {
        
        // We provent connexion from other user
        $this->denyAccessUnlessGranted('USER_EDIT', $user);

        
            
        

        // If the front send us the file
        if ($request->files->get('profilePic')) {

            // We get the new file(not through a form this time)
            $uploadedFile = $request->files->get('profilePic');

            // We rename the new file 
            $newFilename = uniqid() . '.' . $uploadedFile->guessExtension();;

            // We upload the new profile pic in the folder with its new name
            $uploadedFile->move($_ENV['IMAGES_FOLDER'], $newFilename);

            //we delete the old profilPic
            $imageDeleter->deleteImage($user, $filesystem);

            // We set the new profilePic name
            $user->setProfilePic($newFilename);

            $manager->flush();

            return $this->json(["message" => "The profile picture has been change"], 201);
        }

        return $this->json(["message" => "The profile picture upload has failed"], 400);
    }
}
