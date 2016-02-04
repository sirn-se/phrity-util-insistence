<?php

namespace Phrity\Util;

trait InsistenceTrait
{
    protected function insist($data)
    {
        return new Insistence($data);
    }
}
