<?php

namespace App\Controller\Navigation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomPanelController extends AbstractController {

    #[Route('/classroom', name: 'classroom')]
    public function mainClassroomPage() {
        return $this->render('classroom/main.html.twig');
    }
}