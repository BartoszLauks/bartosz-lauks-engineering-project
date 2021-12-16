<?php

namespace App\Controller\Admin;

use App\Entity\CarBodyValue;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CarBodyValueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CarBodyValue::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('value'),
            DateTimeField::new('createdAt')->hideOnForm(),
            AssociationField::new('carBody'),
            AssociationField::new('property')
        ];
    }
}
