<?php

namespace Household\Controller;

use Symfony\Component\Security\Http\Attribute\CurrentUser;
use VendorHousehold\Entity\Household;
use Household\Service\HouseholdService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use VendorHousehold\Entity\User;

#[Route('/api/v1/household/household', name: 'household_')]
class HouseholdController extends AbstractController
{
    public function __construct(private readonly HouseholdService $householdService)
    {
    }

    #[Route('/create', name: 'create_household', methods: Request::METHOD_POST)]
    public function createHousehold(Request $request, #[CurrentUser] User $user): JsonResponse
    {
        return $this->json($this->householdService->createHousehold($request, $user), Response::HTTP_CREATED);
    }

    #[Route('/get/{id}', name: 'get_household', requirements: ['id' => Requirement::DIGITS], methods: Request::METHOD_GET)]
    public function getHousehold(Household $household): JsonResponse
    {
        return $this->json(Household::asDTO($household), Response::HTTP_OK);
    }

    #[Route('/update-type/{id}', name: 'update-household-title', requirements: ['id' => Requirement::DIGITS], methods: Request::METHOD_POST)]
    public function updateHouseholdType(Request $request, Household $household): JsonResponse
    {
        return $this->json($this->householdService->updateHouseholdType($request, $household), Response::HTTP_OK);
    }

    #[Route('/delete/{id}', name: 'delete_household', requirements: ['id' => Requirement::DIGITS], methods: Request::METHOD_DELETE)]
    public function deleteHousehold(Household $household): JsonResponse
    {
        return $this->json($this->householdService->deleteHousehold($household), Response::HTTP_OK);
    }

    #[Route('{id}/add-user/{user_id}', name: 'add_user', requirements: ['id' => Requirement::DIGITS, 'user_id' => Requirement::DIGITS], methods: Request::METHOD_POST)]
    public function addUser(Household $household, User $user): JsonResponse
    {
        return $this->json($this->householdService->addUser($household, $user), Response::HTTP_OK);
    }

    #[Route('{id}/remove-user/{user_id}', name: 'remove_user', requirements: ['id' => Requirement::DIGITS, 'user_id' => Requirement::DIGITS], methods: Request::METHOD_POST)]
    public function removeUser(Household $household, User $user): JsonResponse
    {
        return $this->json($this->householdService->removeUser($household, $user), Response::HTTP_OK);
    }
}
