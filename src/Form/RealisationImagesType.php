<?php

namespace App\Form;

use App\Entity\Images;
use App\Entity\Realisation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RealisationImagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image_file',VichImageType::class,['label' => 'Image'])
            ->add('dimension', ChoiceType::class, [
                'label' => 'Dimension',
                'choices' => [
                    'Image principale ( 1820 * 900 )' => "principale",
                    'Image principale secondaire ( 1290 * 616 )' => "secondaire",
                    'Image moyenne ( 635 * 400 )' => 'moyenne',
                    'Petite ( 375 * 450 )' => 'petite',
                    'Affiche ( 375 * 450 )' => 'affiche',
                    ]
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Images::class,
        ]);
    }
}
