<?php

namespace Mock;

use \Phrity\Util\InsistenceTrait;

class InsistenceTraitTest extends \PHPUnit_Framework_TestCase
{

    public function testInsist()
    {
        $mock = new InsistenceTraitImplementation();
        $mock->testInsist(1, 'integer', ['type' => 'integer']);
        $mock->testInsist('A string', 'string', ['type' => 'string']);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Expected string but got integer
     */
    public function testFailedType()
    {
        $mock = new InsistenceTraitImplementation();
        $mock->testInsist(1, 'string', ['type' => 'integer']);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Must have a minimum value of 10
     */
    public function testFailedSchema()
    {
        $mock = new InsistenceTraitImplementation();
        $mock->testInsist(1, 'integer', ['minimum' => 10]);
    }
}
