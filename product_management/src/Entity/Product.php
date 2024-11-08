<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

class Product
{
    /**
     * @Groups({"product_read", "product_write"})
     */
    private int $id;

    /**
     * @Groups({"product_read", "product_write"})
     */
    private string $code;

    /**
     * @Groups({"product_read", "product_write"})
     */
    private string $name;

    /**
     * @Groups({"product_read", "product_write"})
     */
    private string $description;

    /**
     * @Groups({"product_read", "product_write"})
     */
    private string $image;

    /**
     * @Groups({"product_read", "product_write"})
     */
    private string $category;

    /**
     * @Groups({"product_read", "product_write"})
     */
    private float $price;

    /**
     * @Groups({"product_read", "product_write"})
     */
    private int $quantity;

    /**
     * @Groups({"product_read", "product_write"})
     */
    private string $internalReference;

    /**
     * @Groups({"product_read", "product_write"})
     */
    private int $shellId;

    /**
     * @Groups({"product_read", "product_write"})
     */
    private string $inventoryStatus;

    /**
     * @Groups({"product_read", "product_write"})
     */
    private float $rating;

    /**
     * @Groups({"product_read", "product_write"})
     */
    private \DateTime $createdAt;

    /**
     * @Groups({"product_read", "product_write"})
     */
    private \DateTime $updatedAt;

    // Getters et Setters pour chaque propriété

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getInternalReference(): string
    {
        return $this->internalReference;
    }

    public function setInternalReference(string $internalReference): self
    {
        $this->internalReference = $internalReference;
        return $this;
    }

    public function getShellId(): int
    {
        return $this->shellId;
    }

    public function setShellId(int $shellId): self
    {
        $this->shellId = $shellId;
        return $this;
    }

    public function getInventoryStatus(): string
    {
        return $this->inventoryStatus;
    }

    public function setInventoryStatus(string $inventoryStatus): self
    {
        $this->inventoryStatus = $inventoryStatus;
        return $this;
    }

    public function getRating(): float
    {
        return $this->rating;
    }

    public function setRating(float $rating): self
    {
        $this->rating = $rating;
        return $this;
    }

        public function setCreatedAt($createdAt): self
    {
        if (is_string($createdAt)) {
            $this->createdAt = \DateTime::createFromFormat('Y-m-d H:i:s', $createdAt);
        } else {
            $this->createdAt = $createdAt;
        }
        return $this;
    }

    public function setUpdatedAt($updatedAt): self
    {
        if (is_string($updatedAt)) {
            $this->updatedAt = \DateTime::createFromFormat('Y-m-d H:i:s', $updatedAt);
        } else {
            $this->updatedAt = $updatedAt;
        }
        return $this;
    }


    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }
}
