<?php

namespace Household\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use VendorHousehold\Entity\User;
use VendorHousehold\Factory\UserFactory;

class AuthManager
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserFactory            $userFactory,
    )
    {
    }

    public function createUser(Request $request): User
    {
        $user = $this->userFactory->create(
            email: $request->get('email'),
            password: $request->get('password'),
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
