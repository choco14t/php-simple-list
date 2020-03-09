<?php

namespace Choco14t\SimpleList\Contracts;

use IteratorAggregate;

interface Enumerable extends IteratorAggregate, Jsonable, Arrayable
{
    /**
     * @param $element
     */
    public function add($element);

    /**
     * @param $element
     * @param int $index
     */
    public function insert($element, int $index);

    /**
     * @param int $index
     * @return mixed
     */
    public function get(int $index);

    /**
     * @param int $index
     */
    public function remove(int $index);

    /**
     * @return int
     */
    public function size(): int;

    /**
     * @return bool
     */
    public function empty(): bool;

    /**
     * @param callable $closure
     * @return mixed
     */
    public function each(callable $closure);
}
