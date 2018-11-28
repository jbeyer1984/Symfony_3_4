<?php


namespace AppBundle\BlogUser\Paging\PaginationCondition;


use AppBundle\BlogUser\Paging\PaginationException;

class ItemsPerPageCount
{
    /**
     * @var int
     */
    private $itemsPerPageCount;

    /**
     * ItemsPerPage constructor.
     * @param int $itemsPerPage
     * @throws PaginationException
     */
    public function __construct($itemsPerPage)
    {
        $this->ensureItemsPerPageCountIsInt($itemsPerPage);
        $this->itemsPerPageCount = $itemsPerPage;
    }

    /**
     * @param $itemsPerPage
     * @throws PaginationException
     */
    private function ensureItemsPerPageCountIsInt($itemsPerPage)
    {
        if (!is_int($itemsPerPage)) {
            throw new PaginationException(sprintf('$itemsPerPageCount is not integer, given %s', gettype($itemsPerPage)));
        }
    }

    public function asInt()
    {
        return $this->itemsPerPageCount;
    }
}