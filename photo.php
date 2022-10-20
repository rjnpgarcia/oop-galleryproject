<?php
require_once("includes/header.php");

// Control access
// if (empty($_GET['id'])) {
//     redirect("index.php");
// }

// instantiate
$user = new User();

// Read Photo by id
$photo = Photo::findById($database->escape($_GET['id']));

// View Count
if ($photo) {
    $photo->viewCounter($database->escape($_GET['id']));
}

// Create Comment
if (isset($_POST['submitComment'])) {
    $author = trim($database->escape($_POST['author']));
    $content = trim($database->escape($_POST['content']));
    $new_comment = Comment::createComment($photo->id, $author, $content);
    if ($new_comment && $new_comment->save()) {
        redirect("photo.php?id=$photo->id");
    } else {
        $new_comment->notification = "Problem posting comment";
    }
}

// Read Comments by photo id
$comments = Comment::findComments($photo->id);

?>

<body>
    <!-- Navigation -->
    <?php require_once("includes/navigation.php"); ?>


    <!-- Photo Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8">

                <!-- Blog Post -->

                <!-- Title -->
                <h1>Blog Post Title</h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="#">Start Bootstrap</a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on August 24, 2013 at 9:00 PM</p>

                <hr>

                <!-- Preview Image -->
                <img class="img-responsive" src="http://placehold.it/900x300" alt="">

                <hr>

                <!-- Post Content -->
                <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus, vero, obcaecati, aut, error quam sapiente nemo saepe quibusdam sit excepturi nam quia corporis eligendi eos magni recusandae laborum minus inventore?</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, tenetur natus doloremque laborum quos iste ipsum rerum obcaecati impedit odit illo dolorum ab tempora nihil dicta earum fugiat. Temporibus, voluptatibus.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, doloribus, dolorem iusto blanditiis unde eius illum consequuntur neque dicta incidunt ullam ea hic porro optio ratione repellat perspiciatis. Enim, iure!</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error, nostrum, aliquid, animi, ut quas placeat totam sunt tempora commodi nihil ullam alias modi dicta saepe minima ab quo voluptatem obcaecati?</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum, dolor quis. Sunt, ut, explicabo, aliquam tenetur ratione tempore quidem voluptates cupiditate voluptas illo saepe quaerat numquam recusandae? Qui, necessitatibus, est!</p>

                <hr>

                <!-- Blog Comments -->

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" method="post">
                        <div class="form-group">
                            <label for="">Author</label>
                            <input type="text" name="author" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Comment</label>
                            <textarea class="form-control" rows="3" name="content"></textarea>
                        </div>
                        <button type="submit" name="submitComment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
                <?php foreach ($comments as $comment) : ?>
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="<?php echo $user->picturePath(); ?>" alt="">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><?php echo $comment->author; ?>
                            </h4>
                            <?php echo $comment->content; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">


                <?php require_once("includes/sidebar.php"); ?>



            </div>
            <!-- /.row -->
            <!-- End Index Page Contents -->
            <?php require_once("includes/footer.php"); ?>