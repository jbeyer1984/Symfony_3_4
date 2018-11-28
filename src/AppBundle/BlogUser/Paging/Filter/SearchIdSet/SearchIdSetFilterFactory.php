<?php


namespace AppBundle\BlogUser\Paging\Filter\SearchIdSet;


use AppBundle\BlogUser\Paging\PaginationCondition;

class SearchIdSetFilterFactory
{
    public function createSearchIdSetFilter(PaginationCondition $paginationCondition)
    {
        return new SearchIdSetFilter($paginationCondition);
    }
}