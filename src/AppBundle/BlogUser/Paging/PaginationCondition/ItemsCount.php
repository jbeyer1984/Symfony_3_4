<?php


namespace AppBundle\BlogUser\Paging\PaginationCondition;


use AppBundle\BlogUser\Paging\PaginationException;

class ItemsCount
{
    /**
     * @var int
     */
    private $itemsCount;

    /**
     * ItemsCount constructor.
     * @param int $itemsCount
     * @throws PaginationException
     */
    public function __construct($itemsCount)
    {
        $this->ensureItemsCountIsInt($itemsCount);
        $this->itemsCount = $itemsCount;
    }

    /**
     * @param $itemsCount
     * @throws PaginationException
     */
    private function ensureItemsCountIsInt($itemsCount)
    {
        if (!is_int($itemsCount)) {
            throw new PaginationException(sprintf('$itemsCount is not integer, given %s', gettype($itemsCount)));
        }
    }

    public function asInt()
    {
        return $this->itemsCount;
    }
}