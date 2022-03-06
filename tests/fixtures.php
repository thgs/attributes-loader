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

#[Attribute()]
class TestAttribute2
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
    #[TestAttribute2(where: 'property')]
    private $property;

    public function __construct(
        #[TestAttribute2(where: 'property')]
        private $property2,
    ) {
    }

    #[TestAttribute(where: 'method')]
    public function method()
    {
    }

    #[TestAttribute2]
    public function method2()
    {
    }
}