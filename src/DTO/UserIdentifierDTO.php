<?php

namespace Household\DTO;

use JsonSerializable;

class UserIdentifierDTO implements JsonSerializable
{
    public function __construct(
        public string $userIdentifier,
    )
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}