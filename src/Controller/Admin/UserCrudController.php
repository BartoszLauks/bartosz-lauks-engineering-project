<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email'),
            ChoiceField::new('roles', 'Roles')
                ->allowMultipleChoices()
                ->autocomplete()
                ->setRequired(false)
                ->setChoices([
                        "Journalist" => "ROLE_JOURNALIST",
                        "Marketing" => "ROLE_MARKERING",
                        'Data specialist' => "ROLE_SPECIALIST",
                        'Admin' => 'ROLE_ADMIN',
                        'Super Admin' => 'ROLE_SUPER_ADMIN'
                    ]
                ),
            BooleanField::new('isVerified'),
            TextField::new('name')->onlyOnDetail(),
            TextField::new('surname')->onlyOnDetail(),
            DateTimeField::new('createAt')->hideOnForm(),
            AssociationField::new('gender')->onlyOnDetail(),
            TextField::new('password')->hideWhenUpdating()->setMaxLength(10),
            TextField::new('post_code')->onlyOnDetail(),
            TextField::new('city')->onlyOnDetail(),
            TextField::new('street')->onlyOnDetail(),
            TextField::new('home_nr')->onlyOnDetail(),
            TelephoneField::new('phone')->onlyOnDetail(),
            AssociationField::new('salesOffers')->onlyOnDetail(),
            AssociationField::new('posts')->onlyOnDetail(),
            AssociationField::new('comments')->onlyOnDetail(),
            AssociationField::new('specialistComments')->onlyOnDetail(),

        ];
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX,Action::DETAIL)
            ->remove(Crud::PAGE_INDEX,Action::NEW);
    }
}
