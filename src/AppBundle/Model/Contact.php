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
}
