<?php

namespace Household\Manager;

use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use VendorHousehold\Entity\Household;
use VendorHousehold\Entity\User;
use VendorHousehold\Enum\HouseholdType;
use VendorHousehold\Factory\HouseholdFactory;

class HouseholdManager
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly HouseholdFactory       $householdFactory,
    )
    {
    }

    public function createHousehold(Request $request, User $user): Household
    {
        $type = HouseholdType::tryFrom($request->get('type'));

        if (!$type) {
            throw new InvalidArgumentException('Invalid household type');
        }

        $household = $this->householdFactory->create($type, $user);

        $this->save($household);

        return $household;
    }

    private function save(Household $taskGroup): void
    {
        $this->entityManager->persist($taskGroup);
        $this->entityManager->flush();
    }

    public function updateHouseholdType(Request $request, Household $household): Household
    {
        $type = HouseholdType::tryFrom($request->get('type'));

        if (!$type) {
            throw new InvalidArgumentException('Invalid household type');
        }

        $household->setType($type);

        $this->save($household);

        return $household;
    }

    public function deleteHousehold(Household $household): Household
    {
        $household->setDeletedAt(new DateTimeImmutable());

        $this->save($household);

        return $household;
    }

    public function addUser(Household $household, User $user): Household
    {
        $household->addUser($user);

        $this->save($household);

        return $household;
    }

    public function removeUser(Household $household, User $user): Household
    {
        $household->removeUser($user);

        $this->save($household);

        return $household;
    }
}
