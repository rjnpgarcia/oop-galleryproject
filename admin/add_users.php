<?php include("includes/header.php");

// Control access to ADMIN
if (!$session->isLoggedIn()) {
    redirect("login.php");
}

// Add User
$user = new User();
$addedUserMessage = "";
if (isset($_POST['add_user'])) {
    $user->username = $_POST['username'];
    $user->firstname = $_POST['firstname'];
    $user->lastname = $_POST['lastname'];
    $user->password = $_POST['password'];
    if (empty($user->username) || empty($user->firstname) || empty($user->lastname) || empty($user->password)) {
        $session->message("This field should not be empty");
    }

    if (!empty($user->username) && !empty($user->firstname) && !empty($user->lastname) && !empty($user->password)) {
        $user->set_file($_FILES['filename']);
        $user->saveDataPhoto();
        $user->save();
        $session->message("$user->username successfully added!");
        redirect("admin_users.php");
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
                    Add User
                    <small>Subheading</small>
                </h1>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="form-group">
                            <label for="">Profile Picture</label>
                            <input type="file" name="filename">
                        </div>
                        <div class="form-group">
                            <label for="">Username</label>
                            <p class="bg-danger text-center"><?php echo empty($user->username) ? $message : ""; ?></p>
                            <input type="text" name="username" placeholder="Create your username" class="form-control" value="<?php echo $user->username; ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Firstname</label>
                            <p class="bg-danger text-center"><?php echo empty($user->firstname) ? $message : ""; ?></p>
                            <input type="text" name="firstname" placeholder="Enter your firstname" class="form-control" value="<?php echo $user->firstname; ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Lastname</label>
                            <p class="bg-danger text-center"><?php echo empty($user->lastname) ? $message : ""; ?></p>
                            <input type="text" name="lastname" placeholder="Enter your lastname" class="form-control" value="<?php echo $user->lastname; ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <p class="bg-danger text-center"><?php echo empty($user->password) ? $message : ""; ?></p>
                            <input type="password" name="password" placeholder="Create your password" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="add_user" class="btn btn-primary pull-right" value="Add user">
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