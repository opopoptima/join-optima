<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\{
    TextareaType,
    SubmitType,
    NumberType,
    ChoiceType,
    FormType
};
use Symfony\Component\Validator\Constraints\Expression;

class InterviewEvaluationType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        foreach ($options['data']['criteria'] as $sheet => $criteria) {
            if (!empty($criteria)) {
                $builder->add($nb = $builder->create($sheet, FormType::class));
                foreach ($criteria as $criterion) {
                    $nb->add($criterion->getId(), NumberType::class, [
                        'label' => $criterion->getCriterion(),
                        'required'=>false,
                        'constraints' => [
                            new Expression([
                                'expression' => '!value || (value >=0 && value <=10) ',
                                'message' =>
                                    'Cette valeur doit être comprise entre 0 et 10.',
                            ]),
                        ],
                        'attr' => ['type' => 'number'],
                    ])
                        ->add($criterion->getId()."_remark", TextareaType::class, [
                            'label' => $criterion->getCriterion()." Remark",
                            'required'=>false
                        ]);
                }
            }
        }
        $builder
            ->add('remarks', TextareaType::class,[

            ])
            ->add('decision', ChoiceType::class, [
                'label' => 'Decision',
                'multiple' => false,
                'expanded' => true,
                'choices' => ['Yes' => 'Yes', 'No' => 'No', 'Maybe' => 'Maybe'],
                'label_html' => true,
            ])
            ->add('Envoyer', SubmitType::class);
    }
}
