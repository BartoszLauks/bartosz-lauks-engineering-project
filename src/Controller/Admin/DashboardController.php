<?php

namespace App\Controller\Admin;

use App\Entity\Advertising;
use App\Entity\Brand;
use App\Entity\CarBody;
use App\Entity\Engine;
use App\Entity\EngineProperty;
use App\Entity\EngineValue;
use App\Entity\Generation;
use App\Entity\Model;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
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
        //yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToRoute('WebSite', 'fas fa-globe', 'app_home');
        yield MenuItem::linkToCrud('Advertising', 'fas fa-money-check-alt', Advertising::class);
        yield MenuItem::section('Car Components');
        yield MenuItem::linkToCrud('Brand', 'fas fa-trademark', Brand::class);
        yield MenuItem::linkToCrud('Model', 'fas fa-car-alt', Model::class);
        yield MenuItem::linkToCrud('Generation','fas fa-car',Generation::class);
        yield MenuItem::linkToCrud('Car Body','fas fa-car-side',CarBody::class);
        yield MenuItem::linkToCrud('Engine', 'fas fa-cogs', Engine::class);
        yield MenuItem::section('Components Value');
        yield MenuItem::linkToCrud('Engine Value', 'fas fa-cogs', EngineValue::class);
        yield MenuItem::linkToCrud('Car Body Value', 'fas fa-car-side', EngineValue::class);
        yield MenuItem::section('Components Property');
        yield MenuItem::linkToCrud('Engine Property', 'fas fa-cogs', EngineProperty::class);
        yield MenuItem::linkToCrud('Car Body Property', 'fas fa-car-side', EngineProperty::class);



    }
}
