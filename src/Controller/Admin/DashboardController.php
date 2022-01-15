<?php

namespace App\Controller\Admin;

use App\Controller\CarDataSpecialistController;
use App\Entity\Advertising;
use App\Entity\Brand;
use App\Entity\CarBody;
use App\Entity\CarBodyProperty;
use App\Entity\CarBodyValue;
use App\Entity\Comment;
use App\Entity\Engine;
use App\Entity\EngineProperty;
use App\Entity\EngineValue;
use App\Entity\Gender;
use App\Entity\Generation;
use App\Entity\Model;
use App\Entity\Newses;
use App\Entity\Post;
use App\Entity\ResetPasswordRequest;
use App\Entity\SalesOffers;
use App\Entity\SpecialistComment;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
#[IsGranted('ROLE_ADMIN')]
class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(): Response
    {
        return $this->render('admin/welcome.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Everything About Cars');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('WebSite', 'fas fa-globe', 'app_home');
        yield MenuItem::section('Website functionality');
        yield MenuItem::linkToCrud('Advertising', 'fas fa-money-check-alt', Advertising::class)->setPermission("ROLE_MARKERING");
        yield MenuItem::linkToCrud('Newses', 'fas fa-newspaper', Newses::class)->setPermission('ROLE_JOURNALIST');
        yield MenuItem::linkToCrud('Sales offers', 'fas fa-hand-holding-usd', SalesOffers::class)->setPermission('ROLE_SPECIALIST');
        yield MenuItem::linkToCrud('Car data specialist', 'fas fa-user-graduate', SpecialistComment::class)->setPermission('ROLE_SPECIALIST');
        yield MenuItem::section('Blog')->setPermission('ROLE_SPECIALIST');
        yield MenuItem::linkToCrud('Posts', 'fas fa-comment-dots', Post::class)->setPermission('ROLE_SPECIALIST');
        yield MenuItem::linkToCrud('Comments', 'fas fa-comments', Comment::class)->setPermission('ROLE_SPECIALIST');
        yield MenuItem::section('Users')->setPermission('ROLE_SUPER_ADMIN');
        yield MenuItem::linkToCrud('Gender', 'fas fa-venus-mars', Gender::class)->setPermission('ROLE_SUPER_ADMIN');
        yield MenuItem::linkToCrud('User', 'fas fa-users', User::class)->setPermission('ROLE_SUPER_ADMIN');
        yield MenuItem::linkToCrud('Reset password request', 'fas fa-key', ResetPasswordRequest::class)->setPermission('ROLE_SUPER_ADMIN');
        yield MenuItem::section('Car Components',)->setPermission('ROLE_SPECIALIST');
        yield MenuItem::linkToCrud('Brand', 'fas fa-trademark', Brand::class)->setPermission('ROLE_SPECIALIST');
        yield MenuItem::linkToCrud('Model', 'fas fa-car-alt', Model::class)->setPermission('ROLE_SPECIALIST');
        yield MenuItem::linkToCrud('Generation','fas fa-car',Generation::class)->setPermission('ROLE_SPECIALIST');
        yield MenuItem::linkToCrud('Car Body','fas fa-car-side',CarBody::class)->setPermission('ROLE_SPECIALIST');
        yield MenuItem::linkToCrud('Engine', 'fas fa-cogs', Engine::class)->setPermission('ROLE_SPECIALIST');
        yield MenuItem::section('Components Value')->setPermission('ROLE_SPECIALIST');
        yield MenuItem::linkToCrud('Engine Value', 'fas fa-cogs', EngineValue::class)->setPermission('ROLE_SPECIALIST');
        yield MenuItem::linkToCrud('Car Body Value', 'fas fa-car-side', CarBodyValue::class)->setPermission('ROLE_SPECIALIST');
        yield MenuItem::section('Components Property')->setPermission('ROLE_SPECIALIST');
        yield MenuItem::linkToCrud('Engine Property', 'fas fa-cogs', EngineProperty::class)->setPermission('ROLE_SPECIALIST');
        yield MenuItem::linkToCrud('Car Body Property', 'fas fa-car-side', CarBodyProperty::class)->setPermission('ROLE_SPECIALIST');



    }
}
