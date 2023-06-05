<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Vos mots de passe doivent être identique.',
                'attr' => ['autocomplete' => 'new-password'],
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrez un mot de passe.',]),
                    new Length(['max' => 4096]),
                    new Regex([
                        'pattern' => "^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}^",
                        'message' => 'Votre mot de passe doit contenir au moins 8 caractères, un chiffre et une lettre.'
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
