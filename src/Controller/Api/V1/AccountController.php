<?php

namespace App\Controller\Api\V1;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ChangePasswordFromAccountType;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/api/v1/account", name="api_v1_account")
     */
    public function UserByEmail(UserRepository $userRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
        $json = $request->getContent();
        $email = json_decode($json, true);

        // dd($email);

        $user = $userRepository->findOneBy($email);

        return $this->json($user, 200, [], ['groups' => ['user_read']]);
    }

    /**
     * @Route("/api/v1/account/changepassword", name="api_v1_account_changepassword", methods={"PATCH"})
     */
    public function changePassword( Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
        $user = $this->getUser();
        

        $form = $this->createForm(ChangePasswordFromAccountType::class, $user, ['csrf_protection' => false]);

        $jsonArray = json_decode($request->getContent(), true,);
        // dd($jsonArray);
        $form->submit($jsonArray);

        if($form->isValid()) {
            $oldPassword = $form->get('old_password')->getData();
            if($userPasswordHasher->isPasswordValid($user, $oldPassword)){

                $newPassword = $form->get("new_password")->getData();
                $password = $userPasswordHasher->hashPassword($user, $newPassword);

                $user->setPassword($password);

                $entityManager->flush();

                return $this->json($user, 200, [], ['groups' => ['user_read']]);
            }
            $errorMessages = (string) $form->getErrors(true);
            return $this->json($errorMessages, 400);

        }


        $errorMessages = (string) $form->getErrors(true);
        return $this->json($errorMessages, 400);
    }
}
