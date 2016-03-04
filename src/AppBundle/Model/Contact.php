<?php

namespace AppBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * @Assert\NotBlank(message="validation.contact.sender")
     * @Assert\Email()
     */
    public $sender;

    /**
     * @Assert\NotBlank(message = "validation.contact.subject")
     * @Assert\Length(min = 10, max = 50)
     */
    public $subject;

    /**
     * @Assert\NotBlank(message = "validation.contact.message")
     */
    public $message;

    /**
     * @return mixed
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param mixed $sender
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
}
