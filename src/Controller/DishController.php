<?php

namespace App\Controller;

use App\Repository\DishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DishController extends AbstractController
{
    #[Route('/dishes', name: 'app_dish')]
    public function index(DishRepository $dishRepository): Response
    {
        $dishes = $dishRepository->findAll();
        return $this->render('dish/index.html.twig', [
            'dishes' => $dishes,
        ]);
    }
}
