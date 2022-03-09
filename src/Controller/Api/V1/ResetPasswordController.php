<?php

namespace App\Controller\Api\V1;

use App\Entity\ResetPassword;
use App\Entity\User;
use App\Form\ResetPasswordType;
use App\Service\MailJet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ResetPasswordController extends AbstractController
{

    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/api/v1/forgottenpassword", name="api_v1_forgotten_password", methods={"POST"})
     * 
     */
    public function forgottenPassword(Request $request): Response
    {
        //! si l'utilisateur est connecté, il a interdiction d'aller sur cette route ! ( il doit passer par son interface de compte pour reset son mdp )
        if($this->getUser()){
            return $this->json(["message" => "Vous êtes déjà connecté"], 400);
        }
        $jsonArray = json_decode($request->getContent(), true);
        $email = $jsonArray["email"];
;        if($email){
            $user = $this->manager->getRepository(User::class)->findOneByEmail($email);

            if($user){
                // On enregistre en BDD la demande de réinitialisation du mot de passe avec le mail de l'utilisateur, un token et une date de création ( moment où est passé la requete)
                $resetPassword = new ResetPassword();
                $resetPassword->setUser($user);
                $resetPassword->setToken(uniqid());
                $resetPassword->setCreatedAt(new \DateTimeImmutable());
                $this->manager->persist($resetPassword);
                $this->manager->flush();

                //on envoie l'email à l'utilisateur avec un lien pour mettre à jour le mot de passe
                // $_ENV['FRONT_URL'].
                
                $url = $_ENV['FRONT_URL']."/reinitialisation/mot-de-passe/".$resetPassword->getToken();
                // $url = $this->generateUrl('api_v1_reset_password', ['token' => $resetPassword->getToken()]);

                $content = "<h1>Demande de réinitialisation de votre mot de passe sur Book'O'Wonder</h1><br><br><br>";
                $content .= "<p>Bonjour ".$user->getName().", vous avez demandé à réinitialiser votre mot de passe sur le site Book'O'Wonder.<br> Vous pouvez cliquer sur ce lien pour <br><br> <a href='".$url ."'>réinitialiser votre mot de passe</a>  <br><br><strong> Si vous n'êtes pas l'auteur de cette demande, ne cliquez pas sur ce lien et ne tenez pas compte de cette demande.</strong><br>Par sécurité, vous pouvez changer votre mot de passe depuis le site dans l'onglet 'Mon Profil'</p>";

                $mail = new MailJet();
                $mail->send($user->getEmail(), $user->getName(), "Réinitialisez votre mot de passe sur Book'O'Wonder", $content);

                //! MAIL SEND, REDIRECTION JSON / MESSAGE JSON VERS PAGE LOGIN ? A vous de voir, les fronteux.
                return $this->json(["message" => "Mail send"], 200);
            }else {
                //! ADRESSE EMAIL INCONNUE, RETURN 400 JSON
                
                    return $this->json(["message" => "User inexistant"], 400);
                
            }

        }

        
            return $this->json(["message" => "Ca veut pas !"], 400);
        
    }

    /**
     * @Route("/api/v1/resetpassword/{token}", name="api_v1_reset_password")
     * 
     */
    public function resetPassword($token, Request $request, UserPasswordHasherInterface $userPasswordHasher){

        $resetPassword = $this->manager->getRepository(ResetPassword::class)->findOneByToken($token);
        if(!$resetPassword){
            //! RETURN 400 JSON ( erreur, le token n'existe pas ou est expiré)
            return $this->json(["message" => "Token false or expired"], 400);
        }

        $now = new \DateTimeImmutable();
        // on vérifie le createdAt si il est égal à maintenant - 3h, ici nous checkons d'abord le cas où le token est expiré
        if($now > $resetPassword->getCreatedAt()->modify('+3 hour')){
            //! TOKEN EXPIRE : RETURN 400 JSON
            return $this->json(["message" => "Token expired"], 400);
        }

        // on s'est assuré que le token n'est pas expiré : tout va bien :D 

        //! ICI, CA VEUT DIRE QUE L'UTILISATEUR A ACCES A UN FORMULAIRE COTE FRONT POUR RESET SON MDP : on se fie donc à la puissance de Symfo : ResetPasswordType ! Attention, il n'est pas lié à une entité car il ne contient seulement un double champ pour les mots de passes !
        $jsonArray = json_decode($request->getContent(), true);
        
        $form = $this->createForm(ResetPasswordType::class, null, ['csrf_protection' => false]); //! attention token csrf
        $form->submit($jsonArray);
        // return $this->json(["message" => "APRES HANDLEREQUEST FORM"], 400);

        if($form->isValid()){
            $newPassword = $form->get('password')->getData();
            $password = $userPasswordHasher->hashPassword($resetPassword->getUser(), $newPassword);
            $resetPassword->getUser()->setPassword($password);
            $this->manager->flush();

            //! RETURN JSON, TOUT EST BON ! Bravo, la souffritude est finie. On peut rediriger vers la page de login.

            return $this->json(["message" => "Mot de passe changé"], 200);


        }

        
        //! RETOURNER 400 JSON, COMME D'HAB
        return $this->json(["message" => "NEIN NEIN NEIN !"], 400);
    }


}
