<?php

namespace App\Model\Product;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Model\Attribute\AbstractAttributeSet; // Add import

#[ORM\MappedSuperclass]
abstract class AbstractProduct
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    protected $id;

    #[ORM\Column(type: 'string')]
    protected $name;

    #[ORM\Column(type: 'boolean')]
    protected $inStock;

    #[ORM\Column(type: 'text', nullable: true)]
    protected $description;

    #[ORM\Column(type: 'string')]
    protected $category;

    #[ORM\Column(type: 'string')]
    protected $brand;

    #[ORM\OneToMany(targetEntity: ProductGallery::class, mappedBy: 'product', cascade: ['persist', 'remove'])]
    protected $gallery;

    #[ORM\ManyToMany(targetEntity: AbstractAttributeSet::class)]
    #[ORM\JoinTable(name: 'product_attributes')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'attribute_set_id', referencedColumnName: 'id')]
    protected $attributeSets; // Add relationship

    public function __construct()
    {
        $this->gallery = new ArrayCollection();
        $this->attributeSets = new ArrayCollection(); // Initialize
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getInStock(): bool
    {
        return $this->inStock;
    }

    public function setInStock(bool $inStock): void
    {
        $this->inStock = $inStock;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function getGallery(): Collection
    {
        return $this->gallery;
    }

    public function addGallery(ProductGallery $gallery): void
    {
        if (!$this->gallery->contains($gallery)) {
            $this->gallery[] = $gallery;
            $gallery->setProduct($this);
        }
    }

    public function removeGallery(ProductGallery $gallery): void
    {
        if ($this->gallery->contains($gallery)) {
            $this->gallery->removeElement($gallery);
            $gallery->setProduct(null);
        }
    }

    public function getAttributeSets(): Collection
    {
        return $this->attributeSets;
    }

    public function addAttributeSet(AbstractAttributeSet $attributeSet): void
    {
        if (!$this->attributeSets->contains($attributeSet)) {
            $this->attributeSets[] = $attributeSet;
        }
    }

    public function removeAttributeSet(AbstractAttributeSet $attributeSet): void
    {
        $this->attributeSets->removeElement($attributeSet);
    }
}