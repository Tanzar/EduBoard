<?php

namespace App\Controller\Data;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/news' , name: 'news_')]
class NewsController extends AbstractController {

    #[Route('/latest', name: 'latest', methods: 'GET')]
    public function getLatestNews() {

        return new JsonResponse([
            'date' => date('Y-m-d'),
            'news' => []
        ]);
    }

}
