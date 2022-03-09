<?php

namespace App\Service;

use Mailjet\Client;
use Mailjet\Resources;

class MailJet
{

    private $api_key = "273140371f6397ca4a657d7cef33f5e1";
    private $api_key_secret = "35a68ae060228ed68e782e4f0b3532f7";

    public function send(string $toEmail, string $toName, string $subject, string $content)
    {

        $mj = new Client($this->api_key, $this->api_key_secret, true, ['version' => 'v3.1']);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "bookowonder.website@gmail.com",
                        'Name' => "Book O Wonder"
                    ],
                    'To' => [
                        [
                            'Email' => $toEmail,
                            'Name' => $toName
                        ]
                    ],
                    'TemplateID' => 3411098,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content,
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }

    
}
