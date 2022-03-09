<?php
namespace App\Controller\Api\Test;
use App\Entity\User;
use App\Form\RegisterType;
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
     * @Route("/api/register", name="api_v1_register")
     */
    public function add(Request $request, UserPasswordHasherInterface $userPasswordHasher)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user, ['csrf_protection' => false]);
        $jsonArray = json_decode($request->getContent(), true);
        $form->submit($jsonArray);
        if($form->isValid()) {
            $password = $form->get('password')->getData();
            $hashedPassword = $userPasswordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);
            $this->manager->persist($user);
            $this->manager->flush();
            return $this->json($user, 201, [], [
                // 'groups' => ['tvshow_read'],
            ]);
        }
        // Pour fournir une liste des messages d'erreur un peu mieux faite,
        // on crée un tableau vide dans lequel on ajoute un tableau associatif
        // avec tous les messages d'erreur pour chaque champs du formulaire
        // accompagné du nom del a propriété concerné par l'erreur
        $errorMessages = [];
        foreach($form->getErrors(true) as $error) {
            $errorMessages[] = [
                'message' => $error->getMessage(),
                'property' => $error->getOrigin()->getName(),
            ];
        }
        // Avant on utilisait (string) pour transformer l'objet en string
        // Maintenant on utilise la boucle ci-dessus
        // $errorMessages = (string) $form->getErrors(true);
        // $errorMessages = $form->getErrors(true)->__toString();
        return $this->json($errorMessages, 400);
    }
}