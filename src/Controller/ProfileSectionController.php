<?php

namespace App\Controller;

use App\Entity\ProfileSection;
use App\Form\ProfileSectionType;
use App\Repository\ProfileSectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profile/section')]
final class ProfileSectionController extends AbstractController
{
    #[Route(name: 'app_profile_section_index', methods: ['GET'])]
    public function index(ProfileSectionRepository $profileSectionRepository): Response
    {
        return $this->render('profile_section/index.html.twig', [
            'profile_sections' => $profileSectionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_profile_section_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $profileSection = new ProfileSection();
        $form = $this->createForm(ProfileSectionType::class, $profileSection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($profileSection);
            $entityManager->flush();

            return $this->redirectToRoute('app_profile_section_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profile_section/new.html.twig', [
            'profile_section' => $profileSection,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_profile_section_show', methods: ['GET'])]
    public function show(ProfileSection $profileSection): Response
    {
        return $this->render('profile_section/show.html.twig', [
            'profile_section' => $profileSection,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_profile_section_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ProfileSection $profileSection, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProfileSectionType::class, $profileSection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_profile_section_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profile_section/edit.html.twig', [
            'profile_section' => $profileSection,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_profile_section_delete', methods: ['POST'])]
    public function delete(Request $request, ProfileSection $profileSection, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$profileSection->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($profileSection);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_profile_section_index', [], Response::HTTP_SEE_OTHER);
    }
}
