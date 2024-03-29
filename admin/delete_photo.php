<?php require_once("includes/init.php");

// Control access to ADMIN
if (!$session->isLoggedIn()) {
    redirect("login.php");
}

// Control access to delete page
if (empty($_GET['id'])) {
    redirect("admin_photos.php");
}

// Delete Photo in database and folder
$photos = Photo::findById($database->escape($_GET['id']));
if ($photos) {
    $photos->deletePhoto();
    $session->message("$photos->title successfully deleted!");
    redirect("admin_photos.php");
} else {
    redirect("admin_photos.php");
}
