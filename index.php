<?php
require_once("includes/header.php");

// Pagination
if (!isset($_GET['page'])) {
    redirect("index.php?page=1");
}
$page = !empty((int)$_GET['page']) ? (int)$_GET['page'] : 1;
$itemsPerPage = 8;
$itemsTotalCount = Photo::dataCount();


// Pagination instantiation
$pagination = new Pagination($page, $itemsPerPage, $itemsTotalCount);

// Redirect if over page count
if ((int)$_GET['page'] > $pagination->pageTotal()) {
    redirect("index.php?page=1");
}

// Read all photos per page
$photos = $pagination->findPhotosPaginate();

?>


<!-- Index Page Contents -->

<body>
    <!-- Navigation -->
    <?php require_once("includes/navigation.php"); ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-12">
                <div class="thumbnail row">
                    <?php foreach ($photos as $photo) : ?>
                        <div class="col-xs-6 col-md-3">
                            <a href="photo.php?id=<?php echo $photo->id; ?>" class="img-thumbnail">
                                <img width="300px" src="admin/<?php echo $photo->picturePath(); ?>" alt="">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <div class="row text-center">
                    <ul class="pagination">
                        <?php
                        if ($pagination->pageTotal() > 1) {

                            // for Previous Page Link
                            if ($pagination->hasPrevious()) {
                                $previous = $pagination->previousPage();
                                echo "<li class='previous'><a href='index.php?page=$previous'>Previous</a></li>";
                            }

                            // for Page Number Links
                            for ($i = 1; $i <= $pagination->pageTotal(); $i++) {
                                if ($i === $pagination->currentPage) {
                                    echo "<li class='active'><a href='index.php?page=$i'>$i</a></li>";
                                } else {
                                    echo "<li><a href='index.php?page=$i'>$i</a></li>";
                                }
                            }

                            // for Next Page Link
                            if ($pagination->hasNext()) {
                                $next = $pagination->nextPage();
                                echo "<li class='next'><a href='index.php?page=$next'>Next</a></li>";
                            }
                        }
                        ?>
                    </ul>
                </div>

            </div>
        </div>




        <!-- Blog Sidebar Widgets Column -->
        <!-- <div class="col-md-4"> -->
        <!-- </div> -->
        <!-- /.row -->
        <!-- End Index Page Contents -->
        <?php require_once("includes/footer.php"); ?>