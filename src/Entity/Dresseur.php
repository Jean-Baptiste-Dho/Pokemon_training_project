<?php

namespace App\Entity;

use App\Interface\InstanceInterface;
use App\Repository\DresseurRepository;
use App\Trait\Timestampable;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: DresseurRepository::class)]
#[ORM\Table(name: '`dresseur`')]
class Dresseur implements InstanceInterface, UserInterface, PasswordAuthenticatedUserInterface
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'dresseur', targetEntity: CapturedPokemon::class, orphanRemoval: true)]
    private Collection $pokemons;

    #[ORM\Column]
    private array $roles = [];

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        $this->capturedPokemon = new ArrayCollection();
        $this->pokemons = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return Dresseur
     */
    public function setEmail(?string $email): Dresseur
    {
        $this->email = $email;
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
            "persist" => $date_formatted . " Dresseur saisie : " . $this->name . " - Password : " . $this->password . "\n",
            "update" => $date_formatted . " Dresseur mis à jour : " . $this->name . " - Password : " . $this->password . "\n",
            "remove" => $date_formatted . " Dresseur supprimé : " . $this->name . " - Password : " . $this->password . " -!! Tous les pokémons liés à ce dresseur ont également été supprimé-\n",
            default => "",
        };
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}

