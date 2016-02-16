<?php

namespace Phrity\Util;

use \Phrity\Util\Insistence;

class InsistenceTest extends \PHPUnit_Framework_TestCase
{

    public function testBoolean()
    {
        $in = new Insistence();
        $in->setSchema(['internalType' => 'boolean'])->insist(true);
        $in->setSchema(['internalType' => 'scalar'])->insist(true);
        $in->setSchema(['internalType' => ['string', 'boolean']])->insist(true);
    }

    public function testInteger()
    {
        $in = new Insistence();
        $in->setSchema(['internalType' => 'integer'])->insist(1234);
        $in->setSchema(['internalType' => 'scalar'])->insist(1234);
        $in->setSchema(['internalType' => 'numeric'])->insist(1234);
        $in->setSchema(['internalType' => ['string', 'integer']])->insist(1234);
    }

    public function testFloat()
    {
        $in = new Insistence();
        $in->setSchema(['internalType' => 'float'])->insist(12.34);
        $in->setSchema(['internalType' => 'scalar'])->insist(12.34);
        $in->setSchema(['internalType' => 'numeric'])->insist(12.34);
        $in->setSchema(['internalType' => ['string', 'float']])->insist(12.34);
    }

    public function testString()
    {
        $in = new Insistence();
        $in->setSchema(['internalType' => 'string'])->insist('A string');
        $in->setSchema(['internalType' => 'scalar'])->insist('A string');
        $in->setSchema(['internalType' => ['string', 'float']])->insist('A string');
    }

    public function testArray()
    {
        $in = new Insistence();
        $in->setSchema(['internalType' => 'array'])->insist([1, 2, 3]);
        $in->setSchema(['internalType' => 'array'])->insist(["a" => "b", "x" => "y"]);
        $in->setSchema(['internalType' => ['string', 'array']])->insist([1, 2, 3]);
    }

    public function testObject()
    {
        $class = new \stdClass;
        $in = new Insistence();
        $in->setSchema(['internalType' => 'object'])->insist($class);
        $in->setSchema(['internalType' => ['string', 'object']])->insist($class);
        $in->setSchema(['instanceOf' => 'stdClass'])->insist($class);
        $in->setSchema(['instanceOf' => ['InvalidClass', 'stdClass']])->insist($class);
    }

    public function testNull()
    {
        $in = new Insistence();
        $in->setSchema(['internalType' => 'null'])->insist(null);
        $in->setSchema(['internalType' => ['string', 'null']])->insist(null);
    }


    public function testResource()
    {
        $res = tmpfile();
        $in = new Insistence();
        $in->setSchema(['internalType' => 'resource'])->insist($res);
        $in->setSchema(['internalType' => ['resource', 'string']])->insist($res);
    }


    public function testCallable()
    {
        $callable = 'time';
        $in = new Insistence();
        $in->setSchema(['internalType' => 'callable'])->insist($callable);
        $in->setSchema(['internalType' => ['callable', 'string']])->insist($callable);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage NULL value found, but string is required
     */
    public function testFailedInternalType()
    {
        $in = new Insistence();
        $in->setSchema(['internalType' => 'string'])->insist(null);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage boolean value found, but string or object is required
     */
    public function testFailedMultiInternalType()
    {
        $in = new Insistence();
        $in->setSchema(['internalType' => ['string', 'object']])->insist(true);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage failure is not a valid PHP internal type
     */
    public function testInvalidInternalType()
    {
        $in = new Insistence();
        $in->setSchema(['internalType' => 'failure'])->insist(true);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage stdClass required to be an instance of InvalidClass
     */
    public function testFailedInstanceOf()
    {
        $in = new Insistence();
        $in->setSchema(['instanceOf' => 'InvalidClass'])->insist(new \stdClass);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage instanceOf constraint used on a non-object
     */
    public function testInvalidInstanceOf()
    {
        $in = new Insistence();
        $in->setSchema(['instanceOf' => 'stdClass'])->insist(true);
    }
}
