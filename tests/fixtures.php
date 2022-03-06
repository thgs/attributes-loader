<?php

namespace Thgs\AttributesLoader;

use Attribute;

#[Attribute()]
class TestAttribute
{
    public function __construct(private $where = null)
    {
    }

    public function getWhere()
    {
        return $this->where;
    }
}

#[TestAttribute(where: 'class')]
class TestSubject
{
    #[TestAttribute(where: 'method')]
    public function method()
    {
    }
}