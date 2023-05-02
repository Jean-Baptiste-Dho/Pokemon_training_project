<?php

namespace App\Trait;

use App\Entity\Dresseur;

trait DresseurTrait
{
    private function getDresseur(): Dresseur
    {
        return $this->getUser();
    }
}