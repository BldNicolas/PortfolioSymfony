<?php

namespace App\Controller;

use App\Entity\Experience;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/experience')]
final class ExperienceController extends AbstractController
{
    #[Route('/{id}', name: 'app_experience_delete', methods: ['POST'])]
    public function delete(Request $request, Experience $experience, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$experience->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($experience);
            $entityManager->flush();
        }

        return $this->redirectToRoute('portfolio_experiences_edit', [
            'id' => $experience->getPortfolio()->getId(),
        ], Response::HTTP_SEE_OTHER);
    }
}
