<?php

namespace Household\DTO;

interface AsDTOInterface
{
    public static function asDTO(AsDTOInterface $entity): DTOInterface;
}
