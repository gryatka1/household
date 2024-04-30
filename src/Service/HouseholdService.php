<?php

namespace App\Service;

use ActiveUser\Entity\Household;
use ActiveUser\Enum\HouseholdType;
use ActiveUser\DTO\HouseholdDTO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use DateTimeImmutable;

class HouseholdService
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function createHousehold(Request $request): HouseholdDTO
    {
        $type = HouseholdType::tryFrom($request->get('type'));

        if (!$type) {
            throw new \InvalidArgumentException('Invalid household type');
        }

        $household = new Household($type);

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

    public function deleteHousehold(Household $household):  HouseholdDTO
    {
        $household->setDeletedAt(new DateTimeImmutable());

        $this->save($household);

        return Household::asDTO($household);
    }
}
