<?php
/**
 * Created by PhpStorm.
 * User: Jens
 * Date: 27.12.2018
 * Time: 14:21
 */

namespace Tests\AppBundle\TestDesigner;

use AppBundle\TestDesigner\DataInt;
use AppBundle\TestDesigner\DataIntException;

class DataIntTest extends \PHPUnit_Framework_TestCase
{
    public function testCanBeCreated()
    {
        $dataInt = new DataInt(1);
        $this->assertInstanceOf(DataInt::class, $dataInt);
    }
    
    public function testEnsureIsInt()
    {
        $dataInt = new DataInt(1);
        $this->assertTrue(is_int($dataInt->asInt()));
    }

    /**
     * @param $value
     * @param string $type
     * @throws DataIntException
     * @dataProvider ensureIsIntFailProvider
     */
    public function testEnsureIsIntFail($value, $type)
    {
        $this->setExpectedException(
            DataIntException::class,
            '$count is not from type int, given, ' . $type
        );
        new DataInt($value);
    }

    /**
     * @return array
     */
    public function ensureIsIntFailProvider()
    {
        return [
            [1.0, 'double'],
            ['', 'string'],
            ['hallo','string'],
            [true, 'boolean'],
            [[], 'array'],
            [new \stdClass, 'object'],
        ];    
    }

    public function testAsInt()
    {
        $count = 1;
        $dataInt = new DataInt($count);
        $this->assertEquals($count, $dataInt->asInt());
    }
}
