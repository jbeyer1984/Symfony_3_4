<?php


namespace AppBundle\BlogUser\Paging\Pipe;


use AppBundle\BlogUser\Paging\Pipe\NavigationViewInfo\NavigationLink\CurrentLink;
use AppBundle\BlogUser\Paging\Pipe\NavigationViewInfo\NavigationLink\NextLink;
use AppBundle\BlogUser\Paging\Pipe\NavigationViewInfo\NavigationLink\PrevLink;

class NavigationViewInfo
{
    /**
     * @var PrevLink
     */
    private $prevLink;

    /**
     * @var CurrentLink
     */
    private $currentLink;

    /**
     * @var NextLink
     */
    private $nextLink;

    /**
     * NavigationViewInfo constructor.
     * @param PrevLink $prevLink
     * @param CurrentLink $currentLink
     * @param NextLink $nextLink
     */
    public function __construct(PrevLink $prevLink, CurrentLink $currentLink, NextLink $nextLink)
    {
        $this->prevLink    = $prevLink;
        $this->currentLink = $currentLink;
        $this->nextLink    = $nextLink;
    }

    /**
     * @return CurrentLink
     */
    public function getCurrentLink()
    {
        return $this->currentLink;
    }

    /**
     * @return NextLink
     */
    public function getNextLink()
    {
        return $this->nextLink;
    }

    /**
     * @return PrevLink
     */
    public function getPrevLink()
    {
        return $this->prevLink;
    }
}