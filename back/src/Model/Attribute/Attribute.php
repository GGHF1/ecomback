<?php

namespace App\Model\Attribute;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Attribute extends AbstractAttribute
{
    public function getTypeName(): string
    {
        return 'Attribute';
    }

    public function formatValue(): string
    {
        return $this->value;
    }
}