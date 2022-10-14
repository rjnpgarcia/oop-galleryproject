<?php

class User extends Db_object
{
    // Properties
    protected static $db_table = "users";
    protected static $db_table_fields = ['username', 'password', 'firstname', 'lastname'];
    public $id;
    public $username;
    public $password;
    public $firstname;
    public $lastname;


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
} //End of USER Class
$user = new User();
