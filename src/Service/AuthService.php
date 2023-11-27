<?php

namespace App\Service;

use App\Entity\ActiveUser\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthService
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function createUser(Request $request): User
    {
        $user = new User();
        $password = $request->get('password');
        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);

        $user
            ->setEmail($request->get('email'))
            ->setPassword($hashedPassword)
            ->setRoles(['someRole']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
