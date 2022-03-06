<?php

namespace Thgs\AttributesLoader;

class Filter
{
    public function __construct(public ?array $onlyAttributes = null, public bool $instanceOf = false)
    {
    }
}