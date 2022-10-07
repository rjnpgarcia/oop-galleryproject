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
}
