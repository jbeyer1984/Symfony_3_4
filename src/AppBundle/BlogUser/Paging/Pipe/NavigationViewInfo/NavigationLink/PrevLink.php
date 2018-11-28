<?php

namespace AppBundle\BlogUser\Paging\Pipe\NavigationViewInfo\NavigationLink;

use AppBundle\BlogUser\Paging\Filter\SearchIdSet\SearchId\PrevSearchId;
use AppBundle\BlogUser\Paging\Filter\NavigationIndexSet\NavigationIndex\PrevIndex;

class PrevLink
{
    /**
     * @var PrevIndex
     */
    private $prev;

    /**
     * @var SearchId
     */
    private $searchId;

    /**
     * PrevLink constructor.
     * @param PrevIndex $prevIndex
     * @param PrevSearchId $prevSearchId
     */
    public function __construct(PrevIndex $prevIndex, PrevSearchId $prevSearchId)
    {
        $this->prev     = $prevIndex;
        $this->searchId = $prevSearchId;
    }


    public function isExisting()
    {
        return $this->prev->isExisting();
    }

    /**
     * @return PrevIndex
     */
    public function getPrevIndex()
    {
        return $this->prev;
    }

    /**
     * @return SearchId
     */
    public function getSearchId()
    {
        return $this->searchId;
    }
}