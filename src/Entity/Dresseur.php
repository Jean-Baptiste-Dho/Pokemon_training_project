<?php

namespace App\Entity;

use App\Interface\InstanceInterface;
use App\Interface\Timestampable;
use App\Repository\DresseurRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DresseurRepository::class)]
#[ORM\Table(name: '`dresseur`')]
class Dresseur implements InstanceInterface
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $dresseurname = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'dresseur', targetEntity: PokemonSpecie::class)]
    private Collection $pokemonSpecies;

    #[ORM\OneToMany(mappedBy: 'dresseur', targetEntity: CapturedPokemon::class, orphanRemoval: true)]
    private Collection $pokemons;

    public function __toString(): string
    {
        return $this->dresseurname;
    }

    public function __construct()
    {
        $this->pokemonSpecies = new ArrayCollection();
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        $this->capturedPokemon = new ArrayCollection();
        $this->pokemons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDresseurname(): ?string
    {
        return $this->dresseurname;
    }

    public function setDresseurname(string $dresseurname): self
    {
        $this->dresseurname = $dresseurname;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection<int, PokemonSpecie>
     */
    public function getPokemonSpecies(): Collection
    {
        return $this->pokemonSpecies;
    }

    public function addPokemonSpecies(PokemonSpecie $pokemonSpecies): self
    {
        if (!$this->pokemonSpecies->contains($pokemonSpecies)) {
            $this->pokemonSpecies->add($pokemonSpecies);
            $pokemonSpecies->setDresseurId($this);
        }

        return $this;
    }

    public function removePokemonSpecies(PokemonSpecie $pokemonSpecies): self
    {
        if ($this->pokemonSpecies->removeElement($pokemonSpecies)) {
            // set the owning side to null (unless already changed)
            if ($pokemonSpecies->getDresseurId() === $this) {
                $pokemonSpecies->setDresseurId(null);
            }
        }

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
            $pokemon->setDresseur($this);
        }

        return $this;
    }

    public function removePokemon(CapturedPokemon $pokemon): self
    {
        if ($this->pokemons->removeElement($pokemon)) {
            // set the owning side to null (unless already changed)
            if ($pokemon->getDresseur() === $this) {
                $pokemon->setDresseur(null);
            }
        }

        return $this;
    }

    /*
     * fonction issue d'InstanceInterface
     */
    public function describeLog($action): string
    {
        $date = new DateTime();
        $date_formatted = $date->format('Y-m-d H:i:s');

        return match ($action) {
            "persist" => $date_formatted . " Dresseur saisie : " . $this->dresseurname . " - Password : " . $this->password . "\n",
            "update" => $date_formatted . " Dresseur mis à jour : " . $this->dresseurname . " - Password : " . $this->password . "\n",
            "remove" => $date_formatted . " Dresseur supprimé : " . $this->dresseurname . " - Password : " . $this->password . " -!! Tous les pokémons liés à ce dresseur ont également été supprimé-\n",
            default => "",
        };
    }
}

