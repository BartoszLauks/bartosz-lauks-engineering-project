<?php

namespace App\Controller\Admin;

use App\Entity\SalesOffers;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SalesOffersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SalesOffers::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            ImageField::new('file')
            ->setLabel('Image')
            ->setBasePath('/uploads/offers/'),
            IntegerField::new('price'),
            NumberField::new('mileage'),
            TextareaField::new('details'),
            DateField::new("producedAt"),
            AssociationField::new('user'),
            AssociationField::new('brand'),
            AssociationField::new('model'),
            AssociationField::new('generation'),
            AssociationField::new('carBody'),
            AssociationField::new('engine'),
            TextEditorField::new('description'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['createdAt' => 'DESC']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('createdAt')
            ->add('mileage')
            ->add('price')
            ->add('producedAt')
            ->add('user')
            ->add('brand')
            ->add('model')
            ->add('generation')
            ->add('carBody')
            ->add('engine')
            ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX,Action::EDIT)
            ;
    }
}
