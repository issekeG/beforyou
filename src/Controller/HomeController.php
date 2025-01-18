<?php

namespace App\Controller;

use App\Repository\ActivityRepository;
use App\Repository\PostsRepository;
use App\Repository\RealisationRepository;
use App\Repository\SubsidiaryRepository;
use App\Repository\TeamMemberRepository;
use App\Repository\TestimonyRepository;
use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(RealisationRepository $realisationRepository,
                          SubsidiaryRepository $subsidiaryRepository,
                          TestimonyRepository $testimonyRepository,
                          PostsRepository $postsRepository): Response
    {
        $all_realisations = $realisationRepository->findAllOrderedByDate();
        $all_subsidiaries = $subsidiaryRepository->findAll();
        $all_articles = $postsRepository->findTop3OrderedByDate();
        $all_testimony =$testimonyRepository->findTop3OrderedByDate();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'all_realisations' => $all_realisations,
            'all_subsidiaries' => $all_subsidiaries,
            'all_articles' => $all_articles,
            'all_testimony' => $all_testimony,
        ]);
    }

    #[Route('/be-for-you-a-propos', name: 'app_about')]
    public function about(TeamMemberRepository $memberRepository):Response{
        $all_members = $memberRepository->findAllOrderedByRank();

        return $this->render('home/about_page.html.twig', [
            'all_members' => $all_members,
        ]);
    }

    #[Route('/be-for-you-contact', name: 'app_contact')]
    public function contact():Response{
        return $this->render('contact/contact_page.html.twig', []);
    }

    #[Route('/be-for-you-realisations', name: 'app_portfolio')]
    public function portfolio(RealisationRepository $realisationRepository):Response{
        $all_realisations = $realisationRepository->findAllOrderedByDate();

        return $this->render('portfolio/portfolio.html.twig',
            [
                'all_realisations'=>$all_realisations,
            ]);
    }

    #[Route('/be-for-you-realisation/{slug}', name: 'app_portfolio_detail')]
    public function portfolio_detail(string $slug, RealisationRepository $realisationRepository):Response{

        $realisation = $realisationRepository->findOneBySlug($slug);

        if (!$realisation) {
            throw $this->createNotFoundException('Article non trouvé.');
        }

        return $this->render('portfolio/portfolio-detail.html.twig',
            [
                'realisation'=>$realisation
            ]
        );
    }

    #[Route('/be-for-you-realisations-filter/{slug}', name: 'app_realisations_filter')]
    public function portfolio_filter_by_activity(string $slug, ActivityRepository $activityRepository,RealisationRepository $realisationRepository): Response
    {
        if($slug != null){
            $slugify = new Slugify();
            $slug = $slugify->slugify($slug);
        }

        $activity = $activityRepository->findOneBySlug($slug);

        $all_realisations = $realisationRepository->findByActivity($activity);

        return $this->render('portfolio/portfolio.html.twig',
            [
                'all_realisations'=>$all_realisations,
            ]);
    }

    #[Route('/be-for-you-equipe', name: 'app_team')]
    public function team(TeamMemberRepository $memberRepository):Response{

        $all_members = $memberRepository->findAllOrderedByRank();


        return $this->render('team/team_page.html.twig', [
            'all_members' => $all_members,
        ]);
    }

    #[Route('/be-for-you-equipe/{slug}', name: 'app_team_detail')]
    public function team_detail(string $slug, TeamMemberRepository $memberRepository):Response{
        $member = $memberRepository->findOneBySlug($slug);

        if (!$member) {
            throw $this->createNotFoundException('membre non trouvé.');
        }
        return $this->render('team/team_detail_page.html.twig', [
            'member' => $member,
        ]);
    }

    #[Route('/be-for-you-blogs', name: 'app_blog_indexs')]
    public function blog_index():Response{
        return $this->render('blogs/index_page.html.twig', []);
    }


}
