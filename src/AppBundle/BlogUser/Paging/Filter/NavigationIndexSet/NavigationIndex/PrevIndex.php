<?php


namespace AppBundle\BlogUser\Paging\Filter\NavigationIndexSet\NavigationIndex;


use AppBundle\BlogUser\Paging\PaginationException;

class PrevIndex
{
    /**
     * @var int
     */
    private $prev;

    /**
     * Prev constructor.
     * @param int $prev
     * @throws PaginationException
     */
    public function __construct($prev)
    {
        $this->ensurePrevIsInt($prev);
        $this->prev = $prev;
    }

    /**
     * @param $prev
     * @throws PaginationException
     */
    private function ensurePrevIsInt($prev)
    {
        if (!is_int($prev)) {
            throw new PaginationException(sprintf('$prev is not integer, given %s', gettype($prev)));
        }
    }

    public function isExisting()
    {
        return -1 < $this->prev;
    }

    /**
     * @return int
     */
    public function asInt()
    {
        return $this->prev;
    }
}