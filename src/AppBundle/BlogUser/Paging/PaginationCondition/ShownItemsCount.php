<?php


namespace AppBundle\BlogUser\Paging\PaginationCondition;


use AppBundle\BlogUser\Paging\PaginationException;

class ShownItemsCount
{
    /**
     * @var int
     */
    private $shownItemsCount;

    /**
     * ItemsCount constructor.
     * @param int $itemsCount
     * @throws PaginationException
     */
    public function __construct($itemsCount)
    {
        $this->ensureShownItemsCountIsInt($itemsCount);
        $this->shownItemsCount = $itemsCount;
    }

    /**
     * @param $shownItemsCount
     * @throws PaginationException
     */
    private function ensureShownItemsCountIsInt($shownItemsCount)
    {
        if (!is_int($shownItemsCount)) {
            throw new PaginationException(sprintf('$shownItemsCount is not integer, given %s', gettype($shownItemsCount)));
        }
    }

    public function asInt()
    {
        return $this->shownItemsCount;
    }
}