<?php

namespace Household\DTO\Factory;

use Household\DTO\UserIdentifierDTO;

class UserIdentifierDTOFactory
{
    public function create(
        string $userIdentifier,
    ): UserIdentifierDTO
    {
        return new UserIdentifierDTO(
            userIdentifier: $userIdentifier,
        );
    }
}