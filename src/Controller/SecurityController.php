<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/api/login", name="api_login")
     */
    public function login(): JsonResponse
    {
        $user=$this->getUser();
        return $this->json([
            'username' => $user->getUserIdentifier(),
            'roles' => $user->getRoles(),
            "route"=> $this->generateUrl('app_home')
        ]);
    }

    /**
     * @Route("/api/logout", name="app_logout")
     */
    public function logout()
    {

    }
}
