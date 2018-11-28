<?php


namespace AppBundle\Repository;


use AppBundle\BlogUser\Paging\Pipe\NavigationViewInfo\NavigationLink\SearchId;
use AppBundle\Entity\Message;
use Doctrine\ORM\EntityRepository;

class MessageRepository extends EntityRepository
{
    /**
     * @param SearchId $searchId
     * @param $itemsCount
     * @return Message[]
     */
    public function findByPageIdForward($searchId, $itemsCount)
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.dateStamp', 'ASC')
            ->where('m.id >=' .  $searchId->asInt())
            ->setMaxResults($itemsCount)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param SearchId $searchId
     * @param $itemsCount
     * @return Message[]
     */
    public function findByPageBackward(SearchId $searchId, $itemsCount)
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.dateStamp', 'ASC')
            ->where('m.id <=' .  $searchId->asInt())
            ->setMaxResults($itemsCount)
            ->getQuery()
            ->getResult()
        ;
    }
}