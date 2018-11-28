<?php


namespace AppBundle\BlogUser\Paging\Filter\NavigationIndexSet;


use AppBundle\BlogUser\Paging\Pagination\LastPage;
use AppBundle\BlogUser\Paging\PaginationCondition;

class NavigationIndexSetFilterFactory
{
    public function createNavigationIndexSetFilter(LastPage $lastPage, PaginationCondition $paginationCondition)
    {
        return new NavigationIndexSetFilter($lastPage, $paginationCondition, new NavigationIndexSetFactory());
    }
}