<?php

namespace App\Controller;

use App\Entity\AboutCustomSection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/about/custom/section')]
final class AboutCustomSectionController extends AbstractController
{
    #[Route('/{id}', name: 'app_about_custom_section_delete', methods: ['POST'])]
    public function delete(Request $request, AboutCustomSection $aboutCustomSection, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$aboutCustomSection->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($aboutCustomSection);
            $entityManager->flush();
        }

        return $this->redirectToRoute('portfolio_about_edit', [
            'id' => $aboutCustomSection->getPortfolio()->getId(),
        ], Response::HTTP_SEE_OTHER);
    }
}
