<?php

namespace App\Entity;

use App\Repository\TradeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: TradeRepository::class)]
class Trade
{
    const PENDING = 'pending';
    const REFUSED = 'refused';
    const ACCEPTED = 'accepted';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;


    #[ORM\Column(length: 255)]
    private string $status;

    #[ORM\ManyToOne]
    #[Assert\NotBlank(message: "Obligatoire", groups: ["Creation"])]
    private ?Pokemon $pokemon = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CapturedPokemon $capturedPokemonSeller = null;

    #[ORM\ManyToOne]
    private ?CapturedPokemon $capturedPokemonBuyer = null;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
        $this->status = self::PENDING;
        $this->dresseur = new ArrayCollection();
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

    public function getCapturedPokemonSeller(): ?CapturedPokemon
    {
        return $this->capturedPokemonSeller;
    }

    public function setCapturedPokemonSeller(?CapturedPokemon $capturedPokemonSeller): self
    {
        $this->capturedPokemonSeller = $capturedPokemonSeller;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCapturedPokemonBuyer(): ?CapturedPokemon
    {
        return $this->capturedPokemonBuyer;
    }

    public function setCapturedPokemonBuyer(?CapturedPokemon $capturedPokemonBuyer): self
    {
        $this->capturedPokemonBuyer = $capturedPokemonBuyer;

        return $this;
    }

    /*****************************************
     * Helpers *******************************
     *****************************************/

    public function isAccepted(): bool
    {
        return $this->getStatus() === self::ACCEPTED;
    }

    public function isRefused(): bool
    {
        return $this->getStatus() === self::REFUSED;
    }

    public function isPending(): bool
    {
        return $this->getStatus() === self::PENDING;
    }

    public function getSeller(): ?Dresseur
    {
        return $this->getCapturedPokemonSeller()?->getDresseur();
    }

    public function getBuyer(): ?Dresseur
    {
        return $this->getCapturedPokemonBuyer()?->getDresseur();
    }

    /*****************************************
     * Validation ****************************
     *****************************************/

    #[Assert\Callback(groups: ['Creation', 'Finalisation'])]
    public function validate(ExecutionContextInterface $context, $payload)
    {
        // on compare
        if ($this->isAccepted() && $this->getPokemon()->getId() !== $this->getCapturedPokemonBuyer()?->getPokemon()->getId()) {
            $context->buildViolation('Le pokémon ne correspond pas au type demandé!')
                ->atPath('capturedPokemonBuyer')
                ->addViolation();
        }
        if ($this->isPending() && $this->getCapturedPokemonBuyer() && $this->getPokemon()->getId() !== $this->getCapturedPokemonBuyer()->getPokemon()->getId()) {
            $context->buildViolation('Le pokémon ne correspond pas au type demandé!')
                ->atPath('capturedPokemonBuyer')
                ->addViolation();
        }
    }
}
