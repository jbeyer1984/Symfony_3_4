<?php


namespace AppBundle\BlogUser\Paging\Filter\SearchIdSet\SearchId;


use AppBundle\BlogUser\Paging\Filter\SearchIdSet\SearchIdSetException;

class CurrentSearchId
{
    /**
     * @var int
     */
    private $searchId;

    /**
     * FirstSearchId constructor.
     * @param int $searchId
     * @throws SearchIdSetException
     */
    public function __construct($searchId)
    {
        $this->ensureSearchIdIsInt($searchId);
        $this->searchId = $searchId;
    }

    /**
     * @param $searchId
     * @throws SearchIdSetException
     */
    private function ensureSearchIdIsInt($searchId)
    {
        if (!is_int($searchId)) {
            throw new SearchIdSetException(sprintf('$searchId is not integer, given %S', gettype($searchId)));
        }
    }

    /**
     * @return int
     */
    public function asInt()
    {
        return $this->searchId;
    }
}