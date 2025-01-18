<?php

namespace App\Controller;

use App\Repository\ActivityRepository;
use App\Repository\RealisationRepository;
use App\Repository\SubsidiaryRepository;
use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ServicesController extends AbstractController
{
    #[Route('/be-for-you-activites', name: 'app_activity')]
    public function index(SubsidiaryRepository $subsidiaryRepository): Response
    {
        $all_subsidiaries = $subsidiaryRepository->findAll();
        return $this->render('services/service-page.html.twig', [

            'all_subsidiaries' => $all_subsidiaries,
        ]);
    }

    #[Route('/services/detail', name: 'old_app_service_detail')]
    public function service_detail():response{
        return $this->render('services/service-detail-page.html.twig', []);
    }

    #[Route('be-for-you/activity/{slug}', name: 'app_service_detail')]
    public function activity_detail_by_name(string $slug, ActivityRepository $activityRepository):response{

        if($slug != null){
            $slugify = new Slugify();
            $slug = $slugify->slugify($slug);
        }

        $activity = $activityRepository->findOneBySlug($slug);

        if (!$activity) {
            throw $this->createNotFoundException('activité non trouvé.');
        }

        return $this->render('services/construction-forage-detail-page.html.twig', []);
    }


}
