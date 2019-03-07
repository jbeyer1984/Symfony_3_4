<?php
/**
 * Created by PhpStorm.
 * User: Jens
 * Date: 05.01.2019
 * Time: 11:22
 */

namespace AppBundle\TestDesigner;


class ValueObjectTestGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testCanBeCreated()
    {
        $valueObjectTestGenerator = new ValueObjectTestGenerator('LastPage', 'lastPage', 'int');
        $valueObjectTestGenerator->generate();
    }
}
