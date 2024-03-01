<?php
$target_dir = "../../assets/images/uploads/";
$imageFileType = null;
$uploadOk = 1;
$target_file = null;

// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && $imageFileType != "php"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label The Diagram</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="../../assets/css/quiz.css">
</head>

<body>

    <div class="container d-flex flex-column justify-content-center h-100">
        <h1>Create Image Quiz Game</h1>
        <ul class="nav nav-tabs" id="myTab" role="tablist">

            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                    type="button" role="tab" aria-controls="profile" aria-selected="false">Content</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                    role="tab" aria-controls="home" aria-selected="true">Background</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                    role="tab" aria-controls="contact" aria-selected="false">Output</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div id="section2 w-100">
                    <?php
                    if (isset($_POST["submit"])) {
                        // Check if $uploadOk is set to 0 by an error
                        if ($uploadOk == 0) {
                            echo "Sorry, your file was not uploaded.";
                            // if everything is ok, try to upload file
                        } else {
                            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                echo '<img id="selectedImage"  src="../../assets/images/uploads/' . $_FILES["fileToUpload"]["name"] . '" width="500" height="400"></img> ';
                            } else {
                                echo "Sorry, there was an error uploading your file.";
                            }
                        }
                    } else {
                        echo '
          <form action="./index.php" method="post" enctype="multipart/form-data" >
          <h3>Select image to upload:</h3> 
          <br/>
          <input class="btn btn-primary" type="file" name="fileToUpload" id="fileToUpload">
          <br/>
          <br/>
          <input type="submit" value="Upload Image" name="submit" class="btn btn-secondary">
        </form>
        ';
                    }
                    ?>



                </div>
            </div>

            <div class="tab-pane fade p-2" id="home" role="tabpanel" aria-labelledby="home-tab">

                <ul>
                    <?php
                    if (is_dir("../../assets/images/themes/")) {
                        if ($dh = opendir("../../assets/images/themes/")) {
                            while (($file = readdir($dh)) !== false) {
                                if ($file !== "." && $file !== "..")
                                    echo "<li theme='$file'><img src='../../assets/images/themes/$file' /></li>";
                            }
                            closedir($dh);
                        }
                    }
                    ?>
                </ul>

            </div>

            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">

                <button class="btn btn-primary" onclick="postData()">GENERATE OUTPUT</button>
            </div>
        </div>
    
    </div>

    <div id="customDialog" class="dialog">
        <label for="pinpointName">Enter the name for the pinpoint:</label>
        <input type="text" id="pinpointName" />
        <button class="btn btn-primary" id="dialogOkButton">OK</button>
        <button class="btn btn-danger" id="dialogCancelButton">Cancel</button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
    <script src="../../assets/js/quiz.js"></script>
</body>

</html>