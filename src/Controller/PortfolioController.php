<?php

namespace App\Controller;

use App\Entity\About;
use App\Entity\AboutCustomSection;
use App\Entity\Portfolio;
use App\Entity\Project;
use App\Form\AboutCustomSectionType;
use App\Form\AboutType;
use App\Form\ProjectType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormFactoryInterface;
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
            'portfolio_about_edit', 
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

    #[Route(path: '/{id}/about/edit', name: 'portfolio_about_edit', methods: ['GET', 'POST'])]
    public function editAbout(Request $request, EntityManagerInterface $entityManager, FormFactoryInterface $formFactory, Portfolio $portfolio): Response
    {
        $about = $portfolio->getAbout();
        $about->setPortfolio($portfolio);

        $newAboutForm = $this->createForm(AboutType::class, $about);
        $newAboutForm->handleRequest($request);

        if ($newAboutForm->isSubmitted() && $newAboutForm->isValid()) {
            $entityManager->persist($about);
            $entityManager->flush();

            return $this->redirectToRoute('portfolio_projects_edit', ['id' => $portfolio->getId()], Response::HTTP_SEE_OTHER);
        }

        $newAboutCustomSection = new AboutCustomSection();
        $newAboutCustomSection->setPortfolio($portfolio);
        $newAboutCustomSectionForm = $formFactory->createNamed('new_about_custom_section_form', AboutCustomSectionType::class, $newAboutCustomSection);
        $newAboutCustomSectionForm->handleRequest($request);
        
        if ($newAboutCustomSectionForm->isSubmitted() && $newAboutCustomSectionForm->isValid()) { 
            $entityManager->persist($newAboutCustomSection);
            $entityManager->flush();

            return $this->redirectToRoute('portfolio_about_edit', ['id' => $portfolio->getId()], Response::HTTP_SEE_OTHER);
        }

        $editAboutCustomSectionForms = [];
        $aboutCustomSections = $portfolio->getAboutCustomSection();

        foreach ($aboutCustomSections as $aboutCustomSection) {
            $editAboutCustomSectionForm = $formFactory->createNamed('edit_about_custom_section_' . $aboutCustomSection->getId() . '_form', AboutCustomSectionType::class, $aboutCustomSection);
            $editAboutCustomSectionForm->handleRequest($request);

            if ($editAboutCustomSectionForm->isSubmitted() && $editAboutCustomSectionForm->isValid()) {
                $entityManager->flush();

                return $this->redirectToRoute('portfolio_about_edit', ['id' => $portfolio->getId()], Response::HTTP_SEE_OTHER);
            }

            $editAboutCustomSectionForms[$aboutCustomSection->getId()] = $editAboutCustomSectionForm;
        }

        return $this->render('portfolio/edit/about.html.twig', [
            'portfolio' => $portfolio,
            'aboutCustomSections' => $aboutCustomSections,
            'newAboutForm' => $newAboutForm->createView(),
            'newAboutCustomSectionForm' => $newAboutCustomSectionForm->createView(),
            'editAboutCustomSectionForms' => array_map(function ($form) {
                return $form->createView();
            }, $editAboutCustomSectionForms),

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

    #[Route(path: '/{id}/projects/edit', name: 'portfolio_projects_edit', methods: ['GET', 'POST'])]
    public function editProjects(Request $request, EntityManagerInterface $entityManager, FormFactoryInterface $formFactory, Portfolio $portfolio): Response
    {
        $projects = $portfolio->getProjects();
    
        $newProject = new Project();
        $newProject->setPortfolio($portfolio);
        $newProjectForm = $formFactory->createNamed('new_project_form', ProjectType::class, $newProject);
        $newProjectForm->handleRequest($request);
    
        if ($newProjectForm->isSubmitted() && $newProjectForm->isValid()) {
            $entityManager->persist($newProject);
            $entityManager->flush();
    
            return $this->redirectToRoute('portfolio_projects_edit', ['id' => $portfolio->getId()], Response::HTTP_SEE_OTHER);
        }
    
        $editProjectForms = [];
    
        foreach ($projects as $project) {
            $editProjectForm = $formFactory->createNamed('edit_form_' . $project->getId(), ProjectType::class, $project);
            $editProjectForm->handleRequest($request);
    
            if ($editProjectForm->isSubmitted() && $editProjectForm->isValid()) {
                $entityManager->flush();
    
                return $this->redirectToRoute('portfolio_projects_edit', ['id' => $portfolio->getId()], Response::HTTP_SEE_OTHER);
            }
    
            $editProjectForms[$project->getId()] = $editProjectForm;
        }
    
        return $this->render('portfolio/edit/projects.html.twig', [
            'portfolio' => $portfolio,
            'projects' => $projects,
            'newProjectForm' => $newProjectForm->createView(),
            'editForms' => array_map(function ($form) {
                return $form->createView();
            }, $editProjectForms),
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
