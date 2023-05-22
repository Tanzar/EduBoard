<?php

namespace App\Controller\Navigation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MessengerPanelController extends AbstractController {

    #[Route('/messenger', name: 'messenger')]
    public function mainMessengerPage() {
        return $this->render('messenger/main.html.twig', []);
    }
}