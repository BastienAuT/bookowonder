<?php

namespace App\Controller\Api\V1;

use App\Entity\User;
use App\Form\RegisterType;
use App\Service\MailJet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/api/v1/register", name="api_v1_register", methods={"POST"})
     */
    public function add(Request $request, UserPasswordHasherInterface $userPasswordHasher)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user, ['csrf_protection' => false]);
        $jsonArray = json_decode($request->getContent(), true);
        // dd($jsonArray);
        $form->submit($jsonArray);

        if ($form->isValid()) {

            // on vérifie que l'email est unique ( normalement c'est le cas vu notre configuration Symfony sur les users)
            $searchEmail = $this->manager->getRepository(User::class)->findOneByEmail($user->getEmail());

            if (!$searchEmail) {
                $password = $form->get('password')->getData();
                $hashedPassword = $userPasswordHasher->hashPassword($user, $password);

                $user->setPassword($hashedPassword);

                $this->manager->persist($user);
                $this->manager->flush();

                $mail = new MailJet();
                $content = "<h1>Bienvenue sur Book'O'Wonder, " . $user->getName() . "</h1><br><br><br>";
                $content .= "<p>Vous pouvez désormais vous connecter au site et profiter de toutes nos fonctionnalités, comme la mise en favoris de vos livres préférés et retourner à votre dernier point de lecture !</p><br><br><p><a href='".$_ENV['FRONT_URL']."/connexion'>Se connecter sur Book'O'Wonder</a></p>";
                $mail->send($user->getEmail(), $user->getName(), "Bienvenue sur Book'O'Wonder !", $content);

                // ! Envoyer dans le json un message qui indique que la connexion s'est bien passée

                return $this->json($user, 201, [], [
                    'groups' => ['user_read'],
                ]);
            } else {
                // ! Envoyer dans le json un message qui indique que le mail est déjà utilisé
                $errorMessages = [];
                foreach ($form->getErrors(true) as $error) {
                    $errorMessages[] = [
                        'message' => $error->getMessage(),
                        'property' => $error->getOrigin()->getName(),
                    ];
                }

                return $this->json($errorMessages, 400);
            }
        }

        $errorMessages = [];
        foreach ($form->getErrors(true) as $error) {
            $errorMessages[] = [
                'message' => $error->getMessage(),
                'property' => $error->getOrigin()->getName(),
            ];
        }

        return $this->json($errorMessages, 400);
    }
}
