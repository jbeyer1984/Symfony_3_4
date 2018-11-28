<?php


namespace AppBundle\BlogUser\Paging\Filter\NavigationIndexSet\NavigationIndex;


use AppBundle\BlogUser\Paging\PaginationException;

class NextIndex
{
    /**
     * @var int
     */
    private $next;

    /**
     * Next constructor.
     * @param int $next
     * @throws PaginationException
     */
    public function __construct($next)
    {
        $this->ensureNextIsInt($next);
        $this->next = $next;
    }

    /**
     * @param $next
     * @throws PaginationException
     */
    private function ensureNextIsInt($next)
    {
        if (!is_int($next)) {
            throw new PaginationException(sprintf('$next is not integer, given %s', gettype($next)));
        }
    }

    public function isExisting()
    {
        return -1 < $this->next;
    }

    /**
     * @return int
     */
    public function asInt()
    {
        return $this->next;
    }
}