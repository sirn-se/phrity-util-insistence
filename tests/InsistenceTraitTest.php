<?php

namespace Mock;

use \Phrity\Util\InsistenceTrait;

class InsistenceTraitTest extends \PHPUnit_Framework_TestCase
{

    public function testInsist()
    {
        $mock = new InsistenceTraitImplementation();
        $mock->testInsist(['internalType' => 'integer'], 12);
        $mock->testInsist(['internalType' => 'string'], 'A string');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage string value found, but integer is required
     */
    public function testFailedInternalType()
    {
        $mock = new InsistenceTraitImplementation();
        $mock->testInsist(['internalType' => 'integer'], 'A string');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage stdClass required to be an instance of InvalidClass
     */
    public function testFailedInstanceOf()
    {
        $mock = new InsistenceTraitImplementation();
        $mock->testInsist(['instanceOf' => 'InvalidClass'], new \stdClass);
    }
}
