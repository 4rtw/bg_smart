<?php

namespace App\Controller\Admin;

use App\Entity\Carousel;
use App\Entity\CarouselPlace;
use App\Entity\Message;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    /**
     * @Route("/admin")
     */
    public function index(): Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(CarouselCrudController::class)->generateUrl());

    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Bgsmart Project');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Messages', 'fas fa-list', Message::class );
        yield MenuItem::linkToCrud('Carousel image', 'fas fa-list', Carousel::class );
        yield MenuItem::linkToCrud('Carousel place', 'fas fa-list', CarouselPlace::class);
        yield MenuItem::linkToCrud('User', 'fas fa-list', User::class );
    }
}
