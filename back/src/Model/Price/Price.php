<?php

namespace App\Model\Price;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Price extends AbstractPrice
{
    public function getTypeName(): string
    {
        return 'Price';
    }
}