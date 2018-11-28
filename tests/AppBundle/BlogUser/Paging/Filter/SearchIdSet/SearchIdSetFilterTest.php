<?php
/**
 * Created by PhpStorm.
 * User: Jens
 * Date: 09.11.2018
 * Time: 00:37
 */

namespace Tests\AppBundle\BlogUser\Paging\Filter\SearchIdSet;

use AppBundle\BlogUser\Paging\Filter\SearchIdSet\Filter\ChunkFilterFactory;
use AppBundle\BlogUser\Paging\Filter\SearchIdSet\SearchIdSetFilter;
use AppBundle\BlogUser\Paging\PaginationCondition;
use AppBundle\BlogUser\Paging\PaginationCondition\ItemsCount;
use AppBundle\BlogUser\Paging\PaginationCondition\ItemsPerPageCount;
use AppBundle\BlogUser\Paging\PaginationCondition\ShownItemsCount;
use AppBundle\Entity\Message;
use PHPUnit_Framework_MockObject_MockObject;

class SearchIdSetFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Message[]|PHPUnit_Framework_MockObject_MockObject[]
     */
    private $userMessages;

    public function setUp()
    {
        $begin = 1;
        $end = 7;
        $this->userMessages = $this->getCreatedChunkArray($begin, $end);
    }

    public function testCanBeCreated()
    {
        /** @var PaginationCondition $paginationCondition */
        $paginationCondition = $this->getMockBuilder(PaginationCondition::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $searchIdSetFilter = new SearchIdSetFilter($paginationCondition);
        $this->assertInstanceOf(SearchIdSetFilter::class, $searchIdSetFilter);
    }

    public function testRetrieveFirstSet()
    {
        $paginationCondition = new PaginationCondition(new ShownItemsCount(0), new ItemsCount(count($this->userMessages)), new ItemsPerPageCount(3));

        $searchIdSetFilter = new SearchIdSetFilter($paginationCondition);
        $chunkFilterFactory = new ChunkFilterFactory();
        $chunkFilter = $chunkFilterFactory->createChunkFilter($this->userMessages, $paginationCondition);
        
        $set = $searchIdSetFilter->retrieveFirstSet($chunkFilter);
        $this->assertEquals(-1, $set->getPrevSearchId()->asInt());
        $this->assertEquals(1, $set->getCurrentSearchId()->asInt());
        $this->assertEquals(1, $set->getNextSearchId()->asInt());
    }

    public function testRetrieveNextSetWithTwoChunks()
    {
        $this->userMessages = $this->getCreatedChunkArray(4, 7); // 4,5,6,  7 (displayed in view is 7)
        $paginationCondition = new PaginationCondition(new ShownItemsCount(1), new ItemsCount(count($this->userMessages)), new ItemsPerPageCount(3));

        $searchIdSetFilter = new SearchIdSetFilter($paginationCondition);
        $chunkFilterFactory = new ChunkFilterFactory();
        $chunkFilter = $chunkFilterFactory->createChunkFilter($this->userMessages, $paginationCondition);
        
        $set = $searchIdSetFilter->retrieveNextSet($chunkFilter);
        $this->assertEquals(7, $set->getPrevSearchId()->asInt());
        $this->assertEquals(-1, $set->getCurrentSearchId()->asInt());
        $this->assertEquals(-1, $set->getNextSearchId()->asInt());
    }

    public function testRetrieveNextSetWithThreeChunks()
    {
        $this->userMessages = $this->getCreatedChunkArray(4,10); // 4,5,6, 7,8,9, 10 (displayed in view is 7,8,9)
        $paginationCondition = new PaginationCondition(new ShownItemsCount(3), new ItemsCount(count($this->userMessages)), new ItemsPerPageCount(3));

        $searchIdSetFilter = new SearchIdSetFilter($paginationCondition);
        $chunkFilterFactory = new ChunkFilterFactory();
        $chunkFilter = $chunkFilterFactory->createChunkFilter($this->userMessages, $paginationCondition);

        $set = $searchIdSetFilter->retrieveNextSet($chunkFilter);
        $this->assertEquals(9, $set->getPrevSearchId()->asInt());
        $this->assertEquals(-1, $set->getCurrentSearchId()->asInt());
        $this->assertEquals(7, $set->getNextSearchId()->asInt());
    }

    public function testRetrievePrevSetWithTwoChunks()
    {
        $this->userMessages = $this->getCreatedChunkArray(1, 4); // 1,2,3, 4 (displayed in view is 4)
        $paginationCondition = new PaginationCondition(new ShownItemsCount(1), new ItemsCount(count($this->userMessages)), new ItemsPerPageCount(3));
        
        $searchIdSetFilter = new SearchIdSetFilter($paginationCondition);
        $chunkFilterFactory = new ChunkFilterFactory();
        $chunkFilter = $chunkFilterFactory->createChunkFilter($this->userMessages, $paginationCondition);
        $set = $searchIdSetFilter->retrievePrevSet($chunkFilter);
        $this->assertEquals(4, $set->getPrevSearchId()->asInt());
        $this->assertEquals(-1, $set->getCurrentSearchId()->asInt());
        $this->assertEquals(1, $set->getNextSearchId()->asInt());
    }

    public function testRetrievePrevSetWithThreeChunks()
    {
        $this->userMessages = $this->getCreatedChunkArray(1, 7); // 1,2,3, 4,5,6, 7 (displayed in view is 4)
        $paginationCondition = new PaginationCondition(new ShownItemsCount(7), new ItemsCount(count($this->userMessages)), new ItemsPerPageCount(3));

        $searchIdSetFilter = new SearchIdSetFilter($paginationCondition);
        $chunkFilterFactory = new ChunkFilterFactory();
        $chunkFilter = $chunkFilterFactory->createChunkFilter($this->userMessages, $paginationCondition);
        $set = $searchIdSetFilter->retrievePrevSet($chunkFilter);
        $this->assertEquals(6, $set->getPrevSearchId()->asInt());
        $this->assertEquals(-1, $set->getCurrentSearchId()->asInt());
        $this->assertEquals(1, $set->getNextSearchId()->asInt());
    }

    public function testRetrievePrevSetWithThreeChunksFull()
    {
        $this->userMessages = $this->getCreatedChunkArray(1, 9); // 1,2,3, 4,5,6, 7,8,9 (displayed in view is 4)
        $paginationCondition = new PaginationCondition(new ShownItemsCount(9), new ItemsCount(count($this->userMessages)), new ItemsPerPageCount(3));

        $searchIdSetFilter = new SearchIdSetFilter($paginationCondition);
        $chunkFilterFactory = new ChunkFilterFactory();
        $chunkFilter = $chunkFilterFactory->createChunkFilter($this->userMessages, $paginationCondition);
        $set = $searchIdSetFilter->retrievePrevSet($chunkFilter);
        $this->assertEquals(6, $set->getPrevSearchId()->asInt());
        $this->assertEquals(-1, $set->getCurrentSearchId()->asInt());
        $this->assertEquals(4, $set->getNextSearchId()->asInt());
    }

    public function testRetrievePrevSetWithThreeFullChunks()
    {
        $this->userMessages = $this->getCreatedChunkArray(1, 9); // 1,2,3, 4,5,6, 7,8,9 (displayed in view is 4)
        $paginationCondition = new PaginationCondition(new ShownItemsCount(9), new ItemsCount(count($this->userMessages)), new ItemsPerPageCount(3));

        $searchIdSetFilter = new SearchIdSetFilter($paginationCondition);
        $chunkFilterFactory = new ChunkFilterFactory();
        $chunkFilter = $chunkFilterFactory->createChunkFilter($this->userMessages, $paginationCondition);
        $set = $searchIdSetFilter->retrievePrevSet($chunkFilter);
        $this->assertEquals(6, $set->getPrevSearchId()->asInt());
        $this->assertEquals(-1, $set->getCurrentSearchId()->asInt());
        $this->assertEquals(4, $set->getNextSearchId()->asInt());
    }

    /**
     * @param $begin
     * @param $end
     * @return Message[]
     */
    private function getCreatedChunkArray($begin, $end)
    {
        $userMessages = [];
        for ($counter = $begin; $counter <= $end; $counter++) {
            /** @var Message|PHPUnit_Framework_MockObject_MockObject $message */
            $message = $this->getMock(Message::class);
            $message->expects($this->any())->method('getId')->willReturn($counter);
            $userMessages[] = $message;
        }
        
        return $userMessages;
    }
}
