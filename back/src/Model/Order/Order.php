<?php

namespace App\Model\Order;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Order extends AbstractOrder
{
    public function getTypeName(): string
    {
        return 'Order';
    }
}