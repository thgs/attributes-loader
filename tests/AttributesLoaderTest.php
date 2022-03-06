<?php

use PHPUnit\Framework\TestCase;
use Thgs\AttributesLoader\AttributesLoader;
use Thgs\AttributesLoader\TestAttribute;
use Thgs\AttributesLoader\TestAttribute2;
use Thgs\AttributesLoader\TestAttributeClassConstant;
use Thgs\AttributesLoader\TestAttributeParameter;
use Thgs\AttributesLoader\TestSubject;

class AttributesLoaderTest extends TestCase
{
    public function testCanLoadAttributesFromClass()
    {
        $loader = new AttributesLoader();

        $attributesCollected = $loader->fromClass(TestSubject::class);

        $this->assertCount(9, $attributesCollected);
        $this->assertInstanceOf(TestAttribute::class, $attributesCollected[0]);
    }

    public function testCanFilterSpecificAttribute()
    {
        $loader = new AttributesLoader();

        $attributesCollected = $loader->fromClass(TestSubject::class, onlyAttributes: [TestAttribute2::class]);

        $this->assertCount(4, $attributesCollected);
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

    // missing tests for class/method attributes but at this point they are implied from the above

    public function testCanRetrieveAttributesFromProperties()
    {
        $loader = new AttributesLoader();

        $loader->target(\Attribute::TARGET_PROPERTY);
        $attributesCollected = $loader->fromClass(TestSubject::class, onlyAttributes: [TestAttribute2::class]);

        $this->assertCount(2, $attributesCollected);
        $this->assertInstanceOf(TestAttribute2::class, $attributesCollected[0]);
        $this->assertInstanceOf(TestAttribute2::class, $attributesCollected[1]);
        $this->assertEquals('property', $attributesCollected[0]->getWhere());
        $this->assertEquals('property', $attributesCollected[1]->getWhere());
    }

    public function testCanRetrieveAttributesFromClassConstants()
    {
        $loader = new AttributesLoader();

        $loader->target(\Attribute::TARGET_CLASS_CONSTANT);
        $attributesCollected = $loader->fromClass(TestSubject::class, onlyAttributes: [TestAttributeClassConstant::class]);

        $this->assertCount(1, $attributesCollected);
        $this->assertInstanceOf(TestAttributeClassConstant::class, $attributesCollected[0]);
    }

    public function testCanRetrieveAttributesFromParameters()
    {
        $loader = new AttributesLoader();

        $loader->target(\Attribute::TARGET_PARAMETER);
        $attributesCollected = $loader->fromClass(TestSubject::class, onlyAttributes: [TestAttributeParameter::class]);

        $this->assertCount(2, $attributesCollected);
        $this->assertInstanceOf(TestAttributeParameter::class, $attributesCollected[0]);
    }
}