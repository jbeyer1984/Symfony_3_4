<?php


namespace AppBundle\BlogUser\Paging\Pipe\NavigationViewInfo\NavigationLink;


use AppBundle\BlogUser\Paging\Pipe\NavigationViewInfoException;

class SearchId
{
    /**
     * @var int
     */
    private $pageId;

    /**
     * PageId constructor.
     * @param int $pageId
     * @throws NavigationViewInfoException
     */
    public function __construct($pageId)
    {
        $this->ensurePageIdIsInt($pageId);
        $this->pageId = $pageId;
    }

    /**
     * @param $pageId
     * @throws NavigationViewInfoException
     */
    private function ensurePageIdIsInt($pageId)
    {
        if (!is_int($pageId)) {
            throw new NavigationViewInfoException(sprintf('$pageId is not int, given %s', gettype($pageId)));
        }
    }

    /**
     * @return int
     */
    public function asInt()
    {
        return $this->pageId;
    }

}