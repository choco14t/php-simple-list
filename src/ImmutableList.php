<?php

namespace Choco14t\SimpleCollection;

use ArrayIterator;
use Choco14t\SimpleCollection\Contracts\Enumerable;
use Choco14t\SimpleCollection\Resolvers\TypeResolver;
use InvalidArgumentException;
use OutOfBoundsException;

class ImmutableList implements Enumerable
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
     * @return self
     */
    public function add($element)
    {
        if (!$this->resolver->resolved($element)) {
            throw new InvalidArgumentException('Element type does not match. Require type is ' . $this->resolver->target());
        }

        $clone = new static($this->resolver, $this->elements);
        $clone->elements[] = $element;

        return $clone;
    }

    /**
     * @param $element
     * @param int $index
     * @return self
     */
    public function insert($element, int $index)
    {
        if (!$this->resolver->resolved($element)) {
            throw new InvalidArgumentException('Element type does not match. Require type is ' . $this->resolver->target());
        }

        if ($this->outOfBounds($index)) {
            throw new OutOfBoundsException('Out of range index: ' . $index);
        }

        $clone = $this->elements;

        return new static(
            $this->resolver,
            array_splice($clone, $index, 0, $element)
        );
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
     * @return self
     */
    public function remove(int $index)
    {
        if ($this->outOfBounds($index)) {
            throw new OutOfBoundsException('Out of range index: ' . $index);
        }

        $clone = new static($this->resolver, $this->elements);
        unset($clone->elements[$index]);

        return $clone;
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

    private function outOfBounds(int $index)
    {
        return $index < 0 || $index >= $this->size();
    }
}
