<?php
declare(strict_types=1);
namespace project\repositories;
use mysqli;
use project\app\Models\Animal;
use project\database\EntityManager;

class AnimalRepository
{
    private EntityManager $entityManager;
    private ?mysqli $connection;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->connection = $this->entityManager->getConnection();
    }

    public function find(string $id): ?Animal
    {


        return null;
    }

    public function insert(array $data): void
    {

    }

    public function update(string $id, array $data): void
    {

    }

    public function delete(string $id): void
    {

    }

    public function __destruct()
    {

    }
}