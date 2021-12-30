<?php

namespace App\Controller\Admin;

use App\Entity\SpecialistComment;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Component\Security\Core\Security;

class SpecialistCommentCrudController extends AbstractCrudController
{
    private $security;
    private $userRepository;

    public function __construct(Security $security, UserRepository $userRepository)
    {
        $this->security = $security;
        $this->userRepository = $userRepository;
    }

    public static function getEntityFqcn(): string
    {
        return SpecialistComment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextEditorField::new('content'),
            AssociationField::new('user')->hideOnForm(),
            DateTimeField::new('createdAt')->hideOnForm(),
            AssociationField::new('brand'),
            AssociationField::new('model'),
            AssociationField::new('generation'),
            AssociationField::new('body'),
            AssociationField::new('engine'),
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
            ->add('user')
            ->add('brand')
            ->add('model')
            ->add('generation')
            ->add('body')
            ->add('engine')
            ;
    }

    public function createEntity(string $entityFqcn)
    {
        $comment = new SpecialistComment();
        $comment->setUser($this->userRepository->find($this->security->getUser()));

        return $comment;
    }
}
