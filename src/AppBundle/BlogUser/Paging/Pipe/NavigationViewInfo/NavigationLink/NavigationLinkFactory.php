<?php


namespace AppBundle\BlogUser\Paging\Pipe\NavigationViewInfo\NavigationLink;


use AppBundle\BlogUser\Paging\Filter\NavigationIndexSet\NavigationIndex\CurrentIndex;
use AppBundle\BlogUser\Paging\Filter\NavigationIndexSet\NavigationIndex\NextIndex;
use AppBundle\BlogUser\Paging\Filter\NavigationIndexSet\NavigationIndex\PrevIndex;
use AppBundle\BlogUser\Paging\Filter\SearchIdSet\SearchId\CurrentSearchId;
use AppBundle\BlogUser\Paging\Filter\SearchIdSet\SearchId\NextSearchId;
use AppBundle\BlogUser\Paging\Filter\SearchIdSet\SearchId\PrevSearchId;

class NavigationLinkFactory
{
    /**
     * @param PrevIndex $prevIndex
     * @param PrevSearchId $prevSearchId
     * @return PrevLink
     */
    public function createPrevLink(PrevIndex $prevIndex, PrevSearchId $prevSearchId)
    {
        return new PrevLink($prevIndex, $prevSearchId);
    }

    /**
     * @param CurrentIndex $currentIndex
     * @param CurrentSearchId $currentSearchId
     * @return CurrentLink
     */
    public function createCurrentLink(CurrentIndex $currentIndex, CurrentSearchId $currentSearchId)
    {
        return new CurrentLink($currentIndex, $currentSearchId);
    }

    /**
     * @param NextIndex $nextIndex
     * @param NextSearchId $nextSearchId
     * @return NextLink
     */
    public function createNextLink(NextIndex $nextIndex, NextSearchId $nextSearchId)
    {
        return new NextLink($nextIndex, $nextSearchId);
    }
}