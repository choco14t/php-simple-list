<?php

namespace Tests;

use Choco14t\SimpleCollection\ImmutableList;
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
class ImmutableListTest extends TestCase
{
    /**
     * @param ImmutableList $collection
     * @dataProvider collectionProvider
     */
    public function testAddSuccess($collection)
    {
        $newCollection = $collection->add(new DummyItem());

        $this->assertTrue($collection->empty());
        $this->assertFalse($newCollection->empty());
    }

    /**
     * @param ImmutableList $collection
     * @dataProvider collectionProvider
     * @expectedException InvalidArgumentException
     */
    public function testAddFailure($collection)
    {
        $collection->add(new DummyUser());
    }

    /**
     * @param ImmutableList $collection
     * @dataProvider collectionProvider
     */
    public function testGet($collection)
    {
        $index = 0;
        $newCollection = $collection->add(new DummyItem());

        $this->assertTrue($newCollection->get($index) instanceof DummyItem);
    }

    /**
     * @param ImmutableList $collection
     * @dataProvider collectionProvider
     */
    public function testRemove($collection)
    {
        $index = 0;
        $newCollection = $collection->add(new DummyItem());
        $removedCollection = $newCollection->remove($index);

        $this->assertFalse($newCollection->empty());
        $this->assertTrue($removedCollection->empty());
    }

    /**
     * @return array
     */
    public function collectionProvider()
    {
        $resolver = new TypeResolver(new ClassName(DummyItem::class));
        $collection = new ImmutableList($resolver);

        return [
            [$collection],
        ];
    }
}
