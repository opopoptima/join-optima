<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\{
    TextareaType,
    SubmitType,
    NumberType,
    ChoiceType
};
use Symfony\Component\Validator\Constraints\Expression;

class CollectiveInterviewEvaluationType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        foreach ($options['data']['criteria'] as $criterion) {
            $builder->add($criterion->getId(), NumberType::class, [
                'label' => $criterion->getCriterion(),
                'constraints' => [
                    new Expression([
                        'expression' => 'value >=0 && value <=10 ',
                        'message' => 'Cette valeur doit être comprise entre 0 et 10.',
                    ]),
                ],
                'attr' => ['type' => 'number'],
            ]);
        }
        $builder
            ->add('remarks', TextareaType::class)
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
