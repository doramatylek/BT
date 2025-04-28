<?php
declare(strict_types=1);
namespace project\app\Models;

class Animal
{
    private string $id;
    private string $name;
    private string $age;
    private string $type;
    private string $description;
    private string $image;

    public function __construct(string $id, string $name, string $age, string $type, string $description, string $image)
    {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
        $this->type = $type;
        $this->description = $description;
        $this->image = $image;
    }

    // Геттеры
    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAge(): string
    {
        return $this->age;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImage(): string
    {
        return $this->image;
    }
}