<?php

namespace AppBundle\Services;

use AppBundle\Model\Contact;

class Mailer
{
    protected $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendContactMessage(Contact $contact)
    {
        $to = 'kandiah.divan@gmail.com';
        $this->sendMessage($to, $contact);
    }

    public function sendMessage($to, Contact $contact)
    {
        $mail = \Swift_Message::newInstance();

        $mail
            ->setFrom($contact->getSender())
            ->setTo($to)
            ->setSubject($contact->getSubject())
            ->setBody($contact->getMessage())
            ->setContentType('text/html');

        $this->mailer->send($mail);
    }
}
