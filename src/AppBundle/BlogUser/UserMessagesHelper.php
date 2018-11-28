<?php


namespace AppBundle\BlogUser;


use AppBundle\BlogUser\Paging\PaginationCondition\Chunk;
use AppBundle\BlogUser\Paging\PaginationCondition\ItemsPerPageCount;

class UserMessagesHelper
{
    /**
     * @param Chunk $chunk
     * @param $userMessages
     * @param ItemsPerPageCount $itemsPerPageCount
     * @return array
     */
    public function getSlicedMessagesByChunk(Chunk $chunk, $userMessages, ItemsPerPageCount $itemsPerPageCount)
    {
        return array_slice($userMessages, $chunk->asInt() * $itemsPerPageCount->asInt(), $itemsPerPageCount->asInt());
    }
}