<?php

namespace App\Pagination;

class Paginator
{
    private int $page;
    private $result;
    private int $count;
    private int $itemPerPage;
    private string $route;

    public function __construct(\Doctrine\ORM\Tools\Pagination\Paginator $paginator, string $route)
    {
        $this->itemPerPage = $paginator->getQuery()->getMaxResults();
        $this->page = (($paginator->getQuery()->getFirstResult()) + $this->itemPerPage) / $this->itemPerPage;
        $this->result = $paginator->getIterator();
        $this->count = $paginator->count();
        $this->route = $route;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }


    /**
     * @return int
     */
    public function getFirst(): int
    {
        return 1;
    }


    /**
     * @return int
     */
    public function getPrev(): int
    {
        if ($this->page > $this->getFirst()) {
            return $this->page - 1;
        } else {
            return $this->getFirst();
        }
    }


    /**
     * @return int
     */
    public function getNext(): int
    {
        if ($this->page < $this->getLast()) {
            return $this->page + 1;
        } else {
            return $this->getLast();
        }
    }


    /**
     * @return int
     */
    public function getLast(): int
    {
        return ceil($this->count / $this->itemPerPage);
    }


    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getResult()
    {
        return $this->result;
    }


    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }
}