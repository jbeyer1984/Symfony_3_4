<?php

namespace AppBundle\BlogUser\Paging\Pipe\NavigationViewInfo\NavigationLink;

use AppBundle\BlogUser\Paging\Filter\NavigationIndexSet\NavigationIndex\NextIndex;
use AppBundle\BlogUser\Paging\Filter\SearchIdSet\SearchId\NextSearchId;

class NextLink
{
    /**
     * @var NextIndex
     */
    private $next;

    /**
     * @var SearchId
     */
    private $searchId;

    /**
     * NextLink constructor.
     * @param NextIndex $nextIndex
     * @param NextSearchId $nextSearchId
     */
    public function __construct(NextIndex $nextIndex, NextSearchId $nextSearchId)
    {
        $this->next     = $nextIndex;
        $this->searchId = $nextSearchId;
    }

    public function isExisting()
    {
        return $this->next->isExisting();
    }

    /**
     * @return NextIndex
     */
    public function getNextIndex()
    {
        return $this->next;
    }

    /**
     * @return SearchId
     */
    public function getSearchId()
    {
        return $this->searchId;
    }
}