<?php

namespace Thgs\AttributesLoader;

class AttributesCollection
{
    private array $attributes;

    public function __construct(\Attribute ...$attributes)
    {
        $this->attributes = $attributes;
    }

    public function add(\Attribute $attribute)
    {
        $this->attributes[] = $attribute;
    }

    public function addMultiple(\Attribute ...$attributes)
    {
        foreach ($attributes as $attribute) {
            $this->add($attribute);
        }
    }

    public function all()
    {
        return $this->attributes;
    }
}