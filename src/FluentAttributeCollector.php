<?php

namespace Thgs\AttributesLoader;

final class FluentAttributeCollector
{
    private Filter $filter;
    private int $target;

    private AttributesLoader $loader;
    private AttributesCollection $collection;

    private function __construct()
    {
        $this->loader = new AttributesLoader();
        $this->collection = new AttributesCollection();

        $this->filter = new Filter();
        $this->target = \Attribute::TARGET_ALL;
    }

    public static function new(): self
    {
        return new self();
    }

    public function only(?array $onlyAttributes, bool $instanceOf = false): self
    {
        $this->filter = new Filter($onlyAttributes, $instanceOf);
        return $this;
    }

    public function withChildren(): self
    {
        $this->filter->instanceOf = true;
        return $this;
    }

    public function target(int $target = \Attribute::TARGET_ALL): self
    {
        $this->target = $target;
        return $this;
    }

    public function fromClass(string $class): self
    {
        // @todo could store and run it on getCollectedAttributes here?

        $newAttributes = $this->loader->fromClass($class, $this->filter, $this->target);
        $this->collection->addMultiple(...$newAttributes);
        return $this;
    }

    public function clear(): self
    {
        $this->collection->clear();
        return $this;
    }

    public function getCollectedAttributes()
    {
        return $this->collection->all();
    }
}