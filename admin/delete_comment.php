<?php require_once("includes/init.php");

// Control access to ADMIN
if (!$session->isLoggedIn()) {
    redirect("login.php");
}

if (empty($_GET['id'])) {
    redirect("admin_comments.php");
}

// Delete comment
$comment = Comment::findById($database->escape($_GET['id']));

if ($comment) {
    $comment->delete();
    redirect("admin_comments.php");
} else {
    redirect("admin_comments.php");
}
