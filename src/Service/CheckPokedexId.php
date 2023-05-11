<?php

namespace App\Service;

use App\Repository\PokemonRepository;

class CheckPokedexId
{
    private PokemonRepository $repository;

    public function __construct(PokemonRepository $repository)
    {
        $this->repository = $repository;
    }

    public function checkId($id): bool
    {
        if ($this->repository->findByPokedexId($id)) {
            return true;
        }

        return false;
    }

}