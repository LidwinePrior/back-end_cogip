<?php

namespace App\Queries;

use PDO;
use PDOException;

class Database
{
    private static $instance;
    private $connection;

    private function __construct()
    {
        $host = $_ENV["HOST"] ?? null;
        $dbname = $_ENV["DBNAME"] ?? null;
        $user = $_ENV["USER"] ?? null;
        $password = $_ENV["PASSWORD"] ?? null;

        try 
        {
            $this->connection = new PDO("mysql://$user:$password@$host/$dbname;charset=utf8", $user, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) 
        {
            // Gérer les erreurs de connexion ici
            die('Erreur : ' . $e->getMessage());
        }

    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }

}
     