<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sender', EmailType::class, array('label' => 'contact.sender', 'required' => false))
            ->add('subject', TextType::class, array('label' => 'contact.subject', 'required' => false))
            ->add('message', TextareaType::class, array('label' => 'contact.message', 'required' => false))
            ->add('send', SubmitType::class, array('label' => 'contact.submit'))
        ;
    }

    public function getName()
    {
        return 'contact';
    }
}
