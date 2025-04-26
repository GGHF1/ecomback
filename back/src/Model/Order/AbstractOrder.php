<?php

namespace App\Model\Order;

use App\Model\AbstractModel;
use App\Model\Product\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'orders')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type_name', type: 'string')]
#[ORM\DiscriminatorMap(['Order' => Order::class])]
abstract class AbstractOrder extends AbstractModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected int $id;

    #[ORM\ManyToMany(targetEntity: Product::class)]
    #[ORM\JoinTable(name: 'order_products')]
    #[ORM\JoinColumn(name: 'order_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'product_id', referencedColumnName: 'id')]
    protected Collection $products;

    #[ORM\Column(type: 'datetime')]
    protected \DateTime $createdAt;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): void
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
        }
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    abstract public function getTypeName(): string;
}