<?php

class Session
{
    // Properties
    private $signed_in = false;
    public $user_id;
    public $count;
    public $message;

    // Start Sessions
    function __construct()
    {
        session_start();
        $this->checkLoggedIn();
        $this->checkMessage();
        // $this->pageViewCount();
    }

    // Feedback Message
    public function message($msg = "")
    {
        if (!empty($msg)) {
            $_SESSION['message'] = $msg;
        } else {
            return $this->message;
        }
    }

    private function checkMessage()
    {
        if (isset($_SESSION['message'])) {
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else {
            $this->message = "";
        }
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

    // To Check if user is logged in
    private function checkLoggedIn()
    {
        if (isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->signed_in = true;
        } else {
            unset($this->user_id);
            $this->signed_in = false;
        }
    }

    // Page View Count
    // public function pageViewCount()
    // {
    //     if (isset($_SESSION['count'])) {
    //         return $this->count = $_SESSION['count']++;
    //     } else {
    //         return $_SESSION['count'] = 1;
    //     }
    // }
}

$session = new Session();
$message = $session->message();
