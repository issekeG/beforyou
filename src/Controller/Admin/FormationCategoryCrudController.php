<?php

namespace App\Controller\Admin;

use App\Entity\FormationCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FormationCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FormationCategory::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom de la category'),
        ];
    }

}
