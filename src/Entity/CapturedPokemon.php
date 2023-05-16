<?php

namespace App\Entity;

use App\Interface\InstanceInterface;
use App\Repository\CapturedPokemonRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CapturedPokemonRepository::class)]
class CapturedPokemon implements InstanceInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $surname = null;

    #[ORM\ManyToOne(inversedBy: 'pokemons')]
    #[ORM\JoinColumn(nullable: false)]
    #[Ignore]
    private ?Dresseur $dresseur = null;

    #[ORM\ManyToOne(inversedBy: 'pokemons')]
    #[ORM\JoinColumn(nullable: false)]
    #[Ignore]
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

    public function __toString(): string
    {
        return $this->getPokemon();
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

//    #[SerializedName("dresseur_id")]
//    public function getDresseurId()
//    {
//        return $this->getDresseur()->getId();
//    }

    #[SerializedName("pokemon_id")]
    public function getPokemonId()
    {
        return $this->getPokemon()->getId();
    }

    /*
 * fonction issue d'InstanceInterface
 */
    public function describeLog($action): string
    {
        $date = new DateTime();
        $date_formatted = $date->format('Y-m-d H:i:s');

        return match ($action) {
            "persist" => $date_formatted . ' ' . $this->dresseur . " a capturé un " . $this->pokemon . " sauvage.\n",
            "update" => $date_formatted . ' ' . $this->dresseur . " a renomé son " . $this->pokemon . " : ' " . $this->surname . " '\n",
            "remove" => $date_formatted . ' ' . $this->dresseur . " a relaché son " . $this->pokemon . " dans la nature.\n",
            default => "",
        };
    }

}
