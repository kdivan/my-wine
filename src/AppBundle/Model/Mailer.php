<?php

namespace AppBundle\Model;

use Doctrine\ORM\EntityManager;

class Mailer
{
    protected $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendContactMessage($contact)
    {
        $from = 'kandiah.divan@gmail.com';
        $to = 'kdivan@hotmail.fr';
        $subject = 'Formulaire de contact';
        $body ='Hi!';
        $this->sendMessage($from, $to, $subject, $body);
    }

    public function sendMessage($from, $to, $subject, $body)
    {
        $mail = \Swift_Message::newInstance();

        $mail
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($body)
            ->setContentType('text/html');

        $this->mailer->send($mail);
    }
}
