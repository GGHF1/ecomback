<?php

namespace App\Model\Currency;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Currency extends AbstractCurrency
{
    public function getTypeName(): string
    {
        return 'Currency';
    }
}