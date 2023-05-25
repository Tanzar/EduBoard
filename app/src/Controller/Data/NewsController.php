<?php

namespace App\Controller\Data;

use App\Cache\ArticleCache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/news' , name: 'news_')]
class NewsController extends AbstractController {

    #[Route('/latest', name: 'latest', methods: 'GET')]
    public function getLatestNews(ArticleCache $articleCache) {
        $articles = $articleCache->getLatest();

        return new JsonResponse([
            'date' => date('Y-m-d'),
            'news' => $articles
        ]);
    }

    #[Route('/page/{page}', name: 'page', methods: 'GET')]
    public function getPage(ArticleCache $articleCache, int $page = 1) {
        $articles = $articleCache->getPage($page);
        return new JsonResponse([
            'date' => date('Y-m-d'),
            'news' => $articles
        ]);
    }

    
}
