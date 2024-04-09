<?php
// Class to handle things to do with the database
// I followed the W3Schools tutorial (mostly) (https://www.w3schools.com/php/php_mysql_intro.asp)
class DB {
    private $conn;
    private $createEntryStatement;

    // Since this file will be require()'d in different subfolders,
    // We need to pass the path to config.ini because it could be
    // "../config.ini" or "config.ini"
    public function __construct() {
        $dbConfig = parse_ini_file(__DIR__ . "/../config.ini", true)["database"];
        $hostname = $dbConfig["hostname"];
        $user = $dbConfig["username"];
        $password = $dbConfig["password"];
        $dbName = $dbConfig["dbName"];
        try {
            $this->conn = new PDO("mysql:host=$hostname", $user, $password);

            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if the database already exists
            // (if we don't do this, there will be an error when we try to create a database)
            $statement = $this->conn->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbName'");
            if (!(bool) $statement->fetchColumn()) {
                // Create the database if it doesn't already exist
                $sql = "CREATE DATABASE $dbName";
                $this->conn->exec($sql);
            }

            $this->conn->exec("USE $dbName");

            $statement = $this->conn->query("SHOW TABLES LIKE 'AnimalEntries'");
            if (!(bool) $statement->fetchColumn()) {
                // Only create the table if it doesn't exist
                $sql = 'CREATE TABLE AnimalEntries (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    entry_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    animal VARCHAR(100) NOT NULL,
                    fact VARCHAR(4000) NOT NULL,
                    image_path VARCHAR(100) DEFAULT NULL
            )';
                $this->conn->exec($sql);
            }

            // This is more efficient for creating database entries
            // The '?'s will be replaced with variables when we execute the statement
            $this->createEntryStatement = $this->conn->prepare(
                'INSERT INTO AnimalEntries (animal, fact, image_path) VALUES (?, ?, ?)'
            );
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }

    public function getConn() {
        return $this->conn;
    }

    public function createEntry($animal, $fact, $imgPath = null) {
        try {
            $this->createEntryStatement->execute(array($animal, $fact, $imgPath));
        } catch (PDOException $e) {
            echo "$animal | $fact | $imgPath" . "<br>" . $e->getMessage() . "<br><br>";
            print_r($e->getTraceAsString());
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
