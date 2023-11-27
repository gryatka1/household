<?php

namespace App\Controller;

use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/family-auth', name: 'auth_')]
class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'registration', methods: Request::METHOD_POST)]
    public function index(Request $request, AuthService $authService): Response
    {
        $user = $authService->createUser($request);

        return $this->json([
            'user' => $user->getUserIdentifier(),
        ]);
    }
}