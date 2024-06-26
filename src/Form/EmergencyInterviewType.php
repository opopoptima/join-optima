<?php

namespace App\Form;

use App\Entity\Interview;
use App\Entity\RecruitmentSession;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;

class EmergencyInterviewType extends AbstractType
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $currentRecruitmentSession = $this->em->getRepository(RecruitmentSession::class)->findOneBy(['current' => true]);
        $recruiters = $this->em->getRepository(User::class)->findByRoleAndSession('ROLE_RECRUITER', $currentRecruitmentSession);
        $candidats = $this->em->getRepository(User::class)->findByRoleAndSession('ROLE_CANDIDATE', $currentRecruitmentSession);
        $candidatsWithoutInterview = [];

        foreach ($candidats as $candidate) {

            if ($candidate->getInterview() === null && $candidate->getResult() && $candidate->getResult()->getPreRegistration() === true) {
                $candidatsWithoutInterview[] = $candidate;
            }
        }
        $builder
            ->add('place')
            ->add('start', null,
                [
                    'widget' => 'single_text'
                ])
            ->add('_end', null,
                [
                    'widget' => 'single_text',
                    'constraints' => [
                        new Range([
                            'max' => $currentRecruitmentSession->getInterviewsEnd()
                        ])
                    ]
                ])
            ->add('recruiters', null,
                [
                    'choices' => $recruiters,
                    'choice_label' => 'f_name'
                ])
            ->add('candidate', null,
                [
                    'label' => 'Candidates',
                    'choices' => $candidatsWithoutInterview,
                    'choice_label' => 'l_name'
                ])
            ->add('Envoyer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Interview::class,
        ]);
    }
}
