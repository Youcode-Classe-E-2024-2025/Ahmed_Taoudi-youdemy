<?php
require_once  "env/configDB.php";
define('HOST', $host);
define('PORT', $port);
define('DBNAME', $dbname);
define('USER', $user);
define('PASSWORD', $password);

// dd($dsn);
class Database
{
    public $connection;
    private  $dsn;
    private static $instance = null; 


    private function __construct()
    {
        $this->dsn = "mysql:host=" . HOST . ";port=" . PORT . ";dbname=" . DBNAME;

        try {

            $this->connection = new PDO($this->dsn, USER, PASSWORD);

            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {

            if ($e->getCode() == 1049) {
                // require_once("views/support/createDB.php"); 
                header('location: app/views/support/createDB.php');
                exit;
            } else {
                // Log the error instead of displaying it
                error_log("Database Connection Error: " . $e->getMessage());
            }
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function lastInsertId()
    {
        return $this->connection->lastInsertId();
    }

    public function query($query, $param = [])
    {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($param);
            return $statement;
        } catch (PDOException $e) {
            error_log("Query failed: " . $e->getMessage());
            return false; // or return null;
        }
    }
    public function pagination($query, $params = [], $limit = 0, $offset = 0)
    {
        try {

            if ($limit > 0) {
                $query .= " LIMIT :limit OFFSET :offset";
                $params['limit'] = (int)$limit;
                $params['offset'] = (int)$offset;
            }
            // Prepare the statement
            $statement = $this->connection->prepare($query);

            foreach ($params as $key => $value) {

                $statement->bindValue("$key", $value, $this->getParamType($value));
            }

            $statement->execute();
            return $statement;
        } catch (PDOException $e) {
            error_log("Query failed: " . $e->getMessage());
            return false;
        }
    }


    public function test()
    {
        echo ("in database class");
    }

    public static function createDatabase($dbname, $isfakedata = false)
    {
        try {

            $createdb = "assets/sql/create_database.sql";
            $fakedata = "assets/sql/fakedata.sql";

            if (!file_exists($createdb)) {
                echo "SQL file not found.";
                return;
            }

            $dsn = "mysql:host=" . HOST . ";port=" . PORT;
            $connection = new PDO($dsn, USER, PASSWORD);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            $query = file_get_contents($createdb);
            $connection->exec($query);
            echo "Database '$dbname' created successfully.";
            if ($isfakedata === true) {
                $query = file_get_contents($fakedata);
                $connection->exec($query);
                echo "fake data success.";
            }
            header("Location: /");
        } catch (PDOException $e) {
            echo "Error creating database: " . $e->getMessage();
        }
    }
    // Helper method to determine the PDO type of the parameter
    private function getParamType($value)
    {
        if (is_int($value)) {
            return PDO::PARAM_INT;
        } elseif (is_bool($value)) {
            return PDO::PARAM_BOOL;
        } else {
            return PDO::PARAM_STR;
        }
    }
}
