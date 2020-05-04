<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StorageProductRepository")
 * @ORM\Table(name="storage_product")
 */
class StorageProduct
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected  $id;

    /**
     * @var Storage
     * 
     * @ORM\ManyToOne(targetEntity="Storage", inversedBy="storageProducts")
     * @ORM\JoinColumn(name="storage_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $storage;
    
    /**
     * @var Product
     * 
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="storageProducts")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $product;

     /**
     * @ORM\Column(type="integer")
     */
    private $count;

    public function __construct()
    {
        $this->count = 0;
        $this->storage = new Storage();
        $this->product = new Product();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

     /**
     * @param Storage $storage
     */
    public function setStorage(Storage $storage): self
    {
        $this->storage = $storage;

        return $this;
    }

    /**
     * @return Storage
     */
    public function getStorage(): Storage
    {
        return $this->storage;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param int $count
     *
     * @return self
     */
    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

}
