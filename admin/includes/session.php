<?php

class Session
{
    // Properties
    private $signed_in = false;
    public $user_id;

    // Start Sessions
    function __construct()
    {
        session_start();
        $this->checkLoggedIn();
    }

    // Getter function
    public function isLoggedIn()
    {
        return $this->signed_in;
    }

    // login/To check if user is in database
    public function login($user)
    {
        if ($user) {
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->signed_in = true;
        }
    }

    // To Logout User
    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->signed_in = false;
    }

    //  To Check if user is logged in
    private function checkLoggedIn()
    {
        if (isset($_SESSION['user_di'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->signed_in = true;
        } else {
            unset($this->user_id);
            $this->signed_in = false;
        }
    }
}

$session = new Session();
