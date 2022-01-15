<?php

namespace App\Controller\Admin;

use App\Entity\Generation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;

class GenerationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Generation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextEditorField::new('description'),
            AssociationField::new('model'),
            AssociationField::new('carBodies')->hideOnForm(),
            ImageField::new('file')
                ->setLabel("Image")
                ->setBasePath('uploads/generation/')
                ->setUploadDir('public/uploads/generation')
                ->setFormType(FileUploadType::class)
                ->setUploadedFileNamePattern('[randomhash].[extension]'),
            IntegerField::new('producedFrom'),
            IntegerField::new('producedUntil')
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
            ->add('model')
            ->add('producedFrom')
            ->add('producedUntil')
            ;
    }
}
