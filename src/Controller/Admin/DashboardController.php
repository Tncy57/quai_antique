<?php

namespace App\Controller\Admin;

use App\Entity\Photo;
use App\Entity\Dish;
use App\Entity\Schedule;
use App\Entity\Menu;
use App\Entity\Reservation;
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

        $reservationRepository = $entityManager->getRepository(Reservation::class);
        $reservations = $reservationRepository->findAll();

        return $this->render('admin/dashboard.html.twig', [
            'menuItems' => $menuItems,
            'photos' => $photos,
            'schedules' => $schedules,
            'reservations' => $reservations,
        ]); 
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Quai Antique');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Home', 'fa fa-home', 'app_home');
        yield MenuItem::section('Restaurant');
        yield MenuItem::linkToCrud('Dishes', 'fa fa-utensils', Dish::class);
        yield MenuItem::linkToCrud('Photos', 'fa fa-camera', Photo::class);
        yield MenuItem::linkToCrud('Schedules', 'fa fa-calendar', Schedule::class);
        yield MenuItem::linkToCrud('Menu', 'fa fa-utensils', Menu::class);
        yield MenuItem::linkToCrud('Reservations', 'fas fa-list', Reservation::class);
    }
}
