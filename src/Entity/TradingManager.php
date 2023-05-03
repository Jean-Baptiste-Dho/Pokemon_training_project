<?php

namespace App\Entity;

use App\Repository\TradingManagerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TradingManagerRepository::class)]
class TradingManager
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;


    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\ManyToOne]
    private ?Pokemon $pokemon = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CapturedPokemon $capturedPokemonSeller = null;

    #[ORM\ManyToOne]
    private ?CapturedPokemon $capturedPokemonBuyer = null;

    public function __construct()
    {
        $this->dresseur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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

    public function getCapturedPokemonSeller(): ?CapturedPokemon
    {
        return $this->capturedPokemonSeller;
    }

    public function setCapturedPokemonSeller(?CapturedPokemon $capturedPokemonSeller): self
    {
        $this->capturedPokemonSeller = $capturedPokemonSeller;

        return $this;
    }

    public function getCapturedPokemonBuyer(): ?CapturedPokemon
    {
        return $this->capturedPokemonBuyer;
    }

    public function setCapturedPokemonBuyer(?CapturedPokemon $capturedPokemonBuyer): self
    {
        $this->capturedPokemonBuyer = $capturedPokemonBuyer;

        return $this;
    }
}
