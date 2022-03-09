<?php

namespace App\Controller\Api\V1\Controller;

use App\Service\MailJet;
use App\Form\ContactFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/v1/contact", name="api_v1_contact_", requirements={"id"="\d+"})
 */
class ContactController extends AbstractController
{

    /**
     * @Route("", name="send", methods={"POST"})
     */
    public function send(Request $request)
    {

        $form = $this->createForm(ContactFormType::class, [], ['csrf_protection' => false]);

        $jsonArray = json_decode($request->getContent(), true);

        // dd($jsonArray['email']);
        $form->submit($jsonArray);

        if ($form->isSubmitted() && $form->isValid()) {

            $mail = new MailJet();
                $content = "<h1>Mail de la part de " . $jsonArray['email'] ." - ". $jsonArray['username']. "</h1>";
                $content .= "<p>". $jsonArray['content'] ."</p>";
                $mail->send("bookowonder.website@gmail.com", "Book O Wonder CONTACT", $jsonArray['object'], $content);

            return $this->json("l'email a bien été envoyé", 200);
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
