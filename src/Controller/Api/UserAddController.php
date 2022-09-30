<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception\ConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class UserAddController extends AbstractController
{
    public function __invoke(User $data, UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository)
    {
        $data->setRoles(['ROLE_USER']);
        $data->setPassword($passwordHasher->hashPassword($data,$data->getPassword()));
        return $data;
    }
}