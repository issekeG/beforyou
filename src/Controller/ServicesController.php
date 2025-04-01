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

            if ($slug == 'projets-d-infrastructure-et-construction-btp'){
                return $this->render('services/industrie/projets-infrastructure-construction-btp.html.twig', []);
            }
            else if ($slug == 'bureau-d-etudes-et-ingenierie'){
                return $this->render('services/industrie/bureau-etudes-projets-infrastructure.html.twig', []);
            }
            else if ($slug == 'maintenance-assistance-technique-et-forage-d-eau'){
                return $this->render('services/industrie/maintenance-assistance-technique-forage-eau.html.twig', []);
            }
            else if ($slug == 'impression-numerique-et-offset'){
                return $this->render('services/print/impression-numerique-et-offset.html.twig', []);
            }
            else if ($slug == 'conception-graphique-et-design'){
                return $this->render('services/print/conception-graphique-et-design.html.twig', []);
            }
            else if ($slug == 'impression-textile-et-tampographie'){
                return $this->render('services/print/impression-textile-tampographie.html.twig', []);
            }
            else if ($slug == 'conception-et-fabrication-d-uniformes-scolaires'){
                return $this->render('services/school/conception-fabrication-uniformes-scolaires.html.twig', []);
            }
            else if ($slug == 'collaboration-avec-ecoles-et-institutions-locales'){
                return $this->render('services/school/collaboration-ecoles-institutions-locales.html.twig', []);
            }
            else if ($slug == 'conseil-en-communication-et-strategie-de-marque'){
                return $this->render('services/communication/conseil-communication-strategie-marque.html.twig', []);
            }
            else if ($slug == 'organisation-d-evenements-et-relations-publiques'){
                return $this->render('services/communication/organisation-evenements-relations-publiques.html.twig', []);
            }
            else if ($slug == 'gestion-des-reseaux-sociaux-et-campagnes-publicitaires'){
                return $this->render('services/communication/gestion-reseaux-sociaux-campagnes-publicitaires.html.twig', []);
            }
            else if ($slug == 'initiatives-sociales-et-environnementales'){
                return $this->render('services/rse/initiatives-sociales-environnementales.html.twig', []);
            }
            else if ($slug == 'projets-de-developpement-communautaire'){
                return $this->render('services/rse/projets-developpement-communautaire.html.twig', []);
            }
            else if ($slug == 'programmes-de-formation-et-d-emploi-pour-les-jeunes'){
                return $this->render('services/rse/programmes-formation-emploi-jeunes.html.twig', []);
            }
        }

        return $this->redirectToRoute('app_activity');
    }


}
