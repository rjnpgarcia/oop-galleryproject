<?php include("includes/header.php");

// Control access to ADMIN
if (!$session->isLoggedIn()) {
    redirect("login.php");
}

// Uploading Files to Database and admin/images folder
$photos = new Photo();
if (isset($_POST['upload'])) {
    $photos->title = $_POST['title'];
    $photos->set_file($_FILES['file_upload']);

    if ($photos->saveDataPhoto()) {
        $session->message("$photos->title successfully uploaded!");
        redirect("admin_photos.php");
    } else {
        $session->message(join("<br>", $photos->errors));
    }
}


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
                    Upload
                    <small>Subheading</small>
                </h1>
                <p class="text-center bg-danger"><?php echo $message; ?></p>
                <div class="row">
                    <div class="col-md-6">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" name="title" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Upload Picture</label>
                                <input type="file" name="file_upload">
                            </div>
                            <div>
                                <input type="submit" name="upload" value="Upload" class="btn btn-info">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->



<?php include("includes/footer.php"); ?>