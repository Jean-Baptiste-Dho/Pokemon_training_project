<?php

namespace App\Entity;

use App\Repository\PokemonsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonsRepository::class)]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $poke_name = null;

    #[ORM\Column]
    private ?int $pokedex_id = null;

    #[ORM\OneToMany(mappedBy: 'pokemon', targetEntity: CapturedPokemon::class, orphanRemoval: true)]
    private Collection $pokemons;

    public function __construct()
    {
        $this->pokemons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPokeName(): ?string
    {
        return $this->poke_name;
    }

    public function setPokeName(string $poke_name): self
    {
        $this->poke_name = $poke_name;

        return $this;
    }

    public function getPokedexId(): ?int
    {
        return $this->pokedex_id;
    }

    public function setPokedexId(int $pokedex_id): self
    {
        $this->pokedex_id = $pokedex_id;

        return $this;
    }

    /**
     * @return Collection<int, CapturedPokemon>
     */
    public function getPokemons(): Collection
    {
        return $this->pokemons;
    }

    public function addPokemon(CapturedPokemon $pokemon): self
    {
        if (!$this->pokemons->contains($pokemon)) {
            $this->pokemons->add($pokemon);
            $pokemon->setPokemon($this);
        }

        return $this;
    }

    public function removePokemon(CapturedPokemon $pokemon): self
    {
        if ($this->pokemons->removeElement($pokemon)) {
            // set the owning side to null (unless already changed)
            if ($pokemon->getPokemon() === $this) {
                $pokemon->setPokemon(null);
            }
        }

        return $this;
    }
}
