<?php

// src/Service/DatabaseConnection.php
namespace App\Service;

use PDO;
use PDOException;
use App\Exception\AccessDeniedException;

class DatabaseConnection
{
    private $host;
    private $user;
    private $password;

    public function __construct()
    {
        $this->host = $_ENV['DATABASE_HOST'];
        $this->user = $_ENV['DATABASE_USER'];
        $this->password = $_ENV['DATABASE_PASSWORD'];
    }

    private function connect(string $db): PDO
    {
        $dsn = "mysql:host={$this->host};port=3306;dbname={$db};";

        try {
            return new PDO($dsn, $this->user, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
        } catch (PDOException $e) {
            throw new AccessDeniedException($e->getMessage());
        }
    }

    public function getConnection(string $databaseName): PDO
    {
        return $this->connect($databaseName);
    }
}
