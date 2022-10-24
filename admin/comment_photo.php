<?php include("includes/header.php");

// Control access to ADMIN
if (!$session->isLoggedIn()) {
    redirect("login.php");
}

if (empty($database->escape($_GET['id']))) {
    redirect("admin_photos.php");
}

// Read Comments Database for specific photo
$comments = Comment::findComments($database->escape($_GET['id']));



?>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <?php include "includes/topnav.php"; ?>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <?php include "includes/sidenav.php"; ?>
    <!-- /.navbar-collapse -->
</nav>

<!-- Page Heading -->
<div id="page-wrapper">

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Comments
                    <small>Subheading</small>
                </h1>
                <p class="text-center bg-success"><?php echo $message; ?></p>
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Photo ID</th>
                                <th>Author</th>
                                <th>Content</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($comments as $comment) : ?>
                                <tr>
                                    <td><?php echo "$comment->id"; ?></td>
                                    <td><?php echo "$comment->photo_id"; ?></td>
                                    <td><?php echo "$comment->author"; ?></td>
                                    <td><?php echo "$comment->content"; ?></td>
                                    <td><a class="btn-sm btn-danger" href="delete_comment_photo.php?id=<?php echo $comment->id; ?>" onclick="return confirm('Are you sure you want to delete COMMENT?')">Delete</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->



<?php include("includes/footer.php"); ?>