<?php

namespace App\Controller;

use App\Entity\AboutCustomSection;
use App\Form\AboutCustomSectionType;
use App\Repository\AboutCustomSectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/about/custom/section')]
final class AboutCustomSectionController extends AbstractController
{
    #[Route(name: 'app_about_custom_section_index', methods: ['GET'])]
    public function index(AboutCustomSectionRepository $aboutCustomSectionRepository): Response
    {
        return $this->render('about_custom_section/index.html.twig', [
            'about_custom_sections' => $aboutCustomSectionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_about_custom_section_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $aboutCustomSection = new AboutCustomSection();
        $form = $this->createForm(AboutCustomSectionType::class, $aboutCustomSection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($aboutCustomSection);
            $entityManager->flush();

            return $this->redirectToRoute('app_about_custom_section_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('about_custom_section/new.html.twig', [
            'about_custom_section' => $aboutCustomSection,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_about_custom_section_show', methods: ['GET'])]
    public function show(AboutCustomSection $aboutCustomSection): Response
    {
        return $this->render('about_custom_section/show.html.twig', [
            'about_custom_section' => $aboutCustomSection,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_about_custom_section_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AboutCustomSection $aboutCustomSection, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AboutCustomSectionType::class, $aboutCustomSection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_about_custom_section_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('about_custom_section/edit.html.twig', [
            'about_custom_section' => $aboutCustomSection,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_about_custom_section_delete', methods: ['POST'])]
    public function delete(Request $request, AboutCustomSection $aboutCustomSection, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$aboutCustomSection->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($aboutCustomSection);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_about_custom_section_index', [], Response::HTTP_SEE_OTHER);
    }
}
