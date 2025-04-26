<?php

namespace App\Model\Attribute;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class AttributeSet extends AbstractAttributeSet
{
    public function getTypeName(): string
    {
        return 'AttributeSet';
    }
}