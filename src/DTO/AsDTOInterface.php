<?php

namespace App\DTO;

interface AsDTOInterface
{
    public static function asDTO(AsDTOInterface $entity): DTOInterface;
}
