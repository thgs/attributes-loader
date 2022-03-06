<?php

namespace Thgs\AttributesLoader;

final class AttributesLoader
{
    public function __construct()
    {
    }

    public function fromClass(string $className, Filter $filter, ?int $target = \Attribute::TARGET_ALL): array
    {
        $class = new \ReflectionClass($className);

        if (empty($filter->onlyAttributes)) {
            return $this->getAllClassAttributes($class, null, $filter->instanceOf, $target);
        }

        $attributes = [];
        foreach ($filter->onlyAttributes as $filterAttribute) {
            $attributes = array_merge(
                $attributes,
                $this->getAllClassAttributes($class, $filterAttribute, $filter->instanceOf, $target)
            );
        }

        return $attributes;
    }

    private function getAllClassAttributes(
        \ReflectionClass $class,
        ?string $attributeFilter,
        bool $instanceOf = false,
        ?int $target = \Attribute::TARGET_ALL
    ): array {
        $attributes = [];
        $flag = $instanceOf ? \ReflectionAttribute::IS_INSTANCEOF : 0;

        // class Attributes
        if ($target & \Attribute::TARGET_CLASS) {
            $classReflectionAttributes = $class->getAttributes($attributeFilter, $flag);
            $classAttributes = $this->transformToAttributes(...$classReflectionAttributes);
            $attributes = array_merge($attributes, $classAttributes);
        }

        // method attributes
        if ($target & \Attribute::TARGET_METHOD) {
            foreach ($class->getMethods() as $method) {
                $reflectedAttributes = $method->getAttributes($attributeFilter, $flag);
                $methodAttributes = $this->transformToAttributes(...$reflectedAttributes);
                $attributes = array_merge($attributes, $methodAttributes);
            }
        }

        // property attributes
        if ($target & \Attribute::TARGET_PROPERTY) {
            foreach ($class->getProperties() as $property) {
                $reflectedAttributes = $property->getAttributes($attributeFilter, $flag);
                $propertyAttributes = $this->transformToAttributes(...$reflectedAttributes);
                $attributes = array_merge($attributes, $propertyAttributes);
            }
        }

        // class constant attributes
        if ($target & \Attribute::TARGET_CLASS_CONSTANT) {
            foreach ($class->getReflectionConstants() as $constant) {
                $reflectedAttributes = $constant->getAttributes($attributeFilter, $flag);
                $propertyAttributes = $this->transformToAttributes(...$reflectedAttributes);
                $attributes = array_merge($attributes, $propertyAttributes);
            }
        }

        // parameter attributes
        if ($target & \Attribute::TARGET_PARAMETER) {
            foreach ($class->getMethods() as $method) {
                foreach ($method->getParameters() as $parameter) {
                    $reflectedAttributes = $parameter->getAttributes($attributeFilter, $flag);
                    $propertyAttributes = $this->transformToAttributes(...$reflectedAttributes);
                    $attributes = array_merge($attributes, $propertyAttributes);
                }
            }
        }

        return $attributes;
    }

    private function transformToAttributes(\ReflectionAttribute ...$reflectionAttributes)
    {
        $attributes = [];
        foreach ($reflectionAttributes as $reflectionAttribute) {
            $attributes[] = $reflectionAttribute->newInstance();
        }
        return $attributes;
    }
}