<?php


namespace AppBundle\BlogUser\Paging\PaginationCondition;


use AppBundle\BlogUser\Paging\PaginationException;

class Chunk
{
    /**
     * @var int
     */
    private $chunk;

    /**
     * Chunk constructor.
     * @param int $chunk
     * @throws PaginationException
     */
    public function __construct($chunk)
    {
        $this->ensureChunkIsInt($chunk);
        $this->chunk = $chunk;
    }

    /**
     * @param $chunk
     * @throws PaginationException
     */
    private function ensureChunkIsInt($chunk)
    {
        if (!is_int($chunk)) {
            throw new PaginationException(sprintf('$chunk is not integer, given %s', gettype($chunk)));
        }
    }

    /**
     * @return int
     */
    public function asInt()
    {
        return $this->chunk;
    }

}