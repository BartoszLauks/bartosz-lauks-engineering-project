<?php

namespace App\Controller\Admin;

use App\Entity\CarBodyProperty;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CarBodyPropertyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CarBodyProperty::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('property'),
            DateTimeField::new('createdAt')->hideOnForm(),
            AssociationField::new('property')
        ];
    }
}
