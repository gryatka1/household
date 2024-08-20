<?php

namespace Household\Service;

use VendorHousehold\Entity\Household;
use VendorHousehold\Entity\User;
use VendorHousehold\Enum\HouseholdType;
use VendorHousehold\DTO\HouseholdDTO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use DateTimeImmutable;
use InvalidArgumentException;

class HouseholdService
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function createHousehold(Request $request, User $user): HouseholdDTO
    {
        $type = HouseholdType::tryFrom($request->get('type'));

        if (!$type) {
            throw new InvalidArgumentException('Invalid household type');
        }

        $household = new Household($type, $user);

        $this->save($household);

        return Household::asDTO($household);
    }

    private function save(Household $taskGroup): void
    {
        $this->entityManager->persist($taskGroup);
        $this->entityManager->flush();
    }

    public function updateHouseholdType(Request $request, Household $household): HouseholdDTO
    {
        $household->setType($request->get('type'));

        $this->save($household);

        return Household::asDTO($household);
    }

    public function deleteHousehold(Household $household): HouseholdDTO
    {
        $household->setDeletedAt(new DateTimeImmutable());

        $this->save($household);

        return Household::asDTO($household);
    }

    public function addUser(Household $household, User $user): HouseholdDTO
    {
        $household->addUser($user);

        $this->save($household);

        return Household::asDTO($household);
    }

    public function removeUser(Household $household, User $user): HouseholdDTO
    {
        $household->removeUser($user);

        $this->save($household);

        return Household::asDTO($household);
    }
}
