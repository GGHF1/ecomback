<?php

namespace App\Model\Currency;

use App\Model\AbstractModel;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'currencies')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type_name', type: 'string')]
#[ORM\DiscriminatorMap(['Currency' => Currency::class])]
abstract class AbstractCurrency extends AbstractModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected int $id;

    #[ORM\Column(type: 'string', length: 10)]
    protected string $label;

    #[ORM\Column(type: 'string', length: 5)]
    protected string $symbol;

    public function getId(): int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): void
    {
        $this->symbol = $symbol;
    }

    abstract public function getTypeName(): string;
}