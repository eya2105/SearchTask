<?php


namespace App\Service;

use PDO;
use App\Service\DatabaseConnection;
use Exception;
use PDOException;

class SearchService
{
    private $databaseConnection;

    public function __construct(DatabaseConnection $databaseConnection)
    {
        $this->databaseConnection = $databaseConnection;
    }

     /**
     * @throws Exception
     */
    public function searchMultipleEntities(string $dbName, array $tables, string $searchString): array
    {
        $connection = $this->databaseConnection->getConnection($dbName);

        $results = [];
        foreach ($tables as $table => $fields) {
            if (empty($table) || empty($fields)) {
                throw new Exception('Invalid table or fields provided.');
            }

            $query = "SELECT * FROM $table WHERE ";
            $conditions = [];
            foreach ($fields as $field) {
                $conditions[] = "$field LIKE :searchString";
            }
            $query .= implode(' OR ', $conditions);

            $stmt = $connection->prepare($query);
            $stmt->bindValue(':searchString', "%$searchString%");

            try {
                $stmt->execute();
                $results[$table] = $stmt->fetchAll();
            } catch (PDOException $e) {
                throw new Exception("Database query failed for table $table: " . $e->getMessage());
            }
        }

        return $results;
    }

    /**
     * @throws Exception
     */
    public function searchAllEntities(string $dbName, string $searchString): array
    {
        $tables = [
            'client' => ['firstname', 'lastname', 'email'],
            'product' => ['name', 'description', 'price', 'stock'],
            'facture' => ['description']
        ];

        return $this->searchMultipleEntities($dbName, $tables, $searchString);
    }
}