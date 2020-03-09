# PHP Simple List

A typed safe simple list for PHP.

## Usage

```php
<?php

use Choco14t\SimpleList\ImmutableList;
use Choco14t\SimpleList\Resolvers\ClassName;
use Choco14t\SimpleList\Resolvers\TypeResolver;
use Choco14t\SimpleList\SimpleList;

class Element {}

$className = new ClassName(Element::class);
$resolver = new TypeResolver($className);

$list = new SimpleList($resolver);
$immutableList = new ImmutableList($resolver);
```

## Support functions

* add
* each
* empty
* get
* insert
* remove
* size
