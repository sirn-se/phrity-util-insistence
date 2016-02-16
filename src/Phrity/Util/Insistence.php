<?php

namespace Phrity\Util;

class Insistence
{
    private $schema;
    private $validator;

    public function __construct($schema = null)
    {
        $this->setSchema($schema);
        $this->validator = new \JsonSchema\Validator();
        $factory = $this->validator->getFactory();
        $factory->setConstraintClass('undefined', 'Phrity\Util\Constraints\PhpConstraint');
    }

    public function setSchema($schema)
    {
        // Allow schema defintion as associative array
        $this->schema = json_decode(json_encode($schema));
        return $this;
    }

    public function insist($data)
    {
        $this->validator->check($data, $this->schema);
        if (!$this->validator->isValid()) {
            // Use first error as exception message
            $errors = $this->validator->getErrors();
            throw new \InvalidArgumentException($errors[0]['message']);
        }
        return $this;
    }
}
