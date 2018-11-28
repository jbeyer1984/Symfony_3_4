<?php

namespace AppBundle\BlogUser\Paging\Filter\SearchIdSet;

use AppBundle\BlogUser\Paging\Filter\SearchIdSet\Filter\ChunkFilter;
use AppBundle\BlogUser\Paging\Filter\SearchIdSet\SearchId\NextSearchId;
use AppBundle\BlogUser\Paging\Filter\SearchIdSet\SearchId\PrevSearchId;
use AppBundle\BlogUser\Paging\Filter\SearchIdSet\SearchId\CurrentSearchId;
use AppBundle\BlogUser\Paging\PaginationCondition;
use AppBundle\BlogUser\Paging\PaginationCondition\Chunk;

class SearchIdSetFilter
{
    /**
     * @var PaginationCondition
     */
    private $paginationCondition;
    
    const MIDDLE_CHUNK = 1;

    const LAST_CHUNK = 2;

    const FIRST_CHUNK = 0;

    /**
     * SearchIdSetFilter constructor.
     * @param PaginationCondition $paginationCondition
     */
    public function __construct(PaginationCondition $paginationCondition)
    {
        $this->paginationCondition = $paginationCondition;
    }


    /**
     * @param ChunkFilter $chunkFilter
     * @return SearchIdSet
     * @throws SearchIdSetException
     * @throws \AppBundle\BlogUser\Paging\PaginationException
     */
    public function retrieveFirstSet(ChunkFilter $chunkFilter)
    {
        $prevId = new PrevSearchId(-1);
        $currentId = new CurrentSearchId($chunkFilter->getLowestChunkFilter()->retrieveSearchIdValueBy(self::FIRST_CHUNK));
        if (!$this->paginationCondition->hasEnoughItemsAt(new Chunk(PaginationCondition::MIDDLE_CHUNK))) {
            $nextId = new NextSearchId(-1);
        } else {
            $nextId = new NextSearchId($chunkFilter->getLowestChunkFilter()->retrieveSearchIdValueBy(self::FIRST_CHUNK));
        }
        
        return new SearchIdSet($prevId, $currentId, $nextId);
    }

    /**
     * @param ChunkFilter $chunkFilter
     * @return SearchIdSet
     * @throws SearchIdSetException
     */
    public function retrieveNextSet(ChunkFilter $chunkFilter)
    {
        if ($this->paginationCondition->getShownItemsCount()->asInt() < $this->paginationCondition->getItemsPerPageCount()->asInt()) {
            $prevId = new PrevSearchId($chunkFilter->getHighestChunkFilter()->retrieveSearchIdValueBy(self::MIDDLE_CHUNK));
            $currentId = new CurrentSearchId(-1);
            $nextId = new NextSearchId(-1);
        } else {
            $prevId = new PrevSearchId($chunkFilter->getHighestChunkFilter()->retrieveSearchIdValueBy(self::MIDDLE_CHUNK));
            $currentId = new CurrentSearchId(-1);
            $nextId = new NextSearchId($chunkFilter->getLowestChunkFilter()->retrieveSearchIdValueBy(self::MIDDLE_CHUNK));
        }
        
        return new SearchIdSet($prevId, $currentId, $nextId);
    }

    /**
     * @param ChunkFilter $chunkFilter
     * @return SearchIdSet
     * @throws SearchIdSetException
     */
    public function retrievePrevSet(ChunkFilter $chunkFilter)
    {
        if ($this->paginationCondition->getShownItemsCount()->asInt() < $this->paginationCondition->getItemsPerPageCount()->asInt() * 3) {
            $prevId = new PrevSearchId($chunkFilter->getHighestChunkFilter()->retrieveSearchIdValueBy(self::MIDDLE_CHUNK));
            $currentId = new CurrentSearchId(-1);
            $nextId = new NextSearchId($chunkFilter->getLowestChunkFilter()->retrieveSearchIdValueBy(self::FIRST_CHUNK));
        } else {
            $prevId = new PrevSearchId($chunkFilter->getHighestChunkFilter()->retrieveSearchIdValueBy(self::MIDDLE_CHUNK));
            $currentId = new CurrentSearchId(-1);
            $nextId = new NextSearchId($chunkFilter->getLowestChunkFilter()->retrieveSearchIdValueBy(self::MIDDLE_CHUNK));
        }

        return new SearchIdSet($prevId, $currentId, $nextId);
    }
}