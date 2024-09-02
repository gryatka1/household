<?php

namespace Household\DTO;

use JsonSerializable;

class UserTokenDTO implements JsonSerializable
{
    public function __construct(
        public string $userIdentifier,
        public string $token,
    )
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}