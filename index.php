<?php

$pageTitle = "Gallery";
$uploadDirectory = "images/";

include('header.php');

if (isset($_POST['submit'])) {
    $fileToBeDeleted = $uploadDirectory . $_POST['submit'];
    if (file_exists($fileToBeDeleted)) {
        unlink($fileToBeDeleted);
    }
}

$pictures = scandir($uploadDirectory);

?>

        <nav class="navbar navbar-light bg-light justify-content-between">
            <a class="navbar-brand">Upload files quest</a>
            <a class="nav-link btn btn-secondary btn-lg" href="uploadForm.php">Add pictures</a>
        </nav>

        <div class="container">

            <h1 class="my-4 text-center text-lg-left">Thumbnail Gallery</h1>

            <div class="row text-center text-lg-left">

                <?php
                for ($i=2; $i<count($pictures); $i++) {
                    ?>

                    <div class="card col-lg-3 col-md-4 col-xs-6">
                        <img class="card-img-top" src="<?php echo $uploadDirectory . $pictures[$i] ?>" alt="">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $pictures[$i] ?></h5>
                            <form class="form-inline" method="post">
                                <button type="submit" class="btn btn-primary" name="submit" value="<?php
                                echo $pictures[$i]
                                ?>">Delete</button>
                            </form>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    <?php include 'footer.php' ?>
