<?php


namespace AppBundle\BlogUser\Paging\Pipe;


use AppBundle\BlogUser\Paging\Pipe\NavigationViewInfo\NavigationLink\CurrentLink;
use AppBundle\BlogUser\Paging\Pipe\NavigationViewInfo\NavigationLink\NextLink;
use AppBundle\BlogUser\Paging\Pipe\NavigationViewInfo\NavigationLink\PrevLink;

class NavigationViewInfoFactory
{
    /**
     * @param PrevLink $prevLink
     * @param CurrentLink $currentLink
     * @param NextLink $nextLink
     * @return NavigationViewInfo
     */
    public function createNavigationViewInfo(PrevLink $prevLink, CurrentLink $currentLink, NextLink $nextLink)
    {
        return new NavigationViewInfo($prevLink, $currentLink, $nextLink);
    }
}