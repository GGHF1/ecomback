<?php

namespace App\Model\Attribute;

use App\Model\AbstractModel;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'attribute_sets')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type_name', type: 'string')]
#[ORM\DiscriminatorMap(['AttributeSet' => AttributeSet::class])]
abstract class AbstractAttributeSet extends AbstractModel
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 50)]
    protected string $id;

    #[ORM\Column(type: 'string', length: 100)]
    protected string $name;

    #[ORM\Column(type: 'string', length: 50)]
    protected string $type;

    #[ORM\OneToMany(targetEntity: AbstractAttribute::class, mappedBy: 'attributeSet')]
    protected Collection $attributes;

    public function __construct()
    {
        $this->attributes = new ArrayCollection();
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

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getAttributes(): Collection
    {
        return $this->attributes;
    }

    abstract public function getTypeName(): string;
}