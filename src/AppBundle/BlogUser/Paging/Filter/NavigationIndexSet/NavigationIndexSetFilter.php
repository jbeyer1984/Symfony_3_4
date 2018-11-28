<?php


namespace AppBundle\BlogUser\Paging\Filter\NavigationIndexSet;


use AppBundle\BlogUser\Paging\Filter\NavigationIndexSet\NavigationIndex\CurrentIndex;
use AppBundle\BlogUser\Paging\Filter\NavigationIndexSet\NavigationIndex\NextIndex;
use AppBundle\BlogUser\Paging\Filter\NavigationIndexSet\NavigationIndex\PrevIndex;
use AppBundle\BlogUser\Paging\Pagination\LastPage;
use AppBundle\BlogUser\Paging\PaginationCondition;
use AppBundle\BlogUser\Paging\PaginationCondition\Chunk;
use AppBundle\BlogUser\Paging\PaginationException;

class NavigationIndexSetFilter
{
    /**
     * @var LastPage
     */
    private $lastPage;

    /**
     * @var PaginationCondition
     */
    private $paginationCondition;

    /**
     * @var NavigationIndexSetFactory
     */
    private $navigationIndexSetFactory;

    /**
     * NavigationIndexSetFilter constructor.
     * @param LastPage $lastPage
     * @param PaginationCondition $paginationCondition
     * @param NavigationIndexSetFactory $navigationIndexSetFactory
     */
    public function __construct(
        LastPage $lastPage, PaginationCondition $paginationCondition,
        NavigationIndexSetFactory $navigationIndexSetFactory
    ) {
        $this->lastPage                  = $lastPage;
        $this->paginationCondition       = $paginationCondition;
        $this->navigationIndexSetFactory = $navigationIndexSetFactory;
    }

    /**
     * @return NavigationIndexSet
     * @throws PaginationException
     */
    public function retrieveFirstSet()
    {
        $prev = new PrevIndex(-1);
        $current = new CurrentIndex(1);
        $next = new NextIndex(-1);
        
        if ($this->paginationCondition->hasEnoughItemsAt(new Chunk(PaginationCondition::MIDDLE_CHUNK))) {
            $next = new NextIndex(2);
        }
        
        return $this->navigationIndexSetFactory->createNavigationIndexSet($prev, $current, $next);
    }

    /**
     * @return NavigationIndexSet
     * @throws PaginationException
     */
    public function retrieveNextSet()
    {
        $prev = new PrevIndex($this->lastPage->asInt() -1);
        $current = new CurrentIndex($this->lastPage->asInt());
        $next = new NextIndex(-1);
        $chunkToCheckEnoughItems = PaginationCondition::LAST_CHUNK;
        if (!$this->paginationCondition->hasReachedBorder()) {
            if ($this->paginationCondition->hasEnoughItemsAt(new Chunk($chunkToCheckEnoughItems))) {
                $next = new NextIndex($this->lastPage->asInt() +1);
            }
        }
        
        return $this->navigationIndexSetFactory->createNavigationIndexSet($prev, $current, $next);
    }

    /**
     * @return NavigationIndexSet
     * @throws PaginationException
     */
    public function retrievePrevSet()
    {
        $prev = new PrevIndex(-1);
        if (!$this->paginationCondition->hasReachedBorder()) {
            $prev = new PrevIndex($this->lastPage->asInt() -1);
        }
        $current = new CurrentIndex($this->lastPage->asInt());
        $next = new NextIndex(-1);
        $chunkToCheckEnoughItems = PaginationCondition::LAST_CHUNK;
        if ($this->paginationCondition->hasReachedBorder()) {
            $chunkToCheckEnoughItems = PaginationCondition::MIDDLE_CHUNK;
        }
        if ($this->paginationCondition->hasEnoughItemsAt(new Chunk($chunkToCheckEnoughItems))) {
            $next = new NextIndex($this->lastPage->asInt() +1);
        }

        return $this->navigationIndexSetFactory->createNavigationIndexSet($prev, $current, $next);
    }
}