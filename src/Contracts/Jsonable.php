<?php

namespace Choco14t\SimpleList\Contracts;

interface Jsonable
{
    public function toJson(int $options = 0, int $depth = 512): string;
}
