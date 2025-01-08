<?php

namespace App\Controller;

use App\Repository\PortfolioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(PortfolioRepository $portfolioRepository): Response
    {
        return $this->render('index/index.html.twig', [
            'portfolios' => $portfolioRepository->findAll(),
        ]);

    }
}
