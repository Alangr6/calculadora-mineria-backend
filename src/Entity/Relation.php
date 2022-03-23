<?php

namespace App\Entity;

use App\Repository\RelationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RelationRepository::class)
 */
class Relation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $mined;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $coin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMined(): ?int
    {
        return $this->mined;
    }

    public function setMined(?int $mined): self
    {
        $this->mined = $mined;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCoin(): ?string
    {
        return $this->coin;
    }

    public function setCoin(?string $coin): self
    {
        $this->coin = $coin;

        return $this;
    }
}
