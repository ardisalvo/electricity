<?php

namespace Src\_Shared\Domain\ValueObject;

class IntegerValueObject
{
    protected $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string)$this->value();
    }
}
