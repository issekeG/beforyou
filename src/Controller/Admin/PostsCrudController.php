<?php

namespace App\Controller\Admin;

use App\Entity\Posts;
use App\Form\SectionsType;
use App\Form\TagType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
Use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Vich\UploaderBundle\Form\Type\VichImageType;

#[isGranted('ROLE_ADMIN')]
class PostsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Posts::class;

    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->overrideTemplate('crud/edit', 'admin/custom_add.html.twig')
            ->setEntityLabelInSingular('...');

    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', "Titre de l'article"),
            TextEditorField::new('content', 'Courte description du contenu')
                ->setFormTypeOption('attr', [
                    'class' => 'ckeditor',
                ]),
            TextField::new('imageFile','Image principale (1290 * 700)')->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('image')->setBasePath('/uploads/posts')->OnlyOnIndex(),
            TextField::new('author', "Other de l'article"),
            IntegerField::new('readTime', "Temps de lecture estimé (minutes)"),
            TextField::new('keywords', "Les mots clés de l'article")->hideOnIndex(),
            TextEditorField::new('seoDescription', 'Courte description pour SEO')
                ->setFormTypeOption('attr', [
                    'class' => 'ckeditor',
                ]),
            TextField::new('seoTitle', 'Titre SEO')->hideOnIndex(),

            SlugField::new('slug')->setTargetFieldName(['title','publishedAt'])->onlyOnIndex(),
            TextField::new('sector', 'Sector'),

            // CollectionField for Tags
            CollectionField::new('tags', 'Tags (séparé par des virgules)')
                ->setEntryType(TagType::class)
                ->allowAdd(true)
                ->allowDelete(true)
                ->hideOnIndex(),

            // CollectionField for Sections
            CollectionField::new('sections', "Sections de l'article")
                ->setEntryType(SectionsType::class)
                ->allowAdd(true)
                ->allowDelete(true)
                ->hideOnIndex(),

            IntegerField::new('sectionsCount', 'Nombre de Sections')
                ->onlyOnIndex(),

        ];
    }

}
