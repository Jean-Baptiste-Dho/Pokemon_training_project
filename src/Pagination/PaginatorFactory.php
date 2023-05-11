<?php

namespace App\Pagination;

class PaginatorFactory
{
    public function create(\Doctrine\ORM\Tools\Pagination\Paginator $paginator, string $route): Paginator
    {
        return new Paginator($paginator, $route);

    }
}