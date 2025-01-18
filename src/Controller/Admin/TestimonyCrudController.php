<?php

namespace App\Controller\Admin;

use App\Entity\Testimony;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Vich\UploaderBundle\Form\Type\VichImageType;

#[isGranted('ROLE_ADMIN')]
class TestimonyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Testimony::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('clientName', 'Nom du client'),
            TextField::new('clientPosition', 'Poste du client'),
            TextField::new('videoLink','Video de témoignage'),
            DateField::new('testimonyAt','Date de témoignage'),
            TextField::new('clientPhotoFile', 'Photo du client')->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('clientPhoto','Photo du client')->setBasePath('/uploads/testimony')->OnlyOnIndex(),
        ];
    }

}
