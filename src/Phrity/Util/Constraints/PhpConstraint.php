<?php

namespace Phrity\Util\Constraints;

use \JsonSchema\Constraints\UndefinedConstraint;
use \JsonSchema\Exception\InvalidArgumentException;

class PhpConstraint extends UndefinedConstraint
{
    /**
     * {@inheritDoc}
     */
    public function check($value, $schema = null, $path = null, $i = null)
    {
        parent::check($value, $schema, $path, $i);
        if (isset($schema->internalType)) {
            $this->checkInternalType($value, $schema);
        }
        if (isset($schema->instanceOf)) {
            $this->checkInstanceOf($value, $schema);
        }
    }

    private function checkInternalType($value, $schema = null)
    {
        $types = $schema->internalType;
        if ($this->hasInternalType($types, $value)) {
            return;
        }

        $got = gettype($value);
        $expected = is_array($types) ? implode(' or ', $types) : $types;
        $this->addError($path, "{$got} value found, but {$expected} is required", 'internalType');
    }

    public function validateTypes($value, $schema = null, $path = null, $i = null)
    {
        // check array
        if (is_array($value) || $value instanceof \ArrayAccess) {
            $this->checkArray($value, $schema, $path, $i);
        }

        parent::validateTypes($value, $schema = null, $path = null, $i = null);
    }

    private function hasInternalType($types, $value)
    {
        if (is_array($types)) {
            foreach ($types as $type) {
                if ($this->hasInternalType($type, $value)) {
                    return true;
                }
            }
            return false;
        }
        $subtypes = explode('-', $types);
        switch (array_shift($subtypes)) {
            case 'boolean':
                return is_bool($value);
            case 'integer':
                return is_int($value);
            case 'float':
                return is_float($value);
            case 'string':
                return is_string($value);
            case 'array':
                $result = is_array($value);
                if (in_array('access', $subtypes)) {
                    $result = $result || $value instanceof \ArrayAccess;
                    $value = (array) $value;
                }
                if (in_array('indexed', $subtypes)) {
                    $result = $result && $this->isIndexedArray($value);
                }
                if (in_array('associative', $subtypes)) {
                    $result = $result && $this->isAssociativeArray($value);
                }
                return $result;
            case 'object':
                return is_object($value);
            case 'resource':
                return is_resource($value);
            case 'null':
                return is_null($value);
            case 'numeric':
                return is_numeric($value);
            case 'callable':
                return is_callable($value);
            case 'scalar':
                return is_scalar($value);
            default:
                throw new InvalidArgumentException("$types is not a valid PHP internal type");
        }
    }

    private function checkInstanceOf($value, $schema = null)
    {
        if (!is_object($value)) {
            return;
        }

        $types = $schema->instanceOf;
        if ($this->hasInstanceOf($types, $value)) {
            return;
        }

        $got = get_class($value);
        $expected = is_array($types) ? implode(' or ', $types) : $types;
        $this->addError($path, "{$got} required to be an instance of {$expected}", 'instanceof');
    }

    private function hasInstanceOf($types, $value)
    {
        if (is_array($types)) {
            foreach ($types as $type) {
                if ($this->hasInstanceOf($type, $value)) {
                    return true;
                }
            }
            return false;
        }
        return $value instanceof $types;
    }

    private function isIndexedArray(array $value)
    {
        return array_values($value) === $value;
    }

    private function isAssociativeArray(array $value)
    {
        foreach (array_keys($value) as $key) {
            if (!is_string($key)) {
                return false;
            }
        }
        return true;
    }
}
