<?php

namespace Household\Controller;

use Household\DTO\Factory\UserIdentifierDTOFactory;
use Household\Manager\AuthManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/household/auth', name: 'auth_')]
class RegistrationController extends AbstractController
{
    public function __construct(
        private readonly AuthManager $authManager,
        private readonly UserIdentifierDTOFactory $userIdentifierDTOFactory,
    )
    {
    }

    #[Route('/registration', name: 'registration', methods: Request::METHOD_POST)]
    public function index(Request $request): Response
    {
        $user = $this->authManager->createUser($request);
        $userDTO = $this->userIdentifierDTOFactory->create($user->getUserIdentifier());

        return $this->json($userDTO, Response::HTTP_CREATED);
    }
}
