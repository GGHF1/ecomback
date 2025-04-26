<?php

namespace App\Model\Attribute;

use App\Model\AbstractModel;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'attributes')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type_name', type: 'string')]
#[ORM\DiscriminatorMap(['Attribute' => Attribute::class])]
abstract class AbstractAttribute extends AbstractModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected int $id;

    #[ORM\ManyToOne(targetEntity: AbstractAttributeSet::class, inversedBy: 'attributes')]
    #[ORM\JoinColumn(name: 'attribute_set_id', referencedColumnName: 'id')]
    protected AbstractAttributeSet $attributeSet;

    #[ORM\Column(type: 'string', length: 100, name: 'display_value')]
    protected string $display_value;

    #[ORM\Column(type: 'string', length: 100)]
    protected string $value;

    #[ORM\Column(type: 'string', length: 50, name: 'item_id')]
    protected string $itemId;

    public function getId(): int
    {
        return $this->id;
    }

    public function getAttributeSet(): AbstractAttributeSet
    {
        return $this->attributeSet;
    }

    public function setAttributeSet(AbstractAttributeSet $attributeSet): void
    {
        $this->attributeSet = $attributeSet;
    }

    public function getDisplayValue(): string
    {
        return $this->display_value;
    }

    public function setDisplayValue(string $display_value): void
    {
        $this->display_value = $display_value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function getItemId(): string
    {
        return $this->itemId;
    }

    public function setItemId(string $itemId): void
    {
        $this->itemId = $itemId;
    }

    abstract public function getTypeName(): string;
    abstract public function formatValue(): string;
}