<?php


namespace AppBundle\BlogUser\Controller\UserController;

use AppBundle\BlogUser\Paging\Filter\NavigationIndexSet\NavigationIndexSetFilterFactory;
use AppBundle\BlogUser\Paging\Filter\SearchIdSet\Filter\ChunkFilterFactory;
use AppBundle\BlogUser\Paging\Filter\SearchIdSet\SearchIdSetFilterFactory;
use AppBundle\BlogUser\Navigation\NavigationFactoryContainer;
use AppBundle\BlogUser\Navigation\NavigationPrev;
use AppBundle\BlogUser\Paging\Pagination\LastPage;
use AppBundle\BlogUser\Paging\PaginationCondition;
use AppBundle\BlogUser\Paging\PaginationCondition\Chunk;
use AppBundle\BlogUser\Paging\PaginationCondition\ItemsPerPageCount;
use AppBundle\BlogUser\Paging\PaginationCondition\ShownItemsCount;
use AppBundle\BlogUser\Paging\PaginationException;
use AppBundle\BlogUser\Paging\Pipe\NavigationViewInfo;
use AppBundle\BlogUser\Paging\Pipe\NavigationViewInfo\NavigationLink\NavigationLinkFactory;
use AppBundle\BlogUser\Paging\Pipe\NavigationViewInfo\NavigationLink\SearchId;
use AppBundle\BlogUser\Paging\Pipe\NavigationViewInfoFactory;
use AppBundle\BlogUser\UserMessageFactoryContainer;

class ShowPagePrevAction
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
     * @var UserMessageFactoryContainer
     */
    private $userMessageFactoryContainer;

    /**
     * @var array
     */
    private $varsToRender;

    /**
     * ShowPagePrevAction constructor.
     * @param LastPage $lastPage
     * @param SearchId $searchId
     * @param ShownItemsCount $shownItemsCount
     * @param UserMessageFactoryContainer $userMessageFactoryContainer
     */
    public function __construct(
        LastPage $lastPage, SearchId $searchId, ShownItemsCount $shownItemsCount,
        UserMessageFactoryContainer $userMessageFactoryContainer
    ) {
        $this->lastPage                    = $lastPage;
        $this->searchId                    = $searchId;
        $this->shownItemsCount              = $shownItemsCount;
        $this->userMessageFactoryContainer = $userMessageFactoryContainer;
    }


    /**
     * @throws PaginationException
     * @throws \AppBundle\BlogUser\Paging\Filter\SearchIdSet\SearchIdSetException
     */
    public function execute()
    {
        $navigation = new NavigationPrev(
            $this->lastPage,
            $this->searchId,
            $this->shownItemsCount,
            $this->userMessageFactoryContainer->createMessageRepository(),
            new NavigationFactoryContainer(
                new NavigationIndexSetFilterFactory(), new ChunkFilterFactory(),
                new SearchIdSetFilterFactory(), new NavigationLinkFactory(),
                new NavigationViewInfoFactory()
            )
        );

        $prevDisplayInfo = $navigation->retrievePrevDisplayInfo();

        $this->renderNavigation($navigation, $prevDisplayInfo);
    }

    /**
     * @param NavigationPrev $navigation
     * @param NavigationViewInfo $prevDisplayInfo
     * @throws PaginationException
     */
    private function renderNavigation(NavigationPrev $navigation, NavigationViewInfo $prevDisplayInfo)
    {
//        $userMessages = $this->userMessageFactoryContainer->createUserMessagesHelper()->getSlicedMessagesByChunk(
//            new Chunk(PaginationCondition::FIRST_CHUNK), $navigation->getIndexedUserMessages(), new ItemsPerPageCount(3)
//        );
        $userMessages = $navigation->getIndexedUserMessages();

        $navigation = [
            'index'    => [
                'prevExists'    => $prevDisplayInfo->getPrevLink()->isExisting(),
                'prev'          => $prevDisplayInfo->getPrevLink()->getPrevIndex()->asInt(),
                'currentExists' => $prevDisplayInfo->getCurrentLink()->isExisting(),
                'current'       => $prevDisplayInfo->getCurrentLink()->getCurrentIndex()->asInt(),
                'nextExists'    => $prevDisplayInfo->getNextLink()->isExisting(),
                'next'          => $prevDisplayInfo->getNextLink()->getNextIndex()->asInt()
            ],
            'searchId' => [
                'prev'    => $prevDisplayInfo->getPrevLink()->getSearchId()->asInt(),
                'current' => $prevDisplayInfo->getCurrentLink()->getSearchId()->asInt(),
                'next'    => $prevDisplayInfo->getNextLink()->getSearchId()->asInt(),
            ],
            'shownItemsCount' => count($userMessages)

        ];
        
        $this->varsToRender = [
            'messages'   => $userMessages,
            'navigation' => $navigation
        ];
    }

    /**
     * @return array
     */
    public function getVarsToRender()
    {
        return $this->varsToRender;
    }

}