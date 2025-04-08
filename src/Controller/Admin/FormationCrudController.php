<?php

namespace App\Controller\Admin;

use App\Entity\Formation;
use App\Form\FormationSectionType;
use App\Form\SectionsType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class FormationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Formation::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            SlugField::new('slug')->setTargetFieldName(['title'])->onlyOnDetail(),
            DateTimeField::new('publishedAt','Date de creation')->onlyOnIndex(),
            DateTimeField::new('startedAt', 'Date de début'),
            DateTimeField::new('endedAt', 'Date de fin'),
            AssociationField::new('category', 'Catégorie'),
            TextField::new('title', 'Titre'),
            TextEditorField::new('description', 'Description de la formation'),
            TextField::new('imageFile','Image')->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('image')->setBasePath('/uploads/formations')->OnlyOnIndex(),

            CollectionField::new('formationSections', "Sections de la formation")
                ->setEntryType(FormationSectionType::class)
                ->allowAdd(true)
                ->allowDelete(true)
                ->hideOnIndex(),

        ];
    }

}
