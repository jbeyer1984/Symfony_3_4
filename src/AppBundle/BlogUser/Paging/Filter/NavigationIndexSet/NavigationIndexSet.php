<?php


namespace AppBundle\BlogUser\Paging\Filter\NavigationIndexSet;


use AppBundle\BlogUser\Paging\Filter\NavigationIndexSet\NavigationIndex\CurrentIndex;
use AppBundle\BlogUser\Paging\Filter\NavigationIndexSet\NavigationIndex\NextIndex;
use AppBundle\BlogUser\Paging\Filter\NavigationIndexSet\NavigationIndex\PrevIndex;

class NavigationIndexSet
{
    /**
     * @var PrevIndex
     */
    private $prevIndex;

    /**
     * @var CurrentIndex
     */
    private $currentIndex;

    /**
     * @var NextIndex
     */
    private $nextIndex;

    /**
     * NavigationIndexSet constructor.
     * @param PrevIndex $prevIndex
     * @param CurrentIndex $currentIndex
     * @param NextIndex $nextIndex
     */
    public function __construct(PrevIndex $prevIndex, CurrentIndex $currentIndex, NextIndex $nextIndex)
    {
        $this->prevIndex    = $prevIndex;
        $this->currentIndex = $currentIndex;
        $this->nextIndex    = $nextIndex;
    }

    /**
     * @return PrevIndex
     */
    public function getPrevIndex()
    {
        return $this->prevIndex;
    }

    /**
     * @return CurrentIndex
     */
    public function getCurrentIndex()
    {
        return $this->currentIndex;
    }

    /**
     * @return NextIndex
     */
    public function getNextIndex()
    {
        return $this->nextIndex;
    }
}