<?php include("includes/header.php");

// Control access to ADMIN
if (!$session->isLoggedIn()) {
    redirect("login.php");
}

// Update/edit photo
$photo_id = $database->escape($_GET['id']);
$updateMessage = "";
if (empty($photo_id)) {
    redirect("admin_photos.php");
} else {
    $photo = Photo::findById($photo_id);
    if (isset($_POST['update'])) {
        if ($photo) {
            $photo->title = $_POST['title'];
            $photo->caption = $_POST['caption'];
            $photo->alternate_text = $_POST['alt_text'];
            $photo->description = $_POST['description'];

            $photo->save();
            $session->message("$photo->title is successfully updated!");
            redirect("admin_photos.php");
        }
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
                    Photos
                    <small>Subheading</small>
                </h1>
                <form action="" method="post">
                    <div class="col-md-8">
                        <h5 class="text-success text-center"><?php $photo->statusNotification(); ?></h5>
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" name="title" placeholder="Create your title" class="form-control" value="<?php echo $photo->title; ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Picture</label>
                            <a class="img-thumbnail" href="#"><img width="250px" src="<?php echo $photo->picturePath(); ?>" alt=""></a>
                        </div>
                        <div class="form-group">
                            <label for="">Caption</label>
                            <input type="text" name="caption" placeholder="Enter caption" class="form-control" value="<?php echo $photo->caption; ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Alternate Text</label>
                            <input type="text" name="alt_text" placeholder="Enter Alternative text" class="form-control" value="<?php echo $photo->alternate_text; ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea id="summernote" class="form-control" name="description" id="" cols="30" rows="10" placeholder="Compose description"><?php echo $photo->description; ?></textarea>
                        </div>

                    </div>
                    <!-- Edit snippet -->
                    <div class="col-md-4">
                        <div class="photo-info-box">
                            <div class="info-box-header">
                                <h4>Details <span id="toggle" class="glyphicon glyphicon-menu-up pull-right"></span></h4>
                            </div>
                            <div class="inside">
                                <div class="box-inner">
                                    <p class="text">
                                        <span class="glyphicon glyphicon-calendar"></span> Uploaded on: April 22, 2030 @ 5:26
                                    </p>
                                    <p class="text ">
                                        Photo Id: <span class="data photo_id_box">34</span>
                                    </p>
                                    <p class="text">
                                        Filename: <span class="data">image.jpg</span>
                                    </p>
                                    <p class="text">
                                        File Type: <span class="data">JPG</span>
                                    </p>
                                    <p class="text">
                                        File Size: <span class="data">3245345</span>
                                    </p>
                                </div>
                                <div class="info-box-footer clearfix">
                                    <div class="info-box-delete pull-left">
                                        <a href="delete_photo.php?id=<?php echo $photo->id; ?>" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-danger btn-lg">Delete</a>
                                    </div>
                                    <div class="info-box-update pull-right ">
                                        <input type="submit" name="update" value="Update" class="btn btn-primary btn-lg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->




<?php include("includes/footer.php"); ?>