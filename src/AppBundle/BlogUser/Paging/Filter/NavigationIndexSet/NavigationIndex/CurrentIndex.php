<?php


namespace AppBundle\BlogUser\Paging\Filter\NavigationIndexSet\NavigationIndex;


use AppBundle\BlogUser\Paging\PaginationException;

class CurrentIndex
{
    /**
     * @var int
     */
    private $current;

    /**
     * Current constructor.
     * @param int $current
     * @throws PaginationException
     */
    public function __construct($current)
    {
        $this->ensureCurrentIsInt($current);
        $this->current = $current;
    }

    /**
     * @param $current
     * @throws PaginationException
     */
    private function ensureCurrentIsInt($current)
    {
        if (!is_int($current)) {
            throw new PaginationException(sprintf('$current is not integer, given %s', gettype($current)));
        }
    }

    public function isExisting()
    {
        return -1 < $this->current;
    }

    /**
     * @return int
     */
    public function asInt()
    {
        return $this->current;
    }

}