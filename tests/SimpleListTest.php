<?php

namespace Tests;

use Choco14t\SimpleCollection\SimpleList;
use Choco14t\SimpleCollection\Resolvers\ClassName;
use Choco14t\SimpleCollection\Resolvers\TypeResolver;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\DummyItem;
use Tests\Fixtures\DummyUser;

/**
 * Class SimpleListTest
 * @package Tests
 */
class SimpleListTest extends TestCase
{
    /**
     * @param SimpleList $collection
     * @dataProvider collectionProvider
     */
    public function testAddSuccess($collection)
    {
        $collection->add(new DummyItem());

        $this->assertFalse($collection->empty());
    }

    /**
     * @param SimpleList $collection
     * @dataProvider collectionProvider
     * @expectedException InvalidArgumentException
     */
    public function testAddFailure($collection)
    {
        $collection->add(new DummyUser());
    }

    /**
     * @param SimpleList $collection
     * @dataProvider collectionProvider
     */
    public function testGet($collection)
    {
        $index = 0;
        $collection->add(new DummyItem());

        $this->assertTrue($collection->get($index) instanceof DummyItem);
    }

    /**
     * @param SimpleList $collection
     * @dataProvider collectionProvider
     */
    public function testRemove($collection)
    {
        $index = 0;
        $collection->add(new DummyItem());
        $this->assertFalse($collection->empty());

        $collection->remove($index);
        $this->assertTrue($collection->empty());
    }

    /**
     * @return array
     */
    public function collectionProvider()
    {
        $resolver = new TypeResolver(new ClassName(DummyItem::class));
        $collection = new SimpleList($resolver);

        return [
            [$collection],
        ];
    }
}
