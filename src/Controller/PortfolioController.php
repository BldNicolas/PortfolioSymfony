<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PortfolioController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index()
    {
        return $this->render('index.html.twig');
    }

    #[Route(path: '/about', name: 'section_about')]
    public function about(): Response
    {
        return $this->render('section/about.html.twig');
    }

    #[Route(path: '/education', name: 'section_education')]
    public function education(): Response
    {
        return $this->render('section/education.html.twig');
    }
}
