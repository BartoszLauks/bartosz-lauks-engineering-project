<?php

namespace App\Controller\Admin;

use App\Entity\CarBody;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CarBodyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CarBody::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextEditorField::new('description'),
            DateTimeField::new("createdAt")->hideOnForm(),
            AssociationField::new('generation'),
            AssociationField::new('engines')->hideOnForm(),

        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
            ->add('generation')
            ->add('createdAt')
            ;
    }
}
