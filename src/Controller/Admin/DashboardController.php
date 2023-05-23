<?php

namespace App\Controller\Admin;

use App\Entity\Photo;
use App\Entity\Dish;
use App\Entity\Schedule;
use App\Entity\Menu;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
      $this->managerRegistry = $managerRegistry;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $menuItems = $this->configureMenuItems();

        $entityManager = $this->managerRegistry->getManager();

        $photoRepository = $entityManager->getRepository(Photo::class);
        $photos = $photoRepository->findAll();

        $scheduleRepository = $entityManager->getRepository(Schedule::class);
        $schedules = $scheduleRepository->findAll();

        return $this->render('admin/dashboard.html.twig', [
            'menuItems' => $menuItems,
            'photos' => $photos,
            'schedules' => $schedules,
        ]); 
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Quai Antique Menu');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Restaurant');
        yield MenuItem::linkToCrud('Dishes', 'fa fa-utensils', Dish::class);
        yield MenuItem::linkToCrud('Photos', 'fa fa-camera', Photo::class);
        yield MenuItem::linkToCrud('Schedules', 'fa fa-calendar', Schedule::class);
        yield MenuItem::linkToCrud('Menu', 'fa fa-utensils', Menu::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
