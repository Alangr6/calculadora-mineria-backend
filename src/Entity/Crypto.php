<?php

namespace App\Entity;

use App\Repository\CryptoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CryptoRepository::class)
 */
class Crypto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="date")
     */
    private $creation_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $algorithm;

    /**
     * @ORM\OneToMany(targetEntity=CryptoDevice::class, mappedBy="crypto")
     */
    private $cryptoDevices;

    public function __construct()
    {
        $this->cryptoDevices = new ArrayCollection();
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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreationDate()
    {
        return $this->creation_date;
    }

    public function setCreationDate( $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function getAlgorithm(): ?string
    {
        return $this->algorithm;
    }

    public function setAlgorithm(string $algorithm): self
    {
        $this->algorithm = $algorithm;

        return $this;
    }

    /**
     * @return Collection<int, CryptoDevice>
     */
    public function getCryptoDevices(): Collection
    {
        return $this->cryptoDevices;
    }

    public function addCryptoDevice(CryptoDevice $cryptoDevice): self
    {
        if (!$this->cryptoDevices->contains($cryptoDevice)) {
            $this->cryptoDevices[] = $cryptoDevice;
            $cryptoDevice->setCrypto($this);
        }

        return $this;
    }

    public function removeCryptoDevice(CryptoDevice $cryptoDevice): self
    {
        if ($this->cryptoDevices->removeElement($cryptoDevice)) {
            // set the owning side to null (unless already changed)
            if ($cryptoDevice->getCrypto() === $this) {
                $cryptoDevice->setCrypto(null);
            }
        }

        return $this;
    }

 
}
