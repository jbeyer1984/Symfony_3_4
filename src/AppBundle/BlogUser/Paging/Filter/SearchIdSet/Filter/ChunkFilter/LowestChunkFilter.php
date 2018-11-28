<?php


namespace AppBundle\BlogUser\Paging\Filter\SearchIdSet\Filter\ChunkFilter;


use AppBundle\BlogUser\Paging\PaginationCondition;
use AppBundle\Entity\Message;

class LowestChunkFilter
{
    /**
     * @var Message[]
     */
    private $userMessages;
    
    /**
     * @var PaginationCondition
     */
    private $paginationCondition;

    /**
     * LowestChunkFilter constructor.
     * @param Message[] $userMessages
     * @param PaginationCondition $paginationCondition
     */
    public function __construct(array $userMessages, PaginationCondition $paginationCondition)
    {
        $this->userMessages        = $userMessages;
        $this->paginationCondition = $paginationCondition;
    }

    /**
     * @param int $chunkPosition
     * @return int
     */
    public function retrieveSearchIdValueBy($chunkPosition)
    {
        $messageId = -1;
        if (0 === $chunkPosition) {
            $message = $this->userMessages[0];
            $messageId = $message->getId();
        } else {
            $start = $chunkPosition * $this->paginationCondition->getItemsPerPageCount()->asInt();
            if (isset($this->userMessages[$start])) {
                $message = $this->userMessages[$start];
                $messageId = $message->getId();
            }
        }

        return $messageId;
    }
}