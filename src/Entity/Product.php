<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $model;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $producer;

    /**
     * @var Collection
     * 
     * @ORM\OneToMany(targetEntity="StorageProduct", mappedBy="product_id")
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getModel(): ?int
    {
        return $this->model;
    }

    public function setModel(?int $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getProducer(): ?int
    {
        return $this->producer;
    }

    public function setProducer(?int $producer): self
    {
        $this->producer = $producer;

        return $this;
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

    public function __toString()
    {
        return $this->name;
    }
}
