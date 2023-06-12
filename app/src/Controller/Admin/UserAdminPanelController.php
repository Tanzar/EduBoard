<?php

namespace App\Controller\Admin;

use App\Cache\UsersCache;
use App\Entity\User;
use App\Form\EditUserFormType;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

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

    #[Route('/register', name: 'register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginFormAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('admin_users');
        }

        return $this->render('admin/forms/user/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/user/edit={id}', name: 'user_edit')]
    public function edit(User $user, Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginFormAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EditUserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('admin_users');
        }

        return $this->render('admin/forms/user/edit.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/user/delete={id}', name: 'user_delete')]
    public function delete(User $user, EntityManagerInterface $entityManager) {
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('admin_users');
    }

}