<?php

class User extends Db_object
{
    // Properties
    protected static $db_table = "users";
    protected static $db_table_fields = ['username', 'password', 'firstname', 'lastname', 'user_image'];
    public $id;
    public $username;
    public $password;
    public $firstname;
    public $lastname;
    public $user_image;
    public $upload_directory = "images";
    public $image_placeholder = "placeholder/placeholder1.png";
    // To verify user by username and password
    public static function verify_user($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password' LIMIT 1";
        $foundUser = self::findThisQuery($sql);
        return !empty($foundUser) ? array_shift($foundUser) : false;
    }

    // Image path
    public function imagePath()
    {
        $placeholder = $this->upload_directory . DS . $this->image_placeholder;
        $image = $this->upload_directory . DS . $this->user_image;
        return empty($this->user_image) ? $placeholder : $image;
    }
} //End of USER Class
$user = new User();
