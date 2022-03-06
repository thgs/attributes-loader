<?php

use PHPUnit\Framework\TestCase;
use Thgs\AttributesLoader\FluentAttributeCollector;
use Thgs\AttributesLoader\TestAttribute;
use Thgs\AttributesLoader\TestAttribute2;
use Thgs\AttributesLoader\TestAttributeClassConstant;
use Thgs\AttributesLoader\TestAttributeParameter;
use Thgs\AttributesLoader\TestSubject;

class FluentAttributeCollectorTest extends TestCase
{
    public function testCanLoadAttributesFromClass()
    {
        $attributesCollected = FluentAttributeCollector::new()
            ->fromClass(TestSubject::class)
            ->getCollectedAttributes();

        $this->assertCount(9, $attributesCollected);
        $this->assertInstanceOf(TestAttribute::class, $attributesCollected[0]);
    }

    public function testCanFilterSpecificAttribute()
    {
        $attributesCollected = FluentAttributeCollector::new()
            ->only(onlyAttributes: [TestAttribute2::class])
            ->fromClass(TestSubject::class)
            ->getCollectedAttributes();

        $this->assertCount(4, $attributesCollected);
        $this->assertInstanceOf(TestAttribute2::class, $attributesCollected[0]);
    }

    public function testCanFilterSpecificTarget()
    {
        $attributesCollected = FluentAttributeCollector::new()
            ->only([TestAttribute::class])
            ->target(\Attribute::TARGET_METHOD)
            ->fromClass(TestSubject::class)
            ->getCollectedAttributes();

        $this->assertCount(1, $attributesCollected);
        $this->assertInstanceOf(TestAttribute::class, $attributesCollected[0]);
        $this->assertEquals('method', $attributesCollected[0]->getWhere());
    }

    // missing tests for class/method attributes but at this point they are implied from the above

    public function testCanRetrieveAttributesFromProperties()
    {
        $attributesCollected = FluentAttributeCollector::new()
            ->only([TestAttribute2::class])
            ->target(\Attribute::TARGET_PROPERTY)
            ->fromClass(TestSubject::class)
            ->getCollectedAttributes();

        $this->assertCount(2, $attributesCollected);
        $this->assertInstanceOf(TestAttribute2::class, $attributesCollected[0]);
        $this->assertInstanceOf(TestAttribute2::class, $attributesCollected[1]);
        $this->assertEquals('property', $attributesCollected[0]->getWhere());
        $this->assertEquals('property', $attributesCollected[1]->getWhere());
    }

    public function testCanRetrieveAttributesFromClassConstants()
    {
        $attributesCollected = FluentAttributeCollector::new()
            ->only([TestAttributeClassConstant::class])
            ->target(\Attribute::TARGET_CLASS_CONSTANT)
            ->fromClass(TestSubject::class)
            ->getCollectedAttributes();

        $this->assertCount(1, $attributesCollected);
        $this->assertInstanceOf(TestAttributeClassConstant::class, $attributesCollected[0]);
    }

    public function testCanRetrieveAttributesFromParameters()
    {
        $attributesCollected = FluentAttributeCollector::new()
            ->only([TestAttributeParameter::class])
            ->target(\Attribute::TARGET_PARAMETER)
            ->fromClass(TestSubject::class)
            ->getCollectedAttributes();

        $this->assertCount(2, $attributesCollected);
        $this->assertInstanceOf(TestAttributeParameter::class, $attributesCollected[0]);
    }
}