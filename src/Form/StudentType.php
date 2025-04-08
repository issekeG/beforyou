<?php

namespace App\Form;

use App\Entity\FormationCategory;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('sex', ChoiceType::class, [
                'label' => 'Sexe*',
                'choices' => [
                    'Masculin' => 'M',
                    'Féminin' => 'F',
                ],
                'expanded' => false, // Pour un select dropdown
                'multiple' => false,
                'placeholder' => 'Sélectionnez votre sexe',
                'required' => true,
            ])
            ->add('age')
            ->add('nationality')
            ->add('schoolLevel', ChoiceType::class, [
                'label' => 'Sexe*',
                'choices' => [
                    'Seconde' => 'Seconde',
                    'Premiere' => 'Premiere',
                    'Terminale' => 'Terminale',
                    'Bac + 1' => 'Bac + 1',
                    'Bac + 2' => 'Bac + 2',
                    'Bac + 3' => 'Bac + 3',
                    'Bac + 4' => 'Bac + 4',
                    'Bac + 5' => 'Bac + 5',
                    'Ingénieur' => 'Ingénieur',
                ],
                'expanded' => false, // Pour un select dropdown
                'multiple' => false,
                'placeholder' => 'Sélectionnez votre sexe',
                'required' => true,
            ])
            ->add('activityActuelle')
            ->add('country')
            ->add('city')
            ->add('address')
            ->add('telephone')
            ->add('email')
            ->add('formation', EntityType::class, [
                'class' => FormationCategory::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
