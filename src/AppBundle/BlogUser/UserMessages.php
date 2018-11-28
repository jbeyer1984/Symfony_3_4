<?php

namespace AppBundle\BlogUser;

use AppBundle\Entity\Message;
use AppBundle\Repository\MessageRepository;

class UserMessages
{
    /**
     * @var MessageRepository
     */
    private $repository;

    /**
     * UserMessages constructor.
     * @param MessageRepository $repository
     */
    public function __construct(MessageRepository $repository)
    {
        $this->repository = $repository;
    }


    public function getOneUserMessageById()
    {
        
    }

    public function getByPage($lastPageId, $itemsCount)
    {
        $userMessages = $this->repository->findByPageIdForward($lastPageId, $itemsCount);
        
        return $userMessages;
    }

    /**
     * @return Message[]
     */
    public function getUserMessages()
    {
        $userMessages = $this->repository->findBy([], ['dateStamp' => 'DESC']);
        
        return $userMessages;
    }
}