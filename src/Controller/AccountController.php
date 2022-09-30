<?php

namespace App\Controller;

use App\Entity\User;
use App\MyServices\ClientGoogle;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AccountController
 * @package App\Controller
 * @Route("/account")
 */
class AccountController extends AbstractController
{
    /**
     * @Route("/create", name="app_create_account")
     * @param UserRepository $userRepository
     * @param ClientGoogle $clientGoogle
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordHasher
     * @return Response
     */
    public function index(UserRepository $userRepository, ClientGoogle $clientGoogle, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user=new User();
        $user->setEmail($clientGoogle->getUserEmail($request));
        $user->setPassword($passwordHasher->hashPassword($user,"0000"));
        $userRepository->add($user,true);
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }
}
