<?php

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $pokedexId = null;

    #[ORM\OneToMany(mappedBy: 'pokemon', targetEntity: CapturedPokemon::class, orphanRemoval: true)]
    private Collection $pokemons;

    #[ORM\Column(length: 255)]
    private ?string $legendary = null;

    #[ORM\Column(length: 255)]
    private ?string $shape = null;

    #[ORM\Column(length: 255)]
    private ?string $color = null;

    public function __construct()
    {
        $this->pokemons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPokedexId(): ?int
    {
        return $this->pokedexId;
    }

    public function setPokedexId(int $pokedexId): self
    {
        $this->pokedexId = $pokedexId;

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

    public function getLegendary(): ?string
    {
        return $this->legendary;
    }

    public function setLegendary(string $legendary): self
    {
        $this->legendary = $legendary;

        return $this;
    }

    public function getShape(): ?string
    {
        return $this->shape;
    }

    public function setShape(string $shape): self
    {
        $this->shape = $shape;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
