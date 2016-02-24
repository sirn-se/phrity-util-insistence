<?php

namespace Phrity\Util\Constraints;

use \JsonSchema\Constraints\UndefinedConstraint;
use \JsonSchema\Exception\InvalidArgumentException;

class TypeConstraint extends \JsonSchema\Constraints\TypeConstraint
{
    protected function validateType($value, $type)
    {
        if ('array' === $type) {
            return is_array($value) || $value instanceof \ArrayAccess;
        }

        return parent::validateType($value, $type);
    }
}
