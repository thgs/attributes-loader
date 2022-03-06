<?php

use PHPUnit\Framework\TestCase;
use Thgs\AttributesLoader\AttributesLoader;
use Thgs\AttributesLoader\TestAttribute;
use Thgs\AttributesLoader\TestSubject;

class AttributesLoaderTest extends TestCase
{
    public function testCanLoadAttributesFromClass()
    {
        $loader = new AttributesLoader();
        $loader->fromClass(TestSubject::class);

        $attributesCollected = $loader->getAttributesCollected();

        $this->assertCount(2, $attributesCollected);
        $this->assertArrayIsList($attributesCollected);
        $this->assertInstanceOf(TestAttribute::class, $attributesCollected[0]);
    }
}