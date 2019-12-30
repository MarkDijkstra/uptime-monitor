<?php


/**
 * @return mixed
 */
class Connect extends PDO
{

    private $host     = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "site_monitor";

    public  $connection;

    /**
     * @return mixed
     */
    public function __construct()
    {

        return $this->connectToDatabase();

    }

    /**
     * @return void
     */
    public function connectToDatabase()
    {

        $this->connection = null;

        try {
            $opts = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);

            $this->connection = parent::__construct("mysql:host=".$this->host.";dbname=".$this->database,
                $this->username, $this->password , $opts);
        } catch(PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        }

        return $this->connection;

    }

}