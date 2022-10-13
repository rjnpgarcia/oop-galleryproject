<?php require_once("includes/header.php");

// Control access to ADMIN page
if (!$session->isLoggedIn()) {
    redirect("login.php");
}

?>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <?php require_once "includes/topnav.php"; ?>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <?php require_once "includes/sidenav.php"; ?>
    <!-- /.navbar-collapse -->
</nav>

<!-- Page Heading -->
<div id="page-wrapper">

    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Welcome to Admin
                    <small>Subheading</small>
                </h1>
                <?php
                // $user = new User();
                // $user->username = "turoners";
                // $user->password = "123";
                // $user->firstname = "Nathaniel";
                // $user->lastname = "Garcia";
                // $user->create();

                // $user = User::findUserById(13);
                // $user->deleteUser();

                // $user = User::findUserById(13);
                // $user->lastname = "Blaire";
                // $user->save();

                // $user = new User();
                // $user->username = "turanssss";
                // $user->password = "123455555";
                // $user->firstname = "Nathaniel";
                // $user->lastname = "Joseph";
                // $user->createUser();
                // $user = new User();
                // $properties = $user->properties($user);
                // // var_dump($properties);
                // $keys = array_keys($properties);
                // // var_dump($keys);
                // $implode = implode("','", $keys);
                // var_dump($implode);



                ?>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="index.html">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-file"></i> Blank Page
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->



<?php include("includes/footer.php"); ?>