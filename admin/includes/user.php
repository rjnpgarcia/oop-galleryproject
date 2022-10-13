<?php

class User
{
    // Properties
    protected static $db_table = "users";
    protected static $db_table_fields = ['username', 'password', 'firstname', 'lastname'];
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

    // Get Table Properties
    public function properties()
    {
        $properties = [];
        foreach (self::$db_table_fields as $db_field) {
            if (property_exists($this, $db_field)) {
                $properties[$db_field] = $this->$db_field;
            }
        }
        return $properties;
    }

    //  CREATE
    public function create()
    {
        global $database;
        $properties = $this->properties();
        $columns = implode(",", array_keys($properties));
        $values = implode("','", array_values($properties));
        $table = self::$db_table;
        $sql = "INSERT INTO $table ($columns) VALUES ('$values')";

        if ($database->query($sql)) {
            $this->id = $database->insertId();
            return true;
        } else {
            return false;
        }
    }

    // UPDATE
    public function update()
    {
        global $database;
        $properties = $this->properties();
        $propertyPair = [];
        foreach ($properties as $key => $values) {
            $propertyPair[] = "$key = '$values'";
        }

        $updateSetValues = implode(", ", $propertyPair);
        $sql = "UPDATE users SET $updateSetValues WHERE id=$this->id";

        $database->query($sql);
        return mysqli_affected_rows($database->connection) === 1 ? true : false;
    }

    //  DELETE
    public function delete()
    {
        global $database;
        $user_id = $database->escape($this->id);
        $table = self::$db_table;
        $sql = "DELETE FROM $table WHERE id=$user_id LIMIT 1";
        $database->query($sql);
        return mysqli_affected_rows($database->connection) === 1 ? true : false;
    }

    // Abstaction for Create/Update Method
    public function save()
    {
        return isset($this->id) ? $this->update() : $this->create();
    }
} //End of USER Class
$user = new User();
