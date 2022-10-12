<?php

class User
{
    // Properties
    public $id;
    public $username;
    public $password;
    public $firstname;
    public $lastname;

    // Read Query
    public static function findThisQuery($sql)
    {
        global $database;
        $result = $database->query($sql);
        $objectArray = [];
        while ($row = mysqli_fetch_array($result)) {
            $objectArray[] = self::instantiation($row);
        }
        return $objectArray;
    }

    // to check if the attribute in table exists
    private function checkAttribute($attribute)
    {
        $objectProperties = get_object_vars($this);
        return array_key_exists($attribute, $objectProperties);
    }

    // for instantiation - will return each attribute to object
    public static function instantiation($record)
    {
        $object = new self;
        foreach ($record as $attribute => $value) {
            if ($object->checkAttribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }

    // Read ALL user columns
    public static function findAllUsers()
    {
        return self::findThisQuery("SELECT * FROM users");
    }

    // Read User by ID
    public static function findUserById($user_id)
    {
        $foundUser = self::findThisQuery("SELECT * FROM users WHERE id=$user_id LIMIT 1");
        return $foundUser[0];
        // OR
        // return !empty($foundUser) ? array_shift($foundUser) : false;
    }

    // To verify user by username and password
    public static function verify_user($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password' LIMIT 1";
        $foundUser = self::findThisQuery($sql);
        return !empty($foundUser) ? array_shift($foundUser) : false;
    }

    //  CREATE User
    public function createUser()
    {
        global $database;
        $username = $database->escape($this->username);
        $password = $database->escape($this->password);
        $firstname = $database->escape($this->firstname);
        $lastname = $database->escape($this->lastname);
        $sql = "INSERT INTO users (username, password, firstname, lastname) VALUES ('$username', '$password', '$firstname', '$lastname')";

        if ($database->query($sql)) {
            $this->id = $database->insertId();
            return true;
        } else {
            return false;
        }
    }

    // UPDATE User
    public function updateUser()
    {
        global $database;
        $username = $database->escape($this->username);
        $password = $database->escape($this->password);
        $firstname = $database->escape($this->firstname);
        $lastname = $database->escape($this->lastname);
        $user_id = $database->escape($this->id);

        $sql = "UPDATE users SET username = '$username', password = '$password', firstname = '$firstname', lastname = '$lastname' WHERE id = $user_id";
        $database->query($sql);

        return mysqli_affected_rows($database->connection) === 1 ? true : false;
    }
} //End of USER Class
$user = new User();
