<?php include("includes/header.php");

// Control access to ADMIN
if (!$session->isLoggedIn()) {
    redirect("login.php");
}

// Edit User
$user = User::findById($database->escape($_GET['id']));
if (isset($_POST['update_user'])) {
    if ($user) {
        $user->username = $_POST['username'];
        $user->firstname = $_POST['firstname'];
        $user->lastname = $_POST['lastname'];
        $user->password = $_POST['password'];
        if (empty($_FILES['filename'])) {
            $user->save();
            $user->notification = "User successfully updated!";
        } else {
            $user->set_file($_FILES['filename']);
            $user->saveDataPhoto();
            $user->save();
            $user->notification = "User successfully updated!";
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
                    Edit User
                    <small>Subheading</small>
                </h1>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="col-md-3 text-center">
                        <img class="img-responsive img-thumbnail" src="<?php echo $user->picturePath(); ?>" alt="">
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-success text-center"><?php $user->statusNotification(); ?></h5>
                        <div class="form-group">
                            <label for="">Profile Picture</label>
                            <input type="file" name="filename">
                        </div>
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" name="username" placeholder="Create your username" class="form-control" value="<?php echo $user->username; ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Firstname</label>
                            <input type="text" name="firstname" placeholder="Enter your firstname" class="form-control" value="<?php echo $user->firstname; ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Lastname</label>
                            <input type="text" name="lastname" placeholder="Enter your lastname" class="form-control" value="<?php echo $user->lastname; ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" placeholder="Create your password" class="form-control" value="<?php echo $user->password; ?>">
                        </div>
                        <div class="form-group">
                            <a href="delete_users.php?id=<?php echo $user->id; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete USER?')">Delete</a>
                            <input type="submit" name="update_user" class="btn btn-primary pull-right" value="Update user">
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