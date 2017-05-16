<?php

namespace AppBundle\Service;

use Symfony\Component\Routing\Annotation\Route;

/**
 * Created by PhpStorm.
 * User: francois
 * Date: 13/04/2017
 * Time: 16:17
 */
class Mailer
{
    private $mailer;

    private $email;

    private $twig;

    public function __construct
    (
        \Swift_Mailer $mailer,
        $email,
        \Twig_Environment $twig
    )
    {
        $this->mailer = $mailer;
        $this->email = $email;
        $this->twig = $twig;
    }

    public function sendContactEmail($message){

        $renderContact = $this->twig->render('Emails/contact.html.twig',[
            'nom' => $message['nom'],
            'prenom' => $message['prenom'],
            'email' => $message['email'],
            'message' => $message['message'],
        ]);

        $mail = \Swift_Message::newInstance()
            ->setSubject('Contact de '.$message['nom'].' '.$message['prenom'])
            ->addFrom($this->email)
            ->addTo($this->email)
            ->setBody($renderContact, 'text/html');

        return $this->mailer->send($mail);
    }
}