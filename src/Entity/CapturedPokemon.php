<?php

namespace App\Entity;

use App\Repository\CapturedPokemonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CapturedPokemonRepository::class)]
class CapturedPokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $surname = null;

    #[ORM\ManyToOne(inversedBy: 'pokemons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Dresseur $dresseur = null;

    #[ORM\ManyToOne(inversedBy: 'pokemons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pokemon $pokemon = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getDresseur(): ?Dresseur
    {
        return $this->dresseur;
    }

    public function setDresseur(?Dresseur $dresseur): self
    {
        $this->dresseur = $dresseur;

        return $this;
    }

    public function getPokemon(): ?Pokemon
    {
        return $this->pokemon;
    }

    public function setPokemon(?Pokemon $pokemon): self
    {
        $this->pokemon = $pokemon;

        return $this;
    }
}
