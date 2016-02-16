# Insistence

Insisting on correct data makes every chunk of code a little happier.

By relying on [json-schema](http://json-schema.org), Insistence is a powerful utility to apply
complex yet flexible constraints on handled data. Insistence uses the popular
[justinrainbow/json-schema](https://github.com/justinrainbow/json-schema) as foundation.

In addition to the generic constraints specified by JSON-schema, there is two PHP specific
constrains that can be used.

## internalType

The following internalTypes is available, their usage should be
[obvious](http://php.net/manual/en/language.types.intro.php) for a PHP programmer.

* boolean
* integer
* float
* string
* array
* object
* resource
* null
* numeric
* callable
* scalar

The internalType constraint accepts either a string, or an array of strings where at least one
must match to succeed the constraint.

## instanceOf

The instanceOf constraint accepts either a string, or an array of strings where at least one
must match to succeed the constraint.

It may only be used on data of PHP type "object".

## Usage

```php
$insistence = new Insistence(['internalType' => 'float', 'min' => 1.0, 'max' => 9.9]);
$insistence->insist(4.45); // Will pass
$insistence->insist(123); // Will fail, higher then max 9.9
$insistence->insist("Hello"); // Will fail, not a float
```

## InsistenceTrait

The trait serves as a convenience wrapper to use Insistence in any class.

```php
class MyClass
{
    use \Phrity\Util\InsistenceTrait;

    public function myMethod($some_data)
    {
        // Will fail if not a string with at least 8 characters
        $this->insist(['type' => 'string', 'minlength' => 8], $some_data);

        $some_result = some_method(20);
        // Will fail if result is not an object or null
        $this->insist(['internalType' => ['object', 'null']], $some_result);
    }
}
```