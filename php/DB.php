<?php
// Class to handle things to do with the database
// I followed the W3Schools tutorial (mostly) (https://www.w3schools.com/php/php_mysql_intro.asp)
class DB {
    private $conn;

    public function __construct() {
        $dbConfig = parse_ini_file("config.ini", true)["database"];
        $hostname = $dbConfig["hostname"];
        $user = $dbConfig["user"];
        $password = $dbConfig["password"];
        $dbName = $dbConfig["dbName"];
        try {
            // This is not production safe, but it's fine for this
            $this->conn = new PDO("mysql:host=$hostname", $user, $password);

            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if the database already exists
            // (if we don't do this, there will be an error when we try to create a database)
            $statement = $this->conn->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = $dbName");
            if (!(bool) $statement->fetchColumn()) {
                // Create the database if it doesn't already exist
                $sql = "CREATE DATABASE $dbName";
                $this->conn->exec($sql);
            }

            $this->conn->exec("USE $dbName");

            $statement = $this->conn->query("SHOW TABLES LIKE 'AnimalEntries'");
            if (!(bool) $statement->fetchColumn()) {
                // Only create the table if it doesn't exist
                $sql = "CREATE TABLE AnimalEntries (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    entry_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    animal VARCHAR(50) NOT NULL,
                    fact VARCHAR(2000) NOT NULL,
                    image_path VARCHAR(100) DEFAULT NULL
            )";
                $this->conn->exec($sql);
            }
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }

    public function getConn() {
        return $this->conn;
    }

    public function createEntry($animal, $fact, $path = null) {
        if ($path === null) {
            $sql = "INSERT INTO AnimalEntries (animal, fact)
            VALUES ('$animal', '$fact')";
        } else {
            $sql = "INSERT INTO AnimalEntries (animal, fact, image_path)
            VALUES ('$animal', '$fact', '$path')";
        }
        try {
            $this->conn->exec($sql);
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }

    public function getEntries() {
        return $this->conn->query("SELECT * FROM AnimalEntries");
    }

    public function getNextID() {
        // Get the value that will next be auto incremented 
        $sql = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE (TABLE_NAME = 'AnimalEntries')";
        
        $statement = $this->conn->query($sql);
        return $statement->fetchColumn();
    }
}
