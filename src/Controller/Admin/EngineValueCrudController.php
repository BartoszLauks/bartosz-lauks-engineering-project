<?php

namespace App\Controller\Admin;

use App\Entity\EngineValue;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EngineValueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EngineValue::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('value'),
            DateTimeField::new('createdAt')->hideOnForm(),
            AssociationField::new('engine'),
            AssociationField::new('property')
        ];
    }
}
