<?php

namespace App\Controller;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController {

    #[Route('/', name: 'index')]
    public function index() {

        return $this->render('index.html.twig');
    }

    #[Route('/date', name: 'date')]
    public function date() {
        $date = new DateTime();
        return new Response($date->format('e: Y-m-d h:i:s'));
    }
}