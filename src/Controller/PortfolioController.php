<?php

namespace App\Controller;

use App\Entity\About;
use App\Entity\Portfolio;
use App\Form\AboutType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/portfolio')]
final class PortfolioController extends AbstractController
{
    #[Route('/new', name: 'app_portfolio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $user = $security->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour créer un portfolio.');
        }
    
        $portfolio = new Portfolio();
        $portfolio->setOwner($user);

        $about = new About();
        $about->setFirstname('');
        $about->setLastname('');
        $about->setDateOfBirth(new DateTime());
        $about->setEmail('');
        $about->setAddress('');
        $about->setPortfolio($portfolio);
        $portfolio->setAbout($about);

        $entityManager->persist($portfolio);
        $entityManager->flush();

        return $this->redirectToRoute(
            'portfolio_about_new', 
            [
                'portfolio' => $portfolio,
                'id' => $portfolio->getId(),
            ],
            Response::HTTP_SEE_OTHER);
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

    #[Route(path: '/{id}/about/new', name: 'portfolio_about_new', methods: ['GET', 'POST'])]
    public function newAbout(Request $request, EntityManagerInterface $entityManager, Portfolio $portfolio): Response
    {
        $about = $portfolio->getAbout();
        $about->setPortfolio($portfolio);

        $form = $this->createForm(AboutType::class, $about);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($about);
            $entityManager->flush();

            return $this->redirectToRoute('app_about_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('about/new.html.twig', [
            'about' => $about,
            'form' => $form,
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

    #[Route('/{id}', name: 'app_portfolio_delete', methods: ['POST'])]
    public function delete(Request $request, Portfolio $portfolio, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$portfolio->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($portfolio);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
    }
}
