<?php

namespace App\Controller\Admin;

use App\Entity\Subsidiary;
use App\Form\ActivityType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Vich\UploaderBundle\Form\Type\VichImageType;

#[isGranted('ROLE_ADMIN')]
class SubsidiaryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Subsidiary::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name', 'Nom'),
            TextEditorField::new('description', 'Description'),
            TextField::new('photoFile','Photo format (580 * 1000)')->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('photo','Photo format (580 * 1000)')->setBasePath('/uploads/subsidiary')->OnlyOnIndex(),
            CollectionField::new('activities', 'Activité')
                ->setEntryType(ActivityType::class)
                ->allowAdd(true)
                ->allowDelete(true)
                ->hideOnIndex(),
        ];
    }

}
