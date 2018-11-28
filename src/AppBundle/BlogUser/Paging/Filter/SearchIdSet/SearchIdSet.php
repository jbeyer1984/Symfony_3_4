<?php

namespace AppBundle\BlogUser\Paging\Filter\SearchIdSet;

use AppBundle\BlogUser\Paging\Filter\SearchIdSet\SearchId\NextSearchId;
use AppBundle\BlogUser\Paging\Filter\SearchIdSet\SearchId\PrevSearchId;
use AppBundle\BlogUser\Paging\Filter\SearchIdSet\SearchId\CurrentSearchId;

class SearchIdSet
{
    /**
     * @var PrevSearchId
     */
    private $prevId;

    /**
     * @var CurrentSearchId
     */
    private $currentId;

    /**
     * @var NextSearchId
     */
    private $nextId;

    /**
     * SearchIdSet constructor.
     * @param PrevSearchId $prevId
     * @param CurrentSearchId $currentId
     * @param NextSearchId $nextId
     */
    public function __construct(PrevSearchId $prevId, CurrentSearchId $currentId, NextSearchId $nextId)
    {
        $this->prevId    = $prevId;
        $this->currentId = $currentId;
        $this->nextId    = $nextId;
    }

    /**
     * @return PrevSearchId
     */
    public function getPrevSearchId()
    {
        return $this->prevId;
    }

    /**
     * @return CurrentSearchId
     */
    public function getCurrentSearchId()
    {
        return $this->currentId;
    }

    /**
     * @return NextSearchId
     */
    public function getNextSearchId()
    {
        return $this->nextId;
    }

}