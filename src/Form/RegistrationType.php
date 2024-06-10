<?php

namespace App\Form;

use App\Entity\RecruitmentSession;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Expression;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationType extends AbstractType
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $recruitmentSession = $this->em->getRepository(RecruitmentSession::class)->findOneBy(['current' => true]);
        $depChoiceMaxNbre = $recruitmentSession->getDepChoiceMaxNbre();

        $builder
            ->add('email', null, [

                'label' => 'Email',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les champs du mot de passe doivent correspondre.',
                'required' => true,
                'label' => 'Mot de passe',
                'first_options' => ['label' => 'Mot de passe', ],
                'second_options' => ['label' => 'Confirmer mot de passe', ],
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 5120,
                    ]),
                ],
            ])
            ->add('lName', null, [
                'label' => 'Nom',
                'constraints' => [
                    new NotBlank()
                ]

            ])
            ->add('fName', null, [
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank()
                ]

            ])
            ->add('birthday', null, [
                'widget' => 'single_text',
                'label' => 'Date de naissance',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('sexe', ChoiceType::class, [
                'label' => 'Sexe',
                'empty_data' => null,
                'choices' => ['Homme'=>'Homme','Femme'=>'Femme'],
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
                'label' => 'Numéro de téléphone',
                'help' => 'Votre numéro doit être de la forme suivante : +216XXXXXXXX.',


            ])
            ->add('adress', null, [
                'label' => 'Adresse',
                'constraints' => [
                    new NotBlank()
                ]

            ])
            ->add('studyLevel', null,
                [
                    'choice_label' => 'name',
                    'label' => 'Choisissez votre niveau d\'étude',
                    'constraints' => [
                        new NotBlank()
                    ]
                ]);
        if ($depChoiceMaxNbre > 0) {
            $builder
                ->add('departments', null,
                    [
                        'label' => 'Choisissez les pôles que vous voulez intégrer',
                        'placeholder' => 'Choisissez les pôles que vous voulez intégrer',
                        'choice_label' => 'name',

                        'constraints' => [
                            new Expression([
                                'expression' => '1<=value.count() && value.count() <= ' . $depChoiceMaxNbre,
                                'message' => 'Vous devez choisir entre 1 et '. $depChoiceMaxNbre .' départements.'
                            ])
                        ]
                    ]);
        }
        $builder
            ->add('img', FileType::class, [
                'mapped' => false,
                'label' => 'Votre image',
                'constraints' => [
                    new NotBlank(),
                    new Image()
                ]
            ])
            ->add('accept_data', null, [
                'label' => 'En soumettant ce forrnulaire, j\'accepte que mes données personnelles soient utilisées dans le cadre du cycle de recrutement.',
                'constraints' => [
                    new NotBlank()
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
