<?php include("includes/header.php");

// Control access to ADMIN
if (!$session->isLoggedIn()) {
    redirect("login.php");
}

// Read Users Database
$users = User::findAll();



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
                    Users
                    <small>Subheading</small>
                </h1>
                <a href="add_users.php" class="btn btn-primary">Add User</a>
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Photo</th>
                                <th>Username</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td><?php echo "$user->id"; ?></td>
                                    <td><img class="img-thumbnail" width="60" src="<?php echo $user->imagePath(); ?>" alt=""></td>
                                    <td><?php echo "$user->username"; ?></td>
                                    <td><?php echo "$user->firstname"; ?></td>
                                    <td><?php echo "$user->lastname"; ?></td>
                                    <td><a class="btn-sm btn-info" href="">Edit</a><a class="btn-sm btn-danger" href="delete_users.php?id=<?php echo $user->id; ?>" onclick="return confirm('Are you sure you want to delete USER?')">Delete</a></td>
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