<?php include("includes/header.php");

// Control access to ADMIN
if (!$session->isLoggedIn()) {
    redirect("login.php");
}

// Read Photo Database
$photos = Photo::findAllDescOrder();



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
                    Photos
                    <small>Subheading</small>
                </h1>
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Filename</th>
                                <th>Size</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($photos as $photo) : ?>
                                <tr>
                                    <td><img class="img-thumbnail" width="200px" src="<?php echo $photo->picturePath(); ?>" alt="">
                                        <div class="picture_links">
                                            <a href="" class="btn-sm btn-info">View</a>
                                            <a href="edit_photo.php?id=<?php echo $photo->id; ?>" class="btn-sm btn-warning">Edit</a>
                                            <a href="delete_photo.php?id=<?php echo $photo->id; ?>" class="btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                                        </div>
                                    </td>
                                    <td><?php echo "$photo->id"; ?></td>
                                    <td><?php echo "$photo->title"; ?></td>
                                    <td><?php echo "$photo->filename"; ?></td>
                                    <td><?php echo "$photo->size"; ?></td>
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