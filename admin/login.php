<?php
require_once "includes/header.php";

// If user already logged in
if ($session->isLoggedIn()) {
    redirect("index.php");
}

// Login Form
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $username = $database->escape($username);
    $password = trim($_POST['password']);
    $password = $database->escape($password);

    // Check user in database
    $user_found = User::verify_user($username, $password);

    if ($user_found) {
        $session->login($user_found);
        redirect("index.php");
    } else {
        $errorMessage = "Username or Password incorrect";
    }
} else {
    $username = null;
    $password = null;
}
?>

<!-- ### LOGIN FORM FRONT-END ### -->
<div class="col-md-4 col-md-offset-3">

    <h4 class="bg-danger text-center"><?php echo isset($errorMessage) ? $errorMessage : ''; ?></h4>

    <form id="login-id" action="" method="post">

        <div class="form-group">
            <label for="username" class="text-info">Username</label>
            <input type="text" class="form-control" name="username" value="<?php echo htmlentities($username); ?>">

        </div>

        <div class="form-group">
            <label for="password" class="text-info">Password</label>
            <input type="password" class="form-control" name="password" value="<?php echo htmlentities($password); ?>">

        </div>


        <div class="form-group">
            <input type="submit" name="login" value="Submit" class="btn btn-primary">

        </div>


    </form>


</div>