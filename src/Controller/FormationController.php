<?php

namespace App\Controller;

use App\Repository\FormationCategoryRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FormationController extends AbstractController
{
    #[Route('/formation', name: 'app_formation')]
    public function index(FormationRepository $formationRepository): Response
    {
        $formations = $formationRepository->findAndOrderBy();

        return $this->render('formation/index-page.html.twig',
            [
                'formations' => $formations,
            ]
        );
    }
    #[Route('/ajax/formations-by-category', name: 'ajax_formations_by_category', methods: ['POST'])]
    public function getFormationsByCategory(Request $request, FormationRepository $formationRepository): JsonResponse
    {
        $categoryId = $request->request->get('categoryId');

        $formations = $formationRepository->findBy(['category' => $categoryId]);

        $data = [];
        foreach ($formations as $formation) {
            $data[] = [
                'id' => $formation->getId(),
                'title' => $formation->getTitle(),
            ];
        }

        return new JsonResponse($data);
    }



}
