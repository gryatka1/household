<?php

namespace Household\DTO\Factory;

use Household\DTO\UserTokenDTO;

class UserTokenDTOFactory
{
    public function create(
        string $userIdentifier,
        string $token
    ): UserTokenDTO
    {
        return new UserTokenDTO(
            userIdentifier: $userIdentifier,
            token: $token,
        );
    }
}