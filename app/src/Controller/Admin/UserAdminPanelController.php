<?php

namespace App\Controller\Admin;

use App\Cache\UsersCache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class UserAdminPanelController extends AbstractController {

    
    #[Route('/users', name: 'users', methods: ['GET'])]
    public function usersPage(UsersCache $usersCache, Request $request) {
        $args = $request->query->all();
        
        $page = (isset($args['page'])) ? (int) $args['page'] : 1;

        $active = (isset($args['active'])) ? (int) $args['active'] : -1;

        switch ($active) {
            case 1:
                $users = $usersCache->getActive($page);
                break;
            case 0:
                $users = $usersCache->getInactive($page);
                break;
            default:
            $users = $usersCache->getAll($page);
                break;
        }

        $pagesCount = $usersCache->getPagesCount();
        return $this->render('admin/users.html.twig', [
            'users' => $users,
            'page' => $page,
            'pagesCount' => $pagesCount,
            'active' => $active
        ]);
    }



}