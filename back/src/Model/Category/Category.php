<?php

namespace App\Model\Category;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Category extends AbstractCategory
{
    public function getTypeName(): string
    {
        return 'Category';
    }
}