<?php

namespace App\DTO;

interface DTOInterface
{
    public function jsonSerialize(): array;
}
