<?php
// Class to handle things to do with the database
// I followed the W3Schools tutorial (mostly) (https://www.w3schools.com/php/php_mysql_intro.asp)
class DB {
    private $conn;
    private $createEntryStatement;
    private $getCreatedEntryStatement;

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

            // Preparing statements is more efficient for creating many database entries
            // It is also safer as it sanitizes entries
            // The '?'s will be replaced with variables when we execute the statement
            $this->createEntryStatement = $this->conn->prepare(
                'INSERT INTO AnimalEntries (animal, fact, image_path) VALUES (?, ?, ?)'
            );

            // Get the last entry
            $this->getCreatedEntryStatement = $this->conn->prepare(
                'SELECT * FROM AnimalEntries
                ORDER BY id DESC
                LIMIT 1'
            );
            $this->populateEntries();
        } catch (PDOException $e) {
            echo $sql . "<br>1<br>" . $e->getMessage() . "<br>" . $e->getTraceAsString();

?>
            <p><br>Looks like there is a database error.
                Try going to the version on <a href="https://replit.com/@cosmic-sunburst/glowing-potato">replit</a></p>
<?php

        }
    }

    public function getConn() {
        return $this->conn;
    }

    public function createEntry($animal, $fact, $imgPath = null) {
        try {
            $this->createEntryStatement->execute(array($animal, $fact, $imgPath));

            $this->getCreatedEntryStatement->execute();
            return $this->getCreatedEntryStatement->fetch();
        } catch (PDOException $e) {
            echo "$animal | $fact | $imgPath" . "<br>" . $e->getMessage() . "<br><br>";
            print_r($e->getTraceAsString());
        }
    }

    public function getEntries() {
        return $this->conn->query("SELECT * FROM AnimalEntries");
    }

    public function getRandomEntry() {
        $statement =  $this->conn->query("SELECT * FROM AnimalEntries ORDER BY RAND() LIMIT 1");
        return $statement->fetch();
    }

    public function getNextID() {
        // Get the value that will next be auto incremented 
        $sql = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE (TABLE_NAME = 'AnimalEntries')";

        $statement = $this->conn->query($sql);
        return $statement->fetchColumn();
    }

    // So that there isn't a blank sheet of entries on startup
    function populateEntries() {
        if (empty($this->getEntries())) {
            return;
        }

        $this->createEntry(
            "Polar bear",
            "The polar bear is the largest bear species. It can weigh up to 1500 pounds and can be almost 10 feet long",
            "images/submissions/polar_bear.jpg"
        );
        $this->createEntry(
            "Bat",
            "There are over 1400 species of bats",
            "images/submissions/fruit_bat.jpg"
        );
        $this->createEntry(
            "I don't know",
            "    This is just to showcase that html characters will be converted and extra spaces on the ends will be removed.            ",
            ""
        );
    }
}
