<?php


namespace AppBundle\BlogUser\Paging\Filter\SearchIdSet\Filter;


use AppBundle\BlogUser\Paging\Filter\SearchIdSet\Filter\ChunkFilter\HighestChunkFilter;
use AppBundle\BlogUser\Paging\Filter\SearchIdSet\Filter\ChunkFilter\LowestChunkFilter;

class ChunkFilter
{
    /**
     * @var LowestChunkFilter
     */
    private $lowestChunkFilter;

    /**
     * @var HighestChunkFilter
     */
    private $highestChunkFilter;

    /**
     * ChunkFilter constructor.
     * @param LowestChunkFilter $lowestChunkFilter
     * @param HighestChunkFilter $highestChunkFilter
     */
    public function __construct(LowestChunkFilter $lowestChunkFilter, HighestChunkFilter $highestChunkFilter)
    {
        $this->lowestChunkFilter  = $lowestChunkFilter;
        $this->highestChunkFilter = $highestChunkFilter;
    }

    /**
     * @return LowestChunkFilter
     */
    public function getLowestChunkFilter()
    {
        return $this->lowestChunkFilter;
    }

    /**
     * @return HighestChunkFilter
     */
    public function getHighestChunkFilter()
    {
        return $this->highestChunkFilter;
    }
}