<?php

namespace Choco14t\SimpleList\Resolvers;

class TypeResolver
{
    /**
     * @var ClassName
     */
    private $className;

    public function __construct(ClassName $className)
    {
        $this->className = $className;
    }

    public function resolved($element): bool
    {
        $class = $this->className->value();

        return $element instanceof $class;
    }

    public function target(): string
    {
        return $this->className->value();
    }
}
