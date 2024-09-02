<?php

namespace Household\Controller;

use Household\DTO\Factory\UserTokenDTOFactory;
use VendorHousehold\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/api/v1/household/auth', name: 'auth_')]
class LoginController extends AbstractController
{
    public function __construct(
        private readonly UserTokenDTOFactory $userTokenDTOFactory
    )
    {
    }

    #[Route('/login', name: 'api_login', methods: Request::METHOD_POST)]
    public function index(Request $request, #[CurrentUser] ?User $user): Response
    {
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $userDTO = $this->userTokenDTOFactory->create(
            userIdentifier: $user->getUserIdentifier(),
            token: $request->getSession()->getId(),
        );

        return $this->json($userDTO);
    }
}
