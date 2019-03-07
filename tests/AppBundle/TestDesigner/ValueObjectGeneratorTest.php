<?php
/**
 * Created by PhpStorm.
 * User: Jens
 * Date: 27.12.2018
 * Time: 13:42
 */

namespace Tests\AppBundle\TestDesigner;


use AppBundle\TestDesigner\ValueObjectGenerator;

class ValueObjectGeneratorTest extends \PHPUnit_Framework_TestCase
{

    public function testGenerate()
    {
        $testGenerator = new ValueObjectGenerator('DataInt', 'count', 'int');
        $testGenerator->generate();
    }
}
