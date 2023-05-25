<?php

namespace App\Controller;

use App\Uploaders\FileUploader;
use App\Uploaders\ImageUploader;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class IndexController extends AbstractController {

    #[Route('/', name: 'index')]
    public function index() {

        return $this->render('index.html.twig');
    }

    #[Route('/date', name: 'date')]
    public function date(CacheInterface $cache) {
        $date = $cache->get('date', function(ItemInterface $item) {
            $item->expiresAfter(60);
            return new DateTime();
        });
        return new Response($date->format('e: Y-m-d h:i:s'));
    }

    #[Route('/test', name: 'test')]
    public function test() {

        return new JsonResponse([
            'path' => exec('whoami')
        ]);
    }

    #[Route('/testuje', name: 'test')]
    public function testuje() {

        return new JsonResponse([
            'path' => exec('whoami')
        ]);
    }
}