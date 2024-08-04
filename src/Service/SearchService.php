<?php


namespace App\Service;

use PDO;

class SearchService
{
    private $databaseConnection;

    public function __construct(DatabaseConnection $databaseConnection)
    {
        $this->databaseConnection = $databaseConnection;
    }

    public function searchEntities(string $dbName, string $entity, array $fields, string $searchString): array
    {

        // Construct SQL query based on parameters
        $connection = $this->databaseConnection->getConnection($dbName);

        // Example SQL query (adjust as needed)
        $query = "SELECT * FROM $entity WHERE ";
        $conditions = [];
        foreach ($fields as $field) {
            $conditions[] = "$field LIKE :searchString";
        }
        $query .= implode(' OR ', $conditions);

        $stmt = $connection->prepare($query);
        $stmt->bindValue(':searchString', "%$searchString%");
        $stmt->execute();

        return $stmt->fetchAll();
    }
}