<?php

namespace Thgs\AttributesLoader;

use ReflectionAttribute;
use ReflectionClass;

class AttributesLoader
{
    private AttributesCollection $attributes;
    private array $filterAttributes;
    private $instanceOf = true;

    public function __construct(\Attribute ...$attributes)
    {
        $this->attributes = new AttributesCollection(...$attributes);
    }

    public function only(...$attributes)
    {
        $this->filterAttributes = $attributes;
    }

    public function withoutChildren()
    {
        $this->instanceOf = false;
    }

    public function fromClass(string $className): void
    {
        $class = new \ReflectionClass($className);

        // @todo do it according to filters specified

        if (empty($this->filterAttributes)) {
            $this->getAllClassAttributes($class, null);
            return;
        }

        foreach ($this->filterAttributes as $filterAttribute) {
            $this->getAllClassAttributes($class, $filterAttribute, $this->instanceOf);
        }
    }

    private function getAllClassAttributes(\ReflectionClass $class, ?string $attributeFilter, bool $instanceOf = false): void
    {
        $flag = $instanceOf ? ReflectionAttribute::IS_INSTANCEOF : 0;

        // class Attributes
        $classReflectionAttributes = $class->getAttributes($attributeFilter, $flag);
        $classAttributes = $this->transformToAttributes(...$classReflectionAttributes);
        $this->attributes->addMultiple(...$classAttributes);

        // method attributes
        foreach ($class->getMethods() as $method) {
            $reflectedAttributes = $method->getAttributes($attributeFilter, $flag);
            $methodAttributes = $this->transformToAttributes(...$reflectedAttributes);
            $this->attributes->addMultiple(...$methodAttributes);
        }
    }

    private function transformToAttributes(ReflectionAttribute ...$reflectionAttributes)
    {
        $attributes = [];
        foreach ($reflectionAttributes as $reflectionAttribute) {
            $attributes[] = $reflectionAttribute->newInstance();
        }
        return $attributes;
    }

    public function getAttributesCollected()
    {
        return $this->attributes->all();
    }
}