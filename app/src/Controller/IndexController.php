<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController {

    #[Route('/', name: 'index')]
    public function index() {

        return $this->render('index.html.twig');
    }

    #[Route('/admin', name: 'admin')]
    public function mainAdminPage() {
        return $this->render('admin/main.html.twig', []);
    }

    #[Route('/classroom', name: 'classroom')]
    public function mainClassroomPage() {
        return $this->render('classroom/main.html.twig');
    }

    #[Route('/messenger', name: 'messenger')]
    public function mainMessengerPage() {
        return $this->render('messenger/main.html.twig', []);
    }

    #[Route('/schedule', name: 'schedule')]
    public function mainSchedulePage() {
        return $this->render('schedule/main.html.twig', []);
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