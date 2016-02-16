<?php

namespace Phrity\Util;

trait InsistenceTrait
{

    private $insistance;

    protected function insist($schema, $data)
    {
        if (!isset($this->insistance)) {
            $this->insistance = new Insistence();
        }
        $this->insistance->setSchema($schema)->insist($data);
    }
}
