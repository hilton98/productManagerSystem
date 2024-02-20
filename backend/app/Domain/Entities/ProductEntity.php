<?php

namespace App\Domain\Entities;
use App\Domain\Entities\CategoryEntity;

class ProductEntity
{
    private $id;
    private $name;
    private $description;
    private $price;
    private $expiration_dt;
    private $image;
    private $category;
    private $created_at;
    private $updated_at;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getExpirationDt()
    {
        return $this->expiration_dt;
    }

    public function setExpirationDt($expiration_dt)
    {
        $this->expiration_dt = $expiration_dt;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(?CategoryEntity $category)
    {
        $this->category = $category;
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

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'expiration_dt' => $this->expiration_dt,
            'image' => $this->image,
            'category' => $this->category->toArray(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}


