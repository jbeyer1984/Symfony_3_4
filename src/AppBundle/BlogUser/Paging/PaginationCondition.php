<?php

namespace AppBundle\BlogUser\Paging;

use AppBundle\BlogUser\Paging\PaginationCondition\Chunk;
use AppBundle\BlogUser\Paging\PaginationCondition\ItemsCount;
use AppBundle\BlogUser\Paging\PaginationCondition\ItemsPerPageCount;
use AppBundle\BlogUser\Paging\PaginationCondition\ShownItemsCount;

class PaginationCondition
{
    /**
     * @var ShownItemsCount
     */
    private $shownItemsCount;
    
    /**
     * @var ItemsCount
     */
    private $itemsCount;

    /**
     * @var ItemsPerPageCount
     */
    private $itemsPerPageCount;

    const FIRST_CHUNK = 0;

    const MIDDLE_CHUNK = 1;

    const LAST_CHUNK = 2;

    /**
     * PaginationCondition constructor.
     * @param ShownItemsCount $shownItemsCount
     * @param ItemsCount $itemsCount
     * @param ItemsPerPageCount $itemsPerPageCount
     */
    public function __construct(
        ShownItemsCount $shownItemsCount, ItemsCount $itemsCount, ItemsPerPageCount $itemsPerPageCount
    ) {
        $this->shownItemsCount = $shownItemsCount;
        $this->itemsCount = $itemsCount;
        $this->itemsPerPageCount = $itemsPerPageCount;
    }

    /**
     * @param Chunk $chunk
     * @return bool
     */
    public function hasEnoughItemsAt(Chunk $chunk)
    {
        return ($chunk->asInt() * $this->itemsPerPageCount->asInt() + 1) <= $this->getItemsCount()->asInt();
    }

    /**
     * @param Chunk $chunk
     * @return int
     */
    public function determineRestAt(Chunk $chunk)
    {
        return $this->itemsCount->asInt() - ($chunk->asInt() * $this->itemsPerPageCount->asInt());
    }

    /**
     * @return ShownItemsCount
     */
    public function getShownItemsCount()
    {
        return $this->shownItemsCount;
    }

    /**
     * @return ItemsCount
     */
    public function getItemsCount()
    {
        return $this->itemsCount;
    }

    /**
     * @return ItemsPerPageCount
     */
    public function getItemsPerPageCount()
    {
        return $this->itemsPerPageCount;
    }

    public function hasReachedBorder()
    {
        return $this->itemsCount->asInt() <= $this->itemsPerPageCount->asInt() * 2;
    }
}