<?php

namespace AppBundle\Model;

class ContactSender
{
    private $mailer;
    private $to;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function setTo($to)
    {
        $this->to = $to;
    }

    public function sendContactEmail(Contact $contact)
    {
        $message = \Swift_Message::newInstance();
        $message->setTo('admin@mywine.com');
        $message->setSubject($contact->subject);
        $message->setBody($contact->message);
        $message->setFrom($contact->sender);

        $this->mailer->send($message);
    }
}
