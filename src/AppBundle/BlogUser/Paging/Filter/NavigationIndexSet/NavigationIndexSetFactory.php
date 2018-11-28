<?php


namespace AppBundle\BlogUser\Paging\Filter\NavigationIndexSet;


use AppBundle\BlogUser\Paging\Filter\NavigationIndexSet\NavigationIndex\CurrentIndex;
use AppBundle\BlogUser\Paging\Filter\NavigationIndexSet\NavigationIndex\NextIndex;
use AppBundle\BlogUser\Paging\Filter\NavigationIndexSet\NavigationIndex\PrevIndex;

class NavigationIndexSetFactory
{
    /**
     * @param PrevIndex $prevIndex
     * @param CurrentIndex $currentIndex
     * @param NextIndex $nextIndex
     * @return NavigationIndexSet
     */
    public function createNavigationIndexSet(PrevIndex $prevIndex, CurrentIndex $currentIndex, NextIndex $nextIndex)
    {
        return new NavigationIndexSet($prevIndex, $currentIndex, $nextIndex);
    }
}