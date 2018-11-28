<?php


namespace AppBundle\BlogUser;


use AppBundle\Entity\Message;
use AppBundle\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;

class UserMessageFactoryContainer
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    
    
    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }
    
    public function createUserMessage()
    {
        $messageRepository = $this->createMessageRepository();

        return new UserMessages($messageRepository);
    }

    /**
     * @return MessageRepository
     */
    public function createMessageRepository()
    {
        $messageRepository = new MessageRepository($this->entityManager, new ClassMetadata(Message::class));

        return $messageRepository;
    }

    /**
     * @return UserMessagesHelper
     */
    public function createUserMessagesHelper()
    {
        return new UserMessagesHelper();
    }
}