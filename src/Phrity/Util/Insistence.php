<?php

namespace Phrity\Util;

class Insistence
{
    private $data;
    private $validator;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function bySchema($schema)
    {
        // Allow schema defintion as associative array
        $schema = json_decode(json_encode($schema));

        if (!isset($this->validator)) {
            $this->validator = new \JsonSchema\Validator();
        }

        $this->validator->check($this->data, $schema);
        if (!$this->validator->isValid()) {
            // Use first error as exception message
            $errors = $this->validator->getErrors();
            throw new \InvalidArgumentException($errors[0]['message']);
        }
        return $this;
    }

    public function isType($types)
    {
        if (!$this->hasType($types)) {
            $got = gettype($this->data);
            $expected = is_array($types) ? json_encode($types) : $types;
            throw new \InvalidArgumentException("Expected {$expected} but got {$got}");
        }
        return $this;
    }

    private function hasType($types)
    {
        if (is_array($types)) {
            foreach ($types as $type) {
                if ($this->hasType($type)) {
                    return true;
                }
            }
            return false;
        }
        switch (strtolower($types)) {
            case 'boolean':
                return is_bool($this->data);
            case 'integer':
                return is_int($this->data);
            case 'float':
                return is_float($this->data);
            case 'string':
                return is_string($this->data);
            case 'array':
                return is_array($this->data);
            case 'object':
                return is_object($this->data);
            case 'resource':
                return is_resource($this->data);
            case 'null':
                return is_null($this->data);
            case 'numeric':
                return is_numeric($this->data);
            case 'callable':
                return is_callable($this->data);
            case 'scalar':
                return is_scalar($this->data);
            default:
                return false;
        }
    }
}
