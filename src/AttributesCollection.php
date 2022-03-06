<?php

namespace Thgs\AttributesLoader;

class AttributesCollection
{
    private array $attributes;

    public function __construct(...$attributes)
    {
        $this->attributes = $attributes;
    }

    public function add($attribute)
    {
        $this->attributes[] = $attribute;
    }

    public function addMultiple(...$attributes)
    {
        foreach ($attributes as $attribute) {
            $this->add($attribute);
        }
    }

    public function all()
    {
        return $this->attributes;
    }

    public function clear()
    {
        $this->attributes = [];
    }
}