<?php require_once("includes/init.php");

// Control access to ADMIN
if (!$session->isLoggedIn()) {
    redirect("login.php");
}

//Control access to User Delete
if (empty($_GET['id'])) {
    redirect("admin_users.php");
}

// Delete User
$users = User::findById($database->escape($_GET['id']));
if ($users) {
    $users->delete();
    redirect("admin_users.php");
} else {
    redirect("admin_users.php");
}
