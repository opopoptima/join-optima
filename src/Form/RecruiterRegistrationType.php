<?php

namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RecruiterRegistrationType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', null, [
                'attr' => [
                    'placeholder' => 'Email'
                ],
                'label' => false,
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les champs du mot de passe doivent correspondre.',
                'required' => true,
                'label' => false,
                'first_options' => ['label' => false, 'attr' => ['placeholder' => 'Password']],
                'second_options' => ['label' => false, 'attr' => ['placeholder' => 'Repeat Password']],
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('fName', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'First name'
                ],
            ])
            ->add('lName', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Last name'
                ],
            ])
            ->add('sexe', ChoiceType::class, [
                'label' => 'Sexe',
                'empty_data' => null,
                'choices' => ['Homme'=>'Homme','Femme'=>'Femme','Autre'=>'Autre'],
                'data'=>null,
                'required'    => false,

                'attr' => [
                    'placeholder' => 'Sexe'
                ],
                'constraints' => [
                    new NotBlank()
                ],
            ])
             ->add('nationality', null, [
                'label' => 'Nationalité',

                'constraints' => [
                    new NotBlank()
                ],
            ])
            ->add('phone', TelType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Phone number'
                ],
            ])
            ->add('adress', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Adresse'
                ],
            ])
            ->add('birthday', null, [
                'widget' => 'single_text',
                'label' => 'Birthdate'
            ])
            ->add('img', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Image',
                'constraints' => [
                    new Image()
                ]
            
            ])
             ->add('accept_data', null, [
                'label' => 'En soumettant ce forrnulaire, j\'accepte que mes données personnelles soient utilisées dans le cadre du cycle de recrutement.',
                'constraints' => [
                    new NotBlank()
                ]

            ])
            ->add('Envoyer', SubmitType::class, [
                'label' => 'Add'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
