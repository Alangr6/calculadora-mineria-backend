<?php

namespace App\Entity;

use App\Repository\DeviceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeviceRepository::class)
 */
class Device
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
    private $type;

     /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $comsumption;

    /**
     * @ORM\Column(type="integer")
     */
    private $hashrate;

    /**
     * @ORM\OneToMany(targetEntity=CryptoDevice::class, mappedBy="device")
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
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

    public function getComsumption(): ?int
    {
        return $this->comsumption;
    }

    public function setComsumption(int $comsumption): self
    {
        $this->comsumption = $comsumption;

        return $this;
    }

    public function getHashrate(): ?int
    {
        return $this->hashrate;
    }

    public function setHashrate(int $hashrate): self
    {
        $this->hashrate = $hashrate;

        return $this;
    }

    /**
     * @return Collection<int, CryptoDevice>
     */
    public function getDevice(): Collection
    {
        return $this->device;
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
            $cryptoDevice->setDevice($this);
        }

        return $this;
    }

    public function removeCryptoDevice(CryptoDevice $cryptoDevice): self
    {
        if ($this->cryptoDevices->removeElement($cryptoDevice)) {
            // set the owning side to null (unless already changed)
            if ($cryptoDevice->getDevice() === $this) {
                $cryptoDevice->setDevice(null);
            }
        }

        return $this;
    }

  

 

}
