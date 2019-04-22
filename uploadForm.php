<?php

$pageTitle = "Upload files";
$uploadDirectory = "images/";

//list of authorized MIME types
$authorizedMimeTypes = ["image/jpeg", "image/gif", "image/png"];

include('header.php');

?>

    <body>
        <nav class="navbar navbar-light bg-light justify-content-between">
            <a class="navbar-brand">Upload files quest</a>
            <a class="nav-link btn btn-secondary btn-lg" href="index.php">Go back to gallery</a>
        </nav>

<?php

if (isset($_POST['submit'])) {
    if (count($_FILES['upload']['name']) > 0) {
        //Loop through each file
        for ($i=0; $i<count($_FILES['upload']['name']); $i++) {
            //Get the temp file path
            $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
            //Get the extension
            $mimeType = explode("/", $_FILES['upload']['type'][$i]);
            $extension = $mimeType[count($mimeType)-1];

            //Make sure we have a filepath
            if ($tmpFilePath != "") {
                //Make sure the MIME type is accepted
                if (in_array($_FILES['upload']['type'][$i], $authorizedMimeTypes)) {
                    //save the url and the file
                    $filePath = $uploadDirectory . 'image' . uniqid() . '.' . $extension;

                    //Upload the file into the temp dir
                    if (move_uploaded_file($tmpFilePath, $filePath)) {
                        $files[] = $_FILES['upload']['name'][$i];
                    } else {
                        //Put in rejected
                        $rejectedFiles[] = $_FILES['upload']['name'][$i] . ' (Upload failed)';
                    }
                } else {
                    $rejectedFiles[] = $_FILES['upload']['name'][$i] . ' (Wrong type)';
                }
            } elseif ($_FILES['upload']['error'][$i] == UPLOAD_ERR_FORM_SIZE) {
                $rejectedFiles[] = $_FILES['upload']['name'][$i] . ' (Too big)';
            }
        }
    }

    //show success message
    echo "<h2>Uploaded:</h2>";
    if (is_array($files)) {
        echo "<ul>";
        foreach ($files as $file) {
            echo "<li>$file</li>";
        }
        echo "</ul>";
    }

    //show rejected message
    if (isset($rejectedFiles)) {
        echo "<h2>Rejected:</h2>";
        echo "<ul>";
        foreach ($rejectedFiles as $rejectedFile) {
            echo "<li>$rejectedFile</li>";
        }
        echo "</ul>";
    }
}
?>
        <div class="container-fluid">
            <div class="card card-outline-secondary col-md-6 offset-md-3">
                <div class="card-header">
                    <h1 class="mb-0">Add pictures (jpg, gif or png)</h1>
                </div>
                <div class="card-body">
                    <form action="" enctype="multipart/form-data" method="post" class="col-md-10">
                      <div class="form-group">
                        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                        <label for="upload">Add files:</label>
                        <input id="upload" name="upload[]" type="file" multiple="multiple" class="form-control-file" />
                      </div>
                      <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
