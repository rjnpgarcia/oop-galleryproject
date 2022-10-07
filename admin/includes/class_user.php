<?php

class User
{
    // Read Query
    public static function findThisQuery($sql)
    {
        global $database;
        $result = $database->query($sql);
        return $result;
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
        $result = mysqli_fetch_array($foundUser);
        return $result;
    }
}
