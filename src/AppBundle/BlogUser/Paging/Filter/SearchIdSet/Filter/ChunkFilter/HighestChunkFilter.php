<?php


namespace AppBundle\BlogUser\Paging\Filter\SearchIdSet\Filter\ChunkFilter;


use AppBundle\BlogUser\Paging\PaginationCondition;
use AppBundle\Entity\Message;

class HighestChunkFilter
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
     * HighestChunkFilter constructor.
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

        $end = ($chunkPosition+1) * $this->paginationCondition->getItemsPerPageCount()->asInt() -1;
        if (isset($this->userMessages[$end])) {
            $message = $this->userMessages[$end];
            $messageId = $message->getId();
        } else {
            $lowestIndex = $chunkPosition * $this->paginationCondition->getItemsPerPageCount()->asInt();
            while ($end >= $lowestIndex && -1 === $messageId) {
                if (isset($this->userMessages[$end])) {
                    $message = $this->userMessages[$end];
                    $messageId = $message->getId();
                }
                $end--;
            }
        }

        return $messageId;
    }
}