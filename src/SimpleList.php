<?php

namespace Choco14t\SimpleCollection;

use ArrayIterator;
use Choco14t\SimpleCollection\Resolvers\TypeResolver;
use Choco14t\SimpleCollection\Contracts\Enumerable;
use InvalidArgumentException;
use OutOfBoundsException;

class SimpleList implements Enumerable
{
    /**
     * @var array
     */
    protected $elements;

    /**
     * @var TypeResolver
     */
    private $resolver;

    public function __construct(TypeResolver $resolver, array $elements = [])
    {
        $this->resolver = $resolver;
        $this->elements = $elements;
    }

    /**
     * @param $element
     */
    public function add($element): void
    {
        if (!$this->resolver->resolved($element)) {
            throw new InvalidArgumentException('Element type does not match. Require type is ' . $this->resolver->target());
        }

        $this->elements[] = $element;
    }

    /**
     * @param $element
     * @param int $index
     */
    public function insert($element, int $index): void
    {
        if (!$this->resolver->resolved($element)) {
            throw new InvalidArgumentException('Element type does not match. Require type is ' . $this->resolver->target());
        }

        if ($index < 0 || $index >= $this->size()) {
            throw new OutOfBoundsException('Out of range index: ' . $index);
        }

        array_splice($this->elements, $index, 0, $element);
    }

    /**
     * @param int $index
     * @return mixed
     */
    public function get(int $index)
    {
        if ($index < 0 || $index >= $this->size()) {
            throw new OutOfBoundsException('Out of range index: ' . $index);
        }

        return $this->elements[$index];
    }

    /**
     * @param int $index
     */
    public function remove(int $index)
    {
        if ($index < 0 || $index >= $this->size()) {
            throw new OutOfBoundsException('Out of range index: ' . $index);
        }

        unset($this->elements[$index]);
    }

    /**
     * @return int
     */
    public function size(): int
    {
        return count($this->elements);
    }

    /**
     * @return bool
     */
    public function empty(): bool
    {
        return empty($this->elements);
    }

    /**
     * @param callable $closure
     */
    public function each(callable $closure)
    {
        foreach ($this->elements as $index => $element) {
            $closure($element, $index, $this->elements);
        }
    }

    public function toArray(): array
    {
        return $this->elements;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->elements);
    }

    public function toJson(int $options = 0, int $depth = 512): string
    {
        return json_encode($this->elements, $options, $depth);
    }
}
