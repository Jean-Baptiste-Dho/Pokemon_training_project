<?php

namespace App\Trait;

use Doctrine\ORM\Mapping as ORM;

trait Timestampable
{

    #[ORM\Column]
    public \DateTime $createdAt;
    #[ORM\Column]
    public \DateTime $updatedAt;

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}