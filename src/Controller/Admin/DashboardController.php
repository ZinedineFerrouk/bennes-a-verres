<?php

namespace App\Controller\Admin;

use App\Entity\Benne;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
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
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="assets/images/logo_jaune.png" />')
            ->setFaviconPath('assets/images/logo_jaune.png');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Accueil', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Benne', 'fas fa-trash', Benne::class);
    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('assets/css/admin.css');
    }

    
}
