<?php

use PHPUnit\Framework\TestCase;
use Thgs\AttributesLoader\AttributesLoader;
use Thgs\AttributesLoader\TestAttribute;
use Thgs\AttributesLoader\TestAttribute2;
use Thgs\AttributesLoader\TestSubject;

class AttributesLoaderTest extends TestCase
{
    public function testCanLoadAttributesFromClass()
    {
        $loader = new AttributesLoader();

        $attributesCollected = $loader->fromClass(TestSubject::class);

        $this->assertCount(3, $attributesCollected);
        $this->assertInstanceOf(TestAttribute::class, $attributesCollected[0]);
    }

    public function testCanFilterSpecificAttribute()
    {
        $loader = new AttributesLoader();

        $attributesCollected = $loader->fromClass(TestSubject::class, onlyAttributes: [TestAttribute2::class]);

        $this->assertCount(1, $attributesCollected);
        $this->assertInstanceOf(TestAttribute2::class, $attributesCollected[0]);
    }

    public function testCanFilterSpecificTarget()
    {
        $loader = new AttributesLoader();

        $loader->target(\Attribute::TARGET_METHOD);
        $attributesCollected = $loader->fromClass(TestSubject::class, onlyAttributes: [TestAttribute::class]);

        $this->assertCount(1, $attributesCollected);
        $this->assertInstanceOf(TestAttribute::class, $attributesCollected[0]);
        $this->assertEquals('method', $attributesCollected[0]->getWhere());
    }
}