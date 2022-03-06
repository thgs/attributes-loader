<?php

namespace Thgs\AttributesLoader;

use ReflectionAttribute;

class AttributesLoader
{
    private AttributesCollection $attributes;

    public function __construct(\Attribute ...$attributes)
    {
        $this->attributes = new AttributesCollection(...$attributes);
    }

    public function fromClass(string $className): void
    {
        $class = new \ReflectionClass($className);

        // @todo do it according to filters specified

        // class Attributes
        $classReflectionAttributes = $class->getAttributes();
        $classAttributes = $this->transformToAttributes(...$classReflectionAttributes);
        $this->attributes->addMultiple(...$classAttributes);

        // method attributes
        foreach ($class->getMethods() as $method) {
            $reflectedAttributes = $method->getAttributes();
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