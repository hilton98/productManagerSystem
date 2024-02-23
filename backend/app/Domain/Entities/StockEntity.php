<?php

namespace App\Domain\Entities;
use App\Domain\Entities\ProductsEntity;

class StockEntity
{
    private $user;
    private $products;
    private $created_at;
    private $updated_at;

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function setProducts(array $products)
    {
        $this->products = $products;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public function toArray(): array
    {
        return [
            'user' => $this->getUser(),
            'products' => $this->getProducts(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
