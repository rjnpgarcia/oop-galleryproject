<?php
require_once("config.php");

class Database
{
    public $connection;

    function __construct()
    {
        $this->openDbConnection();
    }

    // Database Connection
    public function openDbConnection()
    {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->connection->connect_errno) {
            die("Database connection failed" . mysqli_error($this->connection));
        }
    }

    // for Query
    public function query($sql)
    {
        $result = $this->connection->query($sql);
        $this->confirmQuery($result);
        return $result;
    }

    // To check Query connection
    private function confirmQuery($result)
    {
        if (!$result) {
            die("Query Failed");
        }
    }

    // String escape protection
    public function escape($string)
    {
        return $this->connection->real_escape_string($string);
    }

    // To pull new created user id
    public function insertId()
    {
        return mysqli_insert_id($this->connection);
    }
}

$database = new Database();
