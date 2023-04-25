<?php

namespace App\Entity;

use App\Interface\InstanceInterface;
use App\Repository\PokemonSpecieRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PokemonSpecieRepository::class)]
class PokemonSpecie implements InstanceInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank]
    private ?string $name;

    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank]
    private ?string $type;

    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank]
    private ?string $color;

    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank]
    private ?string $weight;

    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank]
    private ?string $shiny;

      #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank]
    private ?string $legendary;

    #[ORM\ManyToOne(inversedBy: 'pokemonSpecies')]
    private ?Dresseur $dresseur = null;

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
    /**
     * @return string|null
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @param string|null $color
     * @return PokemonSpecie
     */
    public function setColor(?string $color): PokemonSpecie
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getShiny(): ?string
    {
        return $this->shiny;
    }

    /**
     * @param string|null $shiny
     * @return PokemonSpecie
     */
    public function setShiny(?string $shiny): PokemonSpecie
    {
        $this->shiny = $shiny;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWeight(): ?string
    {
        return $this->weight;
    }

    /**
     * @param string|null $weight
     * @return PokemonSpecie
     */
    public function setWeight(?string $weight): PokemonSpecie
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLegendary(): ?string
    {
        return $this->legendary;
    }

    /**
     * @param string|null $legendary
     * @return PokemonSpecie
     */
    public function setLegendary(?string $legendary): PokemonSpecie
    {
        $this->legendary = $legendary;
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
           "persist" => $date_formatted . "Pokemon saisie : " . $this->name . " - Type : " . $this->type . "\n",
           "remove" => $date_formatted . "Pokemon supprimé : " . $this->name . " - Type : " . $this->type . "\n",
           "update" => $date_formatted . "Pokemon mis à jour : " . $this->name . " - Type : " . $this->type . "\n",
           default => "",
       };
   }



}
