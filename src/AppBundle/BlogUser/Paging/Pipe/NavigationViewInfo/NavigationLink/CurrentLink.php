<?php

namespace AppBundle\BlogUser\Paging\Pipe\NavigationViewInfo\NavigationLink;

use AppBundle\BlogUser\Paging\Filter\NavigationIndexSet\NavigationIndex\CurrentIndex;
use AppBundle\BlogUser\Paging\Filter\SearchIdSet\SearchId\CurrentSearchId;

class CurrentLink
{
    /**
     * @var CurrentIndex
     */
    private $current;

    /**
     * @var SearchId
     */
    private $searchId;

    /**
     * CurrentLink constructor.
     * @param CurrentIndex $currentIndex
     * @param CurrentSearchId $currentSearchId
     */
    public function __construct(CurrentIndex $currentIndex, CurrentSearchId $currentSearchId)
    {
        $this->current  = $currentIndex;
        $this->searchId = $currentSearchId;
    }

    public function isExisting()
    {
        return $this->current->isExisting();
    }

    /**
     * @return CurrentIndex
     */
    public function getCurrentIndex()
    {
        return $this->current;
    }

    /**
     * @return SearchId
     */
    public function getSearchId()
    {
        return $this->searchId;
    }
}