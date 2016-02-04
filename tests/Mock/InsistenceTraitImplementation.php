<?php

namespace Mock;

use \Phrity\Util\InsistenceTrait;

class InsistenceTraitImplementation
{
    use InsistenceTrait;

    public function testInsist($data, $types, $schema)
    {
        $this->insist($data)->isType($types)->bySchema($schema);
    }
}
