<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use App\Entity\Realisation;
use App\Form\RealisationImagesType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[isGranted('ROLE_ADMIN')]
class RealisationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Realisation::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('activity','Activité')
                ->setFormTypeOption('disabled', false),
            DateField::new('startedAt','Date de debut')->setFormat('dd/MM/yyyy'),
            DateField::new('deliveryAt','Date de fin')->setFormat('dd/MM/yyyy'),
            TextField::new('client', 'Nom du client'),
            TextField::new('title',"Theme de la réalisation"),
            SlugField::new('slug')->setTargetFieldName(['title','delivery_date'])->onlyOnIndex(),
            TextField::new('subTitle', 'Premier sous titre'),
            TextEditorField::new('subTitleDescription', 'Description du sous titre'),
            TextField::new('subTitle2','Deuxième sous titre'),
            TextEditorField::new('secondSubTitleDescription','Description du deuxième sous titre'),
            CollectionField::new('images', 'Image')
                ->setEntryType(RealisationImagesType::class)
                ->allowAdd(true)
                ->allowDelete(true)
                ->hideOnIndex(),

        ];
    }

}
