<?php

namespace Household\Controller;

use Household\Manager\HouseholdManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use VendorHousehold\DTO\Factory\HouseholdDTOFactory;
use VendorHousehold\Entity\Household;
use VendorHousehold\Entity\User;

#[Route('/api/v1/household/household', name: 'household_')]
class HouseholdController extends AbstractController
{
    public function __construct(
        private readonly HouseholdManager $householdManager,
        private readonly HouseholdDTOFactory $householdDTOFactory,
    )
    {
    }

    #[Route('/create', name: 'create_household', methods: Request::METHOD_POST)]
    public function createHousehold(Request $request, #[CurrentUser] User $user): JsonResponse
    {
        $household = $this->householdManager->createHousehold($request, $user);
        $householdDTO = $this->householdDTOFactory->create($household);

        return $this->json($householdDTO, Response::HTTP_CREATED);
    }

    #[Route('/get/{id}', name: 'get_household', requirements: ['id' => Requirement::DIGITS], methods: Request::METHOD_GET)]
    public function getHousehold(Household $household): JsonResponse
    {
        $householdDTO = $this->householdDTOFactory->create($household);

        return $this->json($householdDTO, Response::HTTP_OK);
    }

    #[Route('/update-type/{id}', name: 'update-household-title', requirements: ['id' => Requirement::DIGITS], methods: Request::METHOD_POST)]
    public function updateHouseholdType(Request $request, Household $household): JsonResponse
    {
        $household = $this->householdManager->updateHouseholdType($request, $household);
        $householdDTO = $this->householdDTOFactory->create($household);

        return $this->json($householdDTO, Response::HTTP_OK);
    }

    #[Route('/delete/{id}', name: 'delete_household', requirements: ['id' => Requirement::DIGITS], methods: Request::METHOD_DELETE)]
    public function deleteHousehold(Household $household): JsonResponse
    {
        $household = $this->householdManager->deleteHousehold($household);
        $householdDTO = $this->householdDTOFactory->create($household);

        return $this->json($householdDTO, Response::HTTP_OK);
    }

    #[Route('{id}/add-user/{user_id}', name: 'add_user', requirements: ['id' => Requirement::DIGITS, 'user_id' => Requirement::DIGITS], methods: Request::METHOD_POST)]
    public function addUser(Household $household, User $user): JsonResponse
    {
        $household = $this->householdManager->addUser($household, $user);
        $householdDTO = $this->householdDTOFactory->create($household);

        return $this->json($householdDTO, Response::HTTP_OK);
    }

    #[Route('{id}/remove-user/{user_id}', name: 'remove_user', requirements: ['id' => Requirement::DIGITS, 'user_id' => Requirement::DIGITS], methods: Request::METHOD_POST)]
    public function removeUser(Household $household, User $user): JsonResponse
    {
        $household = $this->householdManager->removeUser($household, $user);
        $householdDTO = $this->householdDTOFactory->create($household);

        return $this->json($householdDTO, Response::HTTP_OK);
    }
}
