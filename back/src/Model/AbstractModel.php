<?php

namespace App\Model;

abstract class AbstractModel
{
    abstract public function getTypeName(): string;
}