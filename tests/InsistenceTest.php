<?php

namespace Phrity\Util;

use \Phrity\Util\Insistence;

class InsistenceTest extends \PHPUnit_Framework_TestCase
{

    public function testBoolean()
    {
        $insistence = new Insistence(true);
        $insistence->isType('boolean')->isType('scalar')->isType(['boolean', 'string']);
        $insistence->bySchema(['type' => 'boolean']);
    }

    public function testInteger()
    {
        $insistence = new Insistence(1234);
        $insistence->isType('integer')->isType('scalar')->isType(['numeric', 'string']);
        $insistence->bySchema(['type' => 'integer', 'min' => 1000, 'max' => 1300]);
    }

    public function testFloat()
    {
        $insistence = new Insistence(12.34);
        $insistence->isType('float')->isType('scalar')->isType(['numeric', 'string']);
        $insistence->bySchema(['type' => 'number', 'min' => 10, 'max' => 13]);
    }

    public function testString()
    {
        $insistence = new Insistence('A string');
        $insistence->isType('string')->isType('scalar')->isType(['numeric', 'string']);
        $insistence->bySchema(['type' => 'string', 'minLength' => 8, 'pattern' => '[A-Za-z ]']);
    }

    public function testArray()
    {
        $insistence = new Insistence([1, 2, 3]);
        $insistence->isType('array')->isType(['array', 'string']);
        $insistence->bySchema(['type' => 'array']);
    }

    public function testObject()
    {
        $insistence = new Insistence(new \stdClass);
        $insistence->isType('object')->isType(['object', 'string']);
        $insistence->bySchema(['type' => 'object']);
    }

    public function testNull()
    {
        $insistence = new Insistence(null);
        $insistence->isType('null')->isType(['null', 'string']);
        $insistence->bySchema(['type' => 'null']);
    }


    public function testResource()
    {
        $insistence = new Insistence(tmpfile());
        $insistence->isType('resource')->isType(['resource', 'string']);
    }


    public function testCallable()
    {
        $callable = 'time';
        $insistence = new Insistence($callable);
        $insistence->isType('callable')->isType(['callable', 'string']);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Expected string but got boolean
     */
    public function testFailedType()
    {
        $insistence = new Insistence(true);
        $insistence->isType('string');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Expected ["string","object"] but got boolean
     */
    public function testFailedMultiType()
    {
        $insistence = new Insistence(true);
        $insistence->isType(['string', 'object']);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Boolean value found, but a null is required
     */
    public function testFailedSchema()
    {
        $insistence = new Insistence(true);
        $insistence->bySchema(['type' => 'null']);
    }
}
