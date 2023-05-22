<?php

namespace App\Controller\Navigation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SchedulePanelController extends AbstractController {

    #[Route('/schedule', name: 'schedule')]
    public function mainSchedulePage() {
        return $this->render('schedule/main.html.twig', []);
    }

}