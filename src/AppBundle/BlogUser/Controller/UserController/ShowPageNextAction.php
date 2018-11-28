<?php


namespace AppBundle\BlogUser\Controller\UserController;

use AppBundle\BlogUser\Paging\Filter\NavigationIndexSet\NavigationIndexSetFilterFactory;
use AppBundle\BlogUser\Paging\Filter\SearchIdSet\Filter\ChunkFilterFactory;
use AppBundle\BlogUser\Paging\Filter\SearchIdSet\SearchIdSetFilterFactory;
use AppBundle\BlogUser\Navigation\NavigationFactoryContainer;
use AppBundle\BlogUser\Navigation\NavigationNext;
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

class ShowPageNextAction
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
     * ShowPageNextAction constructor.
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
        $navigation = new NavigationNext(
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

        $nextDisplayInfo = $navigation->retrieveNextDisplayInfo();

        $this->renderNavigation($navigation, $nextDisplayInfo);
    }

    /**
     * @param NavigationNext $navigation
     * @param NavigationViewInfo $firstDisplayInfo
     * @throws PaginationException
     */
    private function renderNavigation(NavigationNext $navigation, NavigationViewInfo $firstDisplayInfo)
    {
//        $userMessages = $this->userMessageFactoryContainer->createUserMessagesHelper()->getSlicedMessagesByChunk(
//            new Chunk(PaginationCondition::MIDDLE_CHUNK), $navigation->getIndexedUserMessages(), new ItemsPerPageCount(3)
//        );
        $userMessages = $navigation->getIndexedUserMessages();

        $navigation = [
            'index'    => [
                'prevExists'    => $firstDisplayInfo->getPrevLink()->isExisting(),
                'prev'          => $firstDisplayInfo->getPrevLink()->getPrevIndex()->asInt(),
                'currentExists' => $firstDisplayInfo->getCurrentLink()->isExisting(),
                'current'       => $firstDisplayInfo->getCurrentLink()->getCurrentIndex()->asInt(),
                'nextExists'    => $firstDisplayInfo->getNextLink()->isExisting(),
                'next'          => $firstDisplayInfo->getNextLink()->getNextIndex()->asInt()
            ],
            'searchId' => [
                'prev'    => $firstDisplayInfo->getPrevLink()->getSearchId()->asInt(),
                'current' => $firstDisplayInfo->getCurrentLink()->getSearchId()->asInt(),
                'next'    => $firstDisplayInfo->getNextLink()->getSearchId()->asInt(),
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