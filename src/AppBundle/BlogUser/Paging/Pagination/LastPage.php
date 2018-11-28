<?php


namespace AppBundle\BlogUser\Paging\Pagination;


use AppBundle\BlogUser\Paging\PaginationException;

class LastPage
{
    /**
     * @var int
     */
    private $lastPage;

    /**
     * LastPage constructor.
     * @param int $lastPage
     * @throws PaginationException
     */
    public function __construct($lastPage)
    {
        $this->ensureLastPageIsInt($lastPage);
        $this->lastPage = $lastPage;
    }

    /**
     * @param $lastPage
     * @throws PaginationException
     */
    private function ensureLastPageIsInt($lastPage)
    {
        if (!is_int($lastPage)) {
            throw new PaginationException(sprintf('$lastPage is not integer, given %s', gettype($lastPage)));
        }
    }

    public function asInt()
    {
        return $this->lastPage;
    }
}