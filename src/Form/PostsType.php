<?php

namespace App\Form;

use App\Entity\Posts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PostsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('image', TextType::class)
            ->add('author', TextType::class)
            ->add('readTime', IntegerType::class)
            ->add('publishedAt', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('keywords', TextType::class)
            ->add('seoDescription', TextareaType::class)
            ->add('seoTitle', TextType::class)
            ->add('slug', TextType::class)
            ->add('tags', CollectionType::class, [
                'entry_type' => TagType::class, // Utilisez le formulaire des tags pour créer les entités liées
                'allow_add' => true, // Permet d'ajouter des tags dynamiquement
                'by_reference' => false, // Important pour éviter des références erronées
                'entry_options' => [
                    'label' => false
                ]
            ])
            ->add('sections', CollectionType::class, [
                'entry_type' => SectionsType::class, // Utilisez le formulaire des sections pour créer les entités liées
                'allow_add' => true, // Permet d'ajouter des sections dynamiquement
                'by_reference' => false, // Important pour éviter des références erronées
                'entry_options' => [
                    'label' => false
                ]
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }


}
