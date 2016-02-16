<?php

namespace Mock;

use \Phrity\Util\InsistenceTrait;

class InsistenceTraitImplementation
{
    use InsistenceTrait;

    public function testInsist($schema, $data)
    {
        $this->insist($schema, $data);
    }
}
