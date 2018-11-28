<?php


namespace AppBundle\BlogUser\Paging\Filter\SearchIdSet\Filter;


use AppBundle\BlogUser\Paging\Filter\SearchIdSet\Filter\ChunkFilter\HighestChunkFilter;
use AppBundle\BlogUser\Paging\Filter\SearchIdSet\Filter\ChunkFilter\LowestChunkFilter;
use AppBundle\BlogUser\Paging\PaginationCondition;

class ChunkFilterFactory
{
    public function createChunkFilter(array $userMessages, PaginationCondition $paginationCondition)
    {
        return new ChunkFilter(
            $this->createLowestChunkFilter($userMessages, $paginationCondition),
            $this->createHighestChunkFilter($userMessages, $paginationCondition)
        );
    }
    
    /**
     * @param array $userMessages
     * @param PaginationCondition $paginationCondition
     * @return LowestChunkFilter
     */
    private function createLowestChunkFilter(array $userMessages, PaginationCondition $paginationCondition)
    {
        return new LowestChunkFilter($userMessages, $paginationCondition);
    }

    /**
     * @param array $userMessages
     * @param PaginationCondition $paginationCondition
     * @return HighestChunkFilter
     */
    private function createHighestChunkFilter(array $userMessages, PaginationCondition $paginationCondition)
    {
        return new HighestChunkFilter($userMessages, $paginationCondition);
    }
}