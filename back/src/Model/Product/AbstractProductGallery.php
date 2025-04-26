<?php

namespace App\Model\Product;

use App\Model\AbstractModel;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
abstract class AbstractProductGallery extends AbstractModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected int $id;

    #[ORM\Column(type: 'string', name: 'image_url')]
    protected string $imageUrl;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'gallery')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    protected ?Product $product;

    public function getId(): int
    {
        return $this->id;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): void
    {
        $this->product = $product;
    }
}