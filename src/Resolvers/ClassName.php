<?php

namespace Choco14t\SimpleList\Resolvers;

use InvalidArgumentException;

class ClassName
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        if (!class_exists($value)) {
            throw new InvalidArgumentException('Class not exist: ' . $value);
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }
}
