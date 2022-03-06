### attributes-loader

This small library is meant to provide a way to load PHP 8.x attributes from classes.
It is still in early development.

#### Usage

Example usage

```php
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

$loader = new AttributesLoader();
$loader->fromClass(TestSubject::class);

/** @var TestAttribute[] $attributes */
$attributes = $loader->getAttributesCollected();
```

Or use the FluentAttributeCollector

```php
<?php

$attributesCollected = FluentAttributeCollector::new()
    ->only([TestAttribute2::class])
    ->target(\Attribute::TARGET_PROPERTY)
    ->fromClass(TestSubject::class)
    ->getCollectedAttributes();

```

More examples of usage can be found currently by looking at the [tests](https://github.com/thgs/attributes-loader/tree/main/tests).