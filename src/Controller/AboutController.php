<?php

namespace App\Controller;

use App\Entity\About;
use App\Form\AboutType;
use App\Repository\AboutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/about')]
final class AboutController extends AbstractController
{
    #[Route(name: 'app_about_index', methods: ['GET'])]
    public function index(AboutRepository $aboutRepository): Response
    {
        return $this->render('about/index.html.twig', [
            'abouts' => $aboutRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_about_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $about = new About();
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

    #[Route('/{id}', name: 'app_about_show', methods: ['GET'])]
    public function show(About $about): Response
    {
        return $this->render('about/show.html.twig', [
            'about' => $about,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_about_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, About $about, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AboutType::class, $about);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_about_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('about/edit.html.twig', [
            'about' => $about,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_about_delete', methods: ['POST'])]
    public function delete(Request $request, About $about, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$about->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($about);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_about_index', [], Response::HTTP_SEE_OTHER);
    }
}
