<?php

namespace App\Controller\Admin;

use App\Entity\Activity;
use App\Entity\Formation;
use App\Entity\FormationCategory;
use App\Entity\Posts;
use App\Entity\Realisation;
use App\Entity\Student;
use App\Entity\Subsidiary;
use App\Entity\TeamMember;
use App\Entity\Testimony;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
    #[Route('/be-for-you-admin', name: 'admin')]
    #[isGranted('ROLE_ADMIN')]
    public function index(): Response
    {

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
         return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Be for you Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Filiale', 'fas fa-building', Subsidiary::class);
        yield MenuItem::linkToCrud('Activité', 'fas fa-chart-line', Activity::class);
        yield MenuItem::linkToCrud('Réalisation', 'fas fa-check-circle', Realisation::class);
        yield MenuItem::linkToCrud('Article', 'far fa-newspaper', Posts::class);
        yield MenuItem::linkToCrud('Membre', 'fas fa-user-friends', TeamMember::class);
        yield MenuItem::linkToCrud('Témoignages', 'fas fa-comment-alt', Testimony::class);
        yield MenuItem::linkToCrud('Formation', 'fas fa-graduation-cap', Formation::class);
        yield MenuItem::linkToCrud('Formation Category', 'fas fa-layer-group', FormationCategory::class);
        yield MenuItem::linkToCrud('Candidat', 'fas fa-user-graduate', Student::class);

    }
}
