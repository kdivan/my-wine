<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BottleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('vineyard')
            ->add('winemaking')
            ->add('buyingPrice')
            ->add('vintage', TextType::class)
            ->add('capacity')
            ->add('currency')
            ->add('image_file', FileType::class)
            ->add('bottleType', EntityType::class, array(
                'class' => 'AppBundle\Entity\BottleType',
                'choice_label' => 'label',
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Bottle',
            'bottleTypes' => 'defaultvalue'
        ));
    }
}
