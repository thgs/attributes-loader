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

#[Attribute]
class TestAttributeClassConstant
{
}

#[Attribute]
class TestAttributeParameter
{
}

#[TestAttribute(where: 'class')]
class TestSubject
{
    #[TestAttributeClassConstant]
    private const SOMETHING = 'something';

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

    #[TestAttribute2(where: 'method')]
    public function method2()
    {
    }

    public function forParameters(
        #[TestAttributeParameter]
        $param1,
        #[TestAttributeParameter]
        $param2
    ) {

    }
}