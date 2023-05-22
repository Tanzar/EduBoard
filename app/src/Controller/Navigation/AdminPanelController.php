<?php

namespace App\Controller\Navigation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminPanelController extends AbstractController {


    #[Route('/admin', name: 'admin')]
    public function mainAdminPage() {
        return $this->render('admin/main.html.twig', []);
    }

}