<?php

namespace App\Model\Product;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'products')]
class Product extends AbstractProduct
{
    public function getTypeName(): string
    {
        return 'Product';
    }
}