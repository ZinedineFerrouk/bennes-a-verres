<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner un prénom.']),
                    new Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => 'Le prénom doit faire {{ limit }} caractères minimum.',
                        'maxMessage' => 'Le prénom doit faire {{ limit }} caractères maximum.'

                    ])
                ]
            ])

            ->add('name', TextType::class, [
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

            ->add('email', RepeatedType::class, [
                'type' => EmailType::class,
                'invalid_message' => 'Les deux adresses e-mail doivent être identique.',
                'attr' => ['autocomplete' => 'new-email'],
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner une adresse e-mail.']),
                    new Email(['message' => 'Veuillez renseigner une adresse e-mail valide.'])
                ]
            ])


            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent être identique.',
                'attr' => ['autocomplete' => 'new-password'],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un mot de passe.',
                    ]),
                    new Length([
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new Regex([
                        'pattern' => "^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}^",
                        'message' => 'Votre mot de passe doit contenir au moins 8 caractères, un chiffre et une lettre.'
                    ])
                ]
            ])


            ->add('phone', TelType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '^(\\+33|0|0033)[1-9][0-9]{8}^',
                        'message' => 'Votre numéro de téléphone n\'est pas un numéro valide.'
                    ]),
                ]
            ])

            ->add('organization', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new Length([
                        'min' => 1,
                        'max' => 255,
                        'minMessage' => 'Votre nom doit faire {{ limit }} caractères minimum.',
                        'maxMessage' => 'Votre nom doit faire {{ limit }} caractères maximum.'

                    ])
                ]
            ])

            ->add('kbis', FileType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                            'image/webp',

                            'application/pdf',
                            'application/x-pdf'
                        ],
                        'mimeTypesMessage' => 'Le format du fichier n\'est pas valide.',
                        'maxSizeMessage' => 'La taille du fichier dépasse la limite de 1024 Ko.'
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
