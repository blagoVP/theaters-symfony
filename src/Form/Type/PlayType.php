<?php

namespace App\Form\Type;

use App\Entity\Play;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $optins)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Theater Title:',
                'attr' => [
                    'maxlength' => 50,
                    'minlength' => 2,
                ],
            ])
            ->add('imageUrl', TextType::class, [
                'label' => 'Image url:',
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Theater Description:',
                'attr' => [
                    'maxlength' => 255,
                    'minlength' => 23,
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit theater',
                'attr' => [
                    'class' => 'btn',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Play::class,
            ]
        );
    }
}
