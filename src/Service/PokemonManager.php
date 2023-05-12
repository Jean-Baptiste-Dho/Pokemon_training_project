<?php

namespace App\Service;

use App\Entity\Pokemon;
use App\Repository\PokemonRepository;

class PokemonManager
{
    private PokemonRepository $repository;

    public function __construct(PokemonRepository $repository)
    {
        $this->repository = $repository;
    }

//    public function checkId($id): bool
//    {
//        if ($this->repository->findByPokedexId($id)) {
//            return true;
//        }
//
//        return false;
//    }

    public function assignNumber(Pokemon $pokemon)
    {
        $lastNumber = $this->repository->findLastNumber();

        $pokemon->setPokedexId($lastNumber + 1);
    }

}