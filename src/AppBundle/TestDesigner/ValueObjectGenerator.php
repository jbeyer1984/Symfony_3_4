<?php


namespace AppBundle\TestDesigner;


class ValueObjectGenerator
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
     * TestGenerator constructor.
     * @param String $class
     * @param string $attribute
     * @param string $type
     */
    public function __construct($class, $attribute, $type)
    {
        $this->class     = $class;
        $this->attribute = $attribute;
        $this->type      = $type;
    }

    public function generate()
    {
        $cAttribute = lcfirst($this->attribute);
        $cAttributeVar = '$' . $cAttribute;
        $thisP = '$this->';
//        $attributeVar = '$' . $this->attribute;
        $ucType = ucfirst($this->type);
        $classTemp = <<<TMP
class {$this->class} {

    /**
     * @var {$this->type}
     */
    private {$cAttributeVar};
    
    /**
     * @param {$this->type} {$cAttributeVar}
     * @throws Data{$ucType}Exception
     */
    public function __construct($cAttributeVar)
    {
        {$thisP}ensureIs{$ucType}({$cAttributeVar});
        {$thisP}{$cAttribute} = {$cAttributeVar};
    }
    
    /**
     * @param {$this->type} {$cAttributeVar}
     * @throws {$this->class}Exception
     */
    public function ensureIs{$ucType}({$cAttributeVar})
    {
        if (! is_{$this->type}({$cAttributeVar})) {
            throw new {$this->class}Exception(sprintf('{$cAttributeVar} is not from type {$this->type}, given, %s', gettype({$cAttributeVar})));
        }
    }
    
    /**
     * @return {$this->type}
     */
    public function as{$ucType}()
    {
        return {$thisP}{$cAttribute};
    }
}
TMP;
        
        echo $classTemp;

    }


}