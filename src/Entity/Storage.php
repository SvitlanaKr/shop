<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\StorageProduct;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StorageRepository")
 */
class Storage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress;

    /**
     * @var Collection
     * 
     * @ORM\OneToMany(targetEntity="StorageProduct", mappedBy="storage_id")
     */
    protected $storageProducts;

    public function __construct()
    {
        $this->storageProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|StorageProduct[]
     */
    public function getStorageProducts(): Collection
    {
        return $this->storageProducts;
    }

    public function addStorageProduct(StorageProduct $storageProduct): self
    {
        if (!$this->storageProducts->contains($storageProduct)) {
            $this->storageProducts[] = $storageProduct;
        }

        return $this;
    }

    public function removeStorageProduct(StorageProduct $storageProduct): self
    {
        if ($this->storageProducts->contains($storageProduct)) {
            $this->storageProducts->removeElement($storageProduct);
        }

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
