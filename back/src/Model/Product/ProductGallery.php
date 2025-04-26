<?php

namespace App\Model\Product;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'product_gallery')]
class ProductGallery extends AbstractProductGallery
{
    public function getTypeName(): string
    {
        return 'ProductGallery';
    }
}