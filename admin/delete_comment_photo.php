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
    $session->message("Comment successfully deleted!");
    redirect("comment_photo.php?id=$comment->photo_id");
} else {
    redirect("comment_photo.php?id=$comment->photo_id");
}
