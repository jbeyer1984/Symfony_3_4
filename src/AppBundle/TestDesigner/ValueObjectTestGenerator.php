<?php


namespace AppBundle\TestDesigner;


class ValueObjectTestGenerator
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var string
     */
    private $attribute;

    /**
     * @var string
     */
    private $type;

    /**
     * ValueObjectTestGenerator constructor.
     * @param $class
     * @param $attribute
     * @param $type
     */
    public function __construct($class, $attribute, $type)
    {
        $this->class     = $class;
        $this->attribute = $attribute;
        $this->type      = $type;
    }

    public function generate()
    {
        $tabs = str_repeat(' ', 4*3);
        $failChecks = [
            "[1, 'int']",
            "[1.0, 'double']",
            "['', 'string']",
            "['hallo','string']",
            "[true, 'boolean']",
            "[[], 'array']",
            "[new \stdClass, 'object']",
        ];
        $thisP = '$this->';
        switch ($this->type) {
            case 'int':
                $inputValue = 1;
                unset($failChecks[0]);
                break;
            case 'double':
                $inputValue = 1.0;
                unset($failChecks[1]);
                break;
            case 'string':
                $inputValue = 'asdf';
                unset($failChecks[2]);
                unset($failChecks[3]);
                break;
            case 'boolean':
                $inputValue = true;
                unset($failChecks[4]);
                break;
            default:
                $inputValue = null;
        }
        $implodedFailChecks = implode(',' . PHP_EOL . $tabs, $failChecks);
        $d = '$';
        $class = $this->class;
        $cClass = lcfirst($class);
        $cClassVar = '$' . $cClass;
        $cClassP = $cClassVar . '->';
        $type = $this->type;
        $ucType = ucfirst($type);


        $code = <<< CODE
class {$class}Test extends \PHPUnit_Framework_TestCase
{
    public function testCanBeCreated()
    {
        {$cClassVar} = new {$class}({$inputValue});
        {$thisP}assertInstanceOf({$class}::class, $cClassVar);
    }
    
    public function testEnsureIs{$ucType}()
    {
        {$cClassVar} = new {$class}({$inputValue});
        {$thisP}assertTrue(is_{$type}({$cClassP}as{$ucType}()));
    }

    /**
     * @param {$d}value
     * @param string {$d}type
     * @throws Data{$ucType}Exception
     * @dataProvider ensureIs{$ucType}FailProvider
     */
    public function testEnsureIs{$ucType}Fail(${d}value, {$d}type)
    {
        {$thisP}setExpectedException(
            Data{$ucType}Exception::class,
            '{$d}count is not from type {$type}, given, ' . {$d}type
        );
        new {$class}({$d}value);
    }

    /**
     * @return array
     */
    public function ensureIs{$ucType}FailProvider()
    {
        return [
            {$implodedFailChecks}
        ];    
    }

    public function testAs{$ucType}()
    {
        {$d}count = {$inputValue};
        $cClassVar = new {$class}({$d}count);
        {$thisP}assertEquals({$d}count, {$cClassP}as{$ucType}());
    }
}

CODE;
        
        echo $code;

    }
}