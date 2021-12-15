<?php

namespace App\Controller\Admin;

use App\Entity\Advertising;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;

class AdvertisingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Advertising::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            ImageField::new('file')
                ->setLabel("Image")
                ->setBasePath('uploads/')
                ->setUploadDir('public/uploads')
                ->setFormType(FileUploadType::class)
                ->setUploadedFileNamePattern('[randomhash].[extension]'),
            DateTimeField::new('dueDate')
            ->setLabel("Due date")->setSortable(true),
            DateTimeField::new('createdAt')->hideOnForm()
            ->setLabel("Created at")
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['dueDate' => 'DESC']);
    }


    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('dueDate')
            ->add('createdAt')
            ;
    }
}
