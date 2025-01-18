<?php

namespace App\Controller\Admin;

use App\Entity\TeamMember;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Vich\UploaderBundle\Form\Type\VichImageType;

#[isGranted('ROLE_ADMIN')]
class TeamMemberCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TeamMember::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name'),
            TextField::new('firstname'),
            TextField::new('role'),
            IntegerField::new('rank', 'Position dans la hiérarchie'),
            TextEditorField::new('description', 'Description'),
            TextField::new('photoFile','Photo')->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('photo','Photo')->setBasePath('/uploads/team_member')->OnlyOnIndex(),
            SlugField::new('slug')->setTargetFieldName(['role','name','firstname'])->onlyOnIndex(),
            TextField::new('facebookLink','Lien Facebook'),
            TextField::new('linkedin', 'Lien Linkedin'),
            TextField::new('twitter', 'Lien Twitter X'),

        ];
    }

}
