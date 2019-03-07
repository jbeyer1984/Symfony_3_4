<?php


namespace AppBundle\BlogUser\Navigation;


use AppBundle\BlogUser\Paging\Filter\NavigationIndexSet\NavigationIndexSetFilterFactory;
use AppBundle\BlogUser\Paging\Filter\SearchIdSet\Filter\ChunkFilterFactory;
use AppBundle\BlogUser\Paging\Filter\SearchIdSet\SearchIdSetFilterFactory;
use AppBundle\BlogUser\Paging\Pipe\NavigationViewInfo\NavigationLink\NavigationLinkFactory;
use AppBundle\BlogUser\Paging\Pipe\NavigationViewInfoFactory;

class NavigationFactoryContainer
{
    /**
     * @var NavigationIndexSetFilterFactory
     */
    private $navigationIndexSetFilterFactory;

    /**
     * @var ChunkFilterFactory
     */
    private $chunkFilterFactory;

    /**
     * @var SearchIdSetFilterFactory
     */
    private $searchIdSetFilterFactory;

    /**
     * @var NavigationLinkFactory
     */
    private $navigationLinkFactory;

    /**
     * @var NavigationViewInfoFactory
     */
    private $navigationViewInfoFactory;

    /**
     * NavigationFactoryContainer constructor.
     * @param NavigationIndexSetFilterFactory $navigationIndexSetFilterFactory
     * @param ChunkFilterFactory $chunkFilterFactory
     * @param SearchIdSetFilterFactory $searchIdSetFilterFactory
     * @param NavigationLinkFactory $navigationLinkFactory
     * @param NavigationViewInfoFactory $navigationViewInfoFactory
     */
    public function __construct(
        NavigationIndexSetFilterFactory $navigationIndexSetFilterFactory, ChunkFilterFactory $chunkFilterFactory,
        SearchIdSetFilterFactory $searchIdSetFilterFactory, NavigationLinkFactory $navigationLinkFactory,
        NavigationViewInfoFactory $navigationViewInfoFactory
    ) {
        $this->navigationIndexSetFilterFactory = $navigationIndexSetFilterFactory;
        $this->chunkFilterFactory              = $chunkFilterFactory;
        $this->searchIdSetFilterFactory        = $searchIdSetFilterFactory;
        $this->navigationLinkFactory           = $navigationLinkFactory;
        $this->navigationViewInfoFactory       = $navigationViewInfoFactory;
    }


    /**
     * @return NavigationIndexSetFilterFactory
     */
    public function getNavigationIndexSetFilterFactory()
    {
        return $this->navigationIndexSetFilterFactory;
    }

    /**
     * @return ChunkFilterFactory
     */
    public function getChunkFilterFactory()
    {
        $this->getChunkFilterFactory();
        return $this->chunkFilterFactory;
    }

    /**
     * @return SearchIdSetFilterFactory
     */
    public function getSearchIdSetFilterFactory()
    {
        return $this->searchIdSetFilterFactory;
    }

    /**
     * @return NavigationLinkFactory
     */
    public function getNavigationLinkFactory()
    {
        return $this->navigationLinkFactory;
    }

    /**
     * @return NavigationViewInfoFactory
     */
    public function getNavigationViewInfoFactory()
    {
        return $this->navigationViewInfoFactory;
    }
}
