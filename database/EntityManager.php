<?php
declare(strict_types=1);
namespace project\database;

use mysqli;

class EntityManager
{
    private ?mysqli $connection = null; // Объект соединения
    private string $server;
    private string $user;
    private string $pass;
    private string $dbname;

    public function __construct(string $envFile)
    {

        $config = EnvConfigLoader::load($envFile);

        $this->server = $config['server'] ?? '';
        $this->user = $config['user'] ?? '';
        $this->pass = $config['pass'] ?? '';
        $this->dbname = $config['dbname'] ?? '';

        $this->openConnection();
    }

    private function openConnection(): void
    {

    }

    public function getConnection(): ?mysqli
    {
        return null;
    }

    public function close(): void
    {

    }
}