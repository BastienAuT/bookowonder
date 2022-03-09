<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Favorite;
use App\Service\MailJet;
use App\Entity\Pinnedpage;
use App\Service\ImageDeleter;
use App\Entity\Recommendation;
use App\Entity\ResetPassword;
use App\Repository\ResetPasswordRepository;
use App\Service\ImageUploader;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @Route("/admin/user")
 * @IsGranted("ROLE_ADMIN")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="admin_user_browse", methods={"GET"})
     */
    public function browse(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/browse.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="admin_user_add", methods={"GET", "POST"})
     */
    public function add(ImageUploader $imageUploader, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $searchEmail = $entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());

            if (!$searchEmail) {
                $mail = new MailJet();
                $content = "<h1>Bienvenue sur Book'O'Wonder, " . $user->getName() . "</h1>";
                $content .= "<p>Vous pouvez désormais vous connecter au site et profiter de toutes nos fonctionnalités, comme la mise en favoris de vos livres      préférés, et retourner à votre dernier point de lecture !</p>";
                $mail->send($user->getEmail(), $user->getName(), "Bienvenue sur Book'O'Wonder !", $content);
                if ($form->get('profilePic')->getData()) {

                    $imageUploader->uploadUserAvatar($form);
                }
                $password = $form->get('password')->getData();
                $hashedPassword = $userPasswordHasher->hashPassword($user, $password);
                $user->setPassword($hashedPassword);
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('admin_user_browse', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('admin/user/add.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_user_read", methods={"GET"})
     */
    public function read(User $user): Response
    {
        return $this->render('admin/user/read.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_user_edit", methods={"GET", "POST"})
     */
    public function edit(ImageUploader $imageUploader, Request $request, User $user, EntityManagerInterface $entityManager, ImageDeleter $imageDeleter, Filesystem $files): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('profilePic')->getData()) {
                $imageDeleter->deleteImage($user, $files);
                $imageUploader->uploadUserAvatar($form);
            }
            $entityManager->flush();

            return $this->redirectToRoute('admin_user_browse', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager, ImageDeleter $imageDeleter, Filesystem $files): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {

            // On supprime toutes les relations qui empêchent la suppression d'un utilisateur ( ça nettoie en même temps la base de données, ne laissant plus d'orphelins)

            if ($user->getRecommendations()) {
                $recommendations = $entityManager->getRepository(Recommendation::class)->findByUser($user->getId());

                foreach ($recommendations as $key => $recommendation) {

                    $entityManager->remove($recommendation);
                }
            }
            if ($user->getPinnedpages()) {
                $pinnedpages = $entityManager->getRepository(Pinnedpage::class)->findByUser($user->getId());

                foreach ($pinnedpages as $key => $pinnedpage) {

                    $entityManager->remove($pinnedpage);
                }
            }
            if ($user->getFavorites()) {
                $favorites = $entityManager->getRepository(Favorite::class)->findByUser($user->getId());

                foreach ($favorites as $key => $favorite) {

                    $entityManager->remove($favorite);
                }
            }

            $resetpasswords = $entityManager->getRepository(ResetPassword::class)->findByUser($user->getId());
            if ($resetpasswords) {
                foreach ($resetpasswords as $key => $resetpassword) {

                    $entityManager->remove($resetpassword);
                }
            }




            // $imageDeleter->deleteImage($user, $files);

            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_user_browse', [], Response::HTTP_SEE_OTHER);
    }
}
