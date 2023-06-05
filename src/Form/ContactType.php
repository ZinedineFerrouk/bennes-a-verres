<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', TextType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner un nom.']),
                    new Length([
                        'min' => 1,
                        'max' => 255,
                        'minMessage' => 'Le nom doit faire {{ limit }} caractères minimum.',
                        'maxMessage' => 'Le nom doit faire {{ limit }} caractères maximum.'

                    ])
                ]
            ])
            ->add('firstName', TextType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner un prénom.']),
                    new Length([
                        'min' => 1,
                        'max' => 255,
                        'minMessage' => 'Le prénom doit faire {{ limit }} caractères minimum.',
                        'maxMessage' => 'Le prénom doit faire {{ limit }} caractères maximum.'

                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner une adresse mail.']),
                    new Email(['message' => 'Veuillez renseigner une adresse mail valide.'])
                ]
            ])
            ->add('subject', TextType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner un sujet.']),
                    new Length([
                        'min' => 5,
                        'max' => 255,
                        'minMessage' => 'Le sujet doit faire {{ limit }} caractères minimum.',
                        'maxMessage' => 'Le sujet doit faire {{ limit }} caractères maximum.'

                    ])
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner un message.']),
                    new Length([
                        'min' => 25,
                        'max' => 255,
                        'minMessage' => 'Le message doit faire {{ limit }} caractères minimum.',
                        'maxMessage' => 'Le message doit faire {{ limit }} caractères maximum.'

                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
