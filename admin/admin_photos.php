<?php include("includes/header.php");

// Control access to ADMIN
if (!$session->isLoggedIn()) {
    redirect("login.php");
}

// Read Photo Database
$photos = Photo::findAll();



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
                <div class="col-md-6">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>ID</th>
                                <th>Filename</th>
                                <th>Title</th>
                                <th>Size</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($photos as $photo) : ?>
                                <tr>
                                    <td><img width="80px" src="<?php echo $photo->picturePath(); ?>" alt=""></td>
                                    <td><?php echo "$photo->photo_id"; ?></td>
                                    <td><?php echo "$photo->filename"; ?></td>
                                    <td><?php echo "$photo->title"; ?></td>
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