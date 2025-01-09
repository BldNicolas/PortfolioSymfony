<?php

namespace App\Controller;

use App\Entity\Portfolio;
use App\Entity\Project;
use App\Form\PortfolioType;
use App\Repository\PortfolioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/portfolio')]
final class PortfolioController extends AbstractController
{
    #[Route(name: 'app_portfolio_index', methods: ['GET'])]
    public function index(PortfolioRepository $portfolioRepository): Response
    {
        return $this->render('portfolio/index.html.twig', [
            'portfolios' => $portfolioRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_portfolio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $user = $security->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour créer un portfolio.');
        }
    
        $portfolio = new Portfolio();
        $portfolio->setOwner($user);

        $project = new Project();
        $project->setPortfolio($portfolio);
        $portfolio->addProject($project);

        $form = $this->createForm(PortfolioType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($portfolio);
            $entityManager->flush();

            return $this->redirectToRoute('app_portfolio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('portfolio/new.html.twig', [
            'portfolio' => $portfolio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_portfolio_show', methods: ['GET'])]
    public function show(Portfolio $portfolio): Response
    {
        return $this->render('portfolio/show.html.twig', [
            'portfolio' => $portfolio,
        ]);
    }

    #[Route(path: '/{id}/about', name: 'app_portfolio_about_show', methods: ['GET'])]
    public function showAbout(Portfolio $portfolio): Response
    {
        return $this->render('about/show.html.twig',[
            'portfolio' => $portfolio,
            'about' => $portfolio->getAbout(),
            'about_custom_sections' => $portfolio->getAboutCustomSections()
        ]);
    }

    #[Route(path: '/{id}/project', name: 'app_portfolio_project_show', methods: ['GET'])]
    public function showProject(Portfolio $portfolio): Response
    {
        return $this->render('project/show.html.twig',[
            'portfolio' => $portfolio,
            'projects' => $portfolio->getProjects(),
        ]);
    }

    #[Route(path: '/{id}/experience', name: 'app_portfolio_experience_show', methods: ['GET'])]
    public function showExperience(Portfolio $portfolio): Response
    {
        return $this->render('experience/show.html.twig',[
            'portfolio' => $portfolio,
            'experiences' => $portfolio->getExperiences(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_portfolio_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Portfolio $portfolio, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PortfolioType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_portfolio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('portfolio/edit.html.twig', [
            'portfolio' => $portfolio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_portfolio_delete', methods: ['POST'])]
    public function delete(Request $request, Portfolio $portfolio, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$portfolio->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($portfolio);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_portfolio_index', [], Response::HTTP_SEE_OTHER);
    }
}
