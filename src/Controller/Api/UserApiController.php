<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class UserApiController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security=$security;
    }

    public function __invoke()
    {
        return $this->security->getUser();
    }
}
