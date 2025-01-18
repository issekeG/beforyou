<?php

namespace App\Controller;

use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class BlogController extends AbstractController
{
    #[Route('/be-for-you-blog',name: 'app_blog_index', methods: ['GET'])]
    public function index(PostsRepository $postsRepository): Response
    {
        $all_articles = $postsRepository->findAllOrderedByDate();

        return $this->render('blogs/index_page.html.twig', [
            'all_articles' => $all_articles
        ]);
    }

    #[Route('/be-for-you-article/{slug}', name: 'app_article_detail')]
    public function blog_article(string $slug, PostsRepository $postsRepository): Response
    {
        // Récupérer l'article correspondant au slug
        $article = $postsRepository->findOneBy(['slug' => $slug]);

        if (!$article) {
            throw $this->createNotFoundException('Article non trouvé.');
        }
        $related_articles = $postsRepository->findBySector($article->getSector());

        // Rendre le template avec les données de l'article
        return $this->render('blogs/article_details.html.twig', [
            'article' => $article,
            'related_articles' => $related_articles,
        ]);
    }

}
