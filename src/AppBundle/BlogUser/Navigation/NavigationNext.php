<?php


namespace AppBundle\BlogUser\Navigation;


use AppBundle\BlogUser\Paging\Filter\NavigationIndexSet\NavigationIndexSet;
use AppBundle\BlogUser\Paging\Filter\SearchIdSet\SearchIdSet;
use AppBundle\BlogUser\Paging\Filter\SearchIdSet\SearchIdSetException;
use AppBundle\BlogUser\Paging\Pagination\LastPage;
use AppBundle\BlogUser\Paging\PaginationCondition;
use AppBundle\BlogUser\Paging\PaginationCondition\ItemsCount;
use AppBundle\BlogUser\Paging\PaginationCondition\ItemsPerPageCount;
use AppBundle\BlogUser\Paging\PaginationCondition\ShownItemsCount;
use AppBundle\BlogUser\Paging\PaginationException;
use AppBundle\BlogUser\Paging\Pipe\NavigationViewInfo;
use AppBundle\BlogUser\Paging\Pipe\NavigationViewInfo\NavigationLink\CurrentLink;
use AppBundle\BlogUser\Paging\Pipe\NavigationViewInfo\NavigationLink\NextLink;
use AppBundle\BlogUser\Paging\Pipe\NavigationViewInfo\NavigationLink\PrevLink;
use AppBundle\BlogUser\Paging\Pipe\NavigationViewInfo\NavigationLink\SearchId;
use AppBundle\Entity\Message;
use AppBundle\Repository\MessageRepository;

class NavigationNext
{
    /**
     * @var LastPage
     */
    private $lastPage;

    /**
     * @var SearchId
     */
    private $searchId;

    /**
     * @var ShownItemsCount
     */
    private $shownItemsCount;

    /**
     * @var MessageRepository
     */
    private $messageRepository;

    /**
     * @var NavigationFactoryContainer
     */
    private $navigationFactoryContainer;

    /**
     * @var Message[]
     */
    private $userMessages;

    /**
     * NavigationNext constructor.
     * @param LastPage $lastPage
     * @param SearchId $searchId
     * @param ShownItemsCount $shownItemsCount
     * @param MessageRepository $messageRepository
     * @param \AppBundle\BlogUser\Navigation\NavigationFactoryContainer $navigationFactoryContainer
     */
    public function __construct(
        LastPage $lastPage, SearchId $searchId, ShownItemsCount $shownItemsCount, MessageRepository $messageRepository,
        \AppBundle\BlogUser\Navigation\NavigationFactoryContainer $navigationFactoryContainer
    ) {
        $this->lastPage                   = $lastPage;
        $this->searchId                   = $searchId;
        $this->shownItemsCount             = $shownItemsCount;
        $this->messageRepository          = $messageRepository;
        $this->navigationFactoryContainer = $navigationFactoryContainer;
    }


    /**
     * @return NavigationViewInfo
     * @throws SearchIdSetException
     * @throws PaginationException
     */
    public function retrieveNextDisplayInfo()
    {
        $itemsPerPageCount = new ItemsPerPageCount(3);

        /** @var Message[] $userMessages */
        $userMessages = $this->messageRepository
            ->findByPageIdForward($this->searchId, $itemsPerPageCount->asInt() * 3)
        ;

        $paginationCondition = new PaginationCondition(
            $this->shownItemsCount,
            new ItemsCount(count($userMessages)),
            $itemsPerPageCount
        );
        
//        if ($paginationCondition->getshownItemsCount() < $paginationCondition->getItemsPerPageCount() * 3) {
//            
//        }
        
        
        $this->userMessages = [];
        $offset = $paginationCondition->getShownItemsCount()->asInt();
        $this->userMessages = array_slice($userMessages, $offset, $paginationCondition->getItemsPerPageCount()->asInt());
//        $this->userMessageFactoryContainer->createUserMessagesHelper()->getSlicedMessagesByChunk(
//            new Chunk(PaginationCondition::MIDDLE_CHUNK), $navigation->getIndexedUserMessages(), new ItemsPerPageCount(3)
//        );
        
//        $this->userMessages = $userMessages;


        $navigationViewInfo = $this->getCreatedNavigationViewInfo($userMessages, $paginationCondition);

        return $navigationViewInfo;
    }

    /**
     * @param $userMessages
     * @param $paginationCondition
     * @return NavigationViewInfo
     * @throws SearchIdSetException
     * @throws PaginationException
     */
    private function getCreatedNavigationViewInfo($userMessages, $paginationCondition)
    {
        $navigationIndexSet = $this->navigationFactoryContainer
            ->getNavigationIndexSetFilterFactory()
            ->createNavigationIndexSetFilter($this->lastPage, $paginationCondition)
            ->retrieveNextSet()
        ;

        $chunkFilter = $this->navigationFactoryContainer
            ->getChunkFilterFactory()
            ->createChunkFilter($userMessages, $paginationCondition)
        ;

        $searchIdSet = $this->navigationFactoryContainer
            ->getSearchIdSetFilterFactory()
            ->createSearchIdSetFilter($paginationCondition)
            ->retrieveNextSet($chunkFilter)
        ;

        $prevLink    = $this->getCreatedPrevLink($navigationIndexSet, $searchIdSet);
        $currentLink = $this->getCreatedCurrentLink($navigationIndexSet, $searchIdSet);
        $nextLink    = $this->getCreatedNextLink($navigationIndexSet, $searchIdSet);

        $navigationViewInfo = $this->navigationFactoryContainer
            ->getNavigationViewInfoFactory()
            ->createNavigationViewInfo($prevLink, $currentLink, $nextLink)
        ;

        return $navigationViewInfo;
    }

    /**
     * @param NavigationIndexSet $navigationIndexSet
     * @param SearchIdSet $searchIdSet
     * @return PrevLink
     */
    private function getCreatedPrevLink(
        NavigationIndexSet $navigationIndexSet, SearchIdSet $searchIdSet
    ) {
        $prevLink = $this->navigationFactoryContainer
            ->getNavigationLinkFactory()
            ->createPrevLink(
                $navigationIndexSet->getPrevIndex(),
                $searchIdSet->getPrevSearchId()
            )
        ;

        return $prevLink;
    }

    /**
     * @param NavigationIndexSet $navigationIndexSet
     * @param SearchIdSet $searchIdSet
     * @return CurrentLink
     */
    private function getCreatedCurrentLink(
        NavigationIndexSet $navigationIndexSet, SearchIdSet $searchIdSet
    ) {
        $currentLink = $this->navigationFactoryContainer
            ->getNavigationLinkFactory()
            ->createCurrentLink(
                $navigationIndexSet->getCurrentIndex(),
                $searchIdSet->getCurrentSearchId()
            )
        ;

        return $currentLink;
    }

    /**
     * @param NavigationIndexSet $navigationIndexSet
     * @param SearchIdSet $searchIdSet
     * @return NextLink
     */
    private function getCreatedNextLink(
        NavigationIndexSet $navigationIndexSet, SearchIdSet $searchIdSet
    ) {
        $nextLink = $this->navigationFactoryContainer
            ->getNavigationLinkFactory()
            ->createNextLink(
                $navigationIndexSet->getNextIndex(),
                $searchIdSet->getNextSearchId()
            )
        ;

        return $nextLink;
    }

    public function getIndexedUserMessages()
    {
        return $this->userMessages;
    }
}