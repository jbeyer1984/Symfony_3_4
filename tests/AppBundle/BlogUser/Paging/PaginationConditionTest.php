<?php
/**
 * Created by PhpStorm.
 * User: Jens
 * Date: 12.11.2018
 * Time: 14:44
 */

namespace Tests\AppBundle\BlogUser\Paging;

use AppBundle\BlogUser\Paging\PaginationCondition;
use AppBundle\BlogUser\Paging\PaginationCondition\Chunk;
use AppBundle\BlogUser\Paging\PaginationCondition\ItemsCount;
use AppBundle\BlogUser\Paging\PaginationCondition\ItemsPerPageCount;
use AppBundle\BlogUser\Paging\PaginationCondition\ShownItemsCount;
use PHPUnit_Framework_MockObject_MockObject;

class PaginationConditionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ShownItemsCount|PHPUnit_Framework_MockObject_MockObject
     */
    private $shownItemsCount;

    /**
     * @var ItemsCount|PHPUnit_Framework_MockObject_MockObject
     */
    private $itemsCount;


    /**
     * @var ItemsPerPageCount|PHPUnit_Framework_MockObject_MockObject
     */
    private $itemsPerPageCount;

    public function setUp()
    {
        $this->shownItemsCount = $this->getMockBuilder(ShownItemsCount::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->itemsCount      = $this->getMockBuilder(ItemsCount::class)
            ->disableOriginalConstructor()
            ->getMock();
        ;
        $this->itemsPerPageCount = $this->getMockBuilder(ItemsPerPageCount::class)
            ->disableOriginalConstructor()
            ->getMock();
        ;
        $this->itemsPerPageCount->expects($this->any())->method('asInt')->willReturn(3);
    }
    
    public function testCanBeCreated()
    {
        $paginationCondition = new PaginationCondition($this->shownItemsCount, $this->itemsCount, $this->itemsPerPageCount);
        $this->assertInstanceOf(PaginationCondition::class, $paginationCondition);
    }

    public function testGetItemsPerPageCount()
    {
        $this->itemsPerPageCount->expects($this->any())->method('asInt')->willReturn(3);
        $paginationCondition = new PaginationCondition($this->shownItemsCount, $this->itemsCount, $this->itemsPerPageCount);
        $this->assertSame($this->itemsPerPageCount, $paginationCondition->getItemsPerPageCount());
    }

    public function testHasEnoughItemsAt()
    {
        $this->itemsCount->expects($this->any())->method('asInt')->willReturn(3);
        $paginationCondition = new PaginationCondition($this->shownItemsCount, $this->itemsCount, $this->itemsPerPageCount);
        $this->assertTrue($paginationCondition->hasEnoughItemsAt(new Chunk(PaginationCondition::FIRST_CHUNK)));
    }

    public function testHasNotEnoughItemsAt()
    {
        $this->itemsCount->expects($this->any())->method('asInt')->willReturn(3);
        $paginationCondition = new PaginationCondition($this->shownItemsCount, $this->itemsCount, $this->itemsPerPageCount);
        $this->assertFalse($paginationCondition->hasEnoughItemsAt(new Chunk(PaginationCondition::MIDDLE_CHUNK)));
        $this->assertFalse($paginationCondition->hasEnoughItemsAt(new Chunk(PaginationCondition::LAST_CHUNK)));
    }

    public function testHasReachedBorder()
    {
        $this->itemsCount->expects($this->any())->method('asInt')->willReturn(6);
        $paginationCondition = new PaginationCondition($this->shownItemsCount, $this->itemsCount, $this->itemsPerPageCount);
        $this->assertTrue($paginationCondition->hasReachedBorder());
    }

    public function testNotHasReachedBorder()
    {
        $this->itemsCount->expects($this->any())->method('asInt')->willReturn(7);
        $paginationCondition = new PaginationCondition($this->shownItemsCount, $this->itemsCount, $this->itemsPerPageCount);
        $this->assertFalse($paginationCondition->hasReachedBorder());
    }

    public function testGetItemsCount()
    {
        $this->itemsCount->expects($this->any())->method('asInt')->willReturn(3);
        $paginationCondition = new PaginationCondition($this->shownItemsCount, $this->itemsCount, $this->itemsPerPageCount);
        $this->assertSame($this->itemsCount, $paginationCondition->getItemsCount());
    }
}
