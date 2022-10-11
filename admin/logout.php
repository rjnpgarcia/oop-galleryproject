<?php
require_once "includes/header.php";

// Logout method
$session->logout();
redirect("login.php");
