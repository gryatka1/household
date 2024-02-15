<?php

namespace App\Controller;

use ActiveUser\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/api/v1/family-auth', name: 'auth_')]
class LoginController extends AbstractController
{
    #[Route('/login', name: 'api_login', methods: Request::METHOD_POST)]
    public function index(Request $request, #[CurrentUser] ?User $user): Response
    {
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->json([
            'token' => $request->getSession()->getId(),
            'user' => $user->getUserIdentifier(),
        ]);
    }
}
