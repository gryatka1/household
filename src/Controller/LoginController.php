<?php

namespace App\Controller;

use App\Entity\ActiveUser\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/api/v1/family-auth', name: 'auth_')]
class LoginController extends AbstractController
{
    #[Route('/login', name: 'api_login', methods: Request::METHOD_POST)]
    public function index(#[CurrentUser] ?User $user): Response
    {
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = 12;

        return $this->json([
            'user' => $user->getUserIdentifier(),
            'token' => $token,
        ]);
    }

    #[Route('/test-login', name: 'api_login2', methods: Request::METHOD_POST)]
    public function index2(): Response
    {
        $user = $this->getUser();


        $token = 12;

        return $this->json([
            'getUserIdentifier' => $user?->getUserIdentifier(),
        ]);
    }
}