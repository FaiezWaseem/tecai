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

  <link rel="stylesheet" href="../../assets/css/parts.css">
</head>

<body>

  <div class="container d-flex flex-column justify-content-center h-100">
    <h1>Label The Diagram</h1>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <button class="btn btn-secondary" id="showPrev">Prev</button>
      <button class="btn btn-primary" id="showNext">Next</button>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade" id="theme" role="tabpanel" aria-labelledby="theme-tab">
        <ul>
          <li type='1'><img src='../../assets/images/parts_theme_1.PNG' /></li>
          <li type='2'><img src='../../assets/images/parts_theme_2.PNG' /></li>
          <li type='3'><img src='../../assets/images/parts_theme_3.PNG' /></li>
        </ul>
      </div>
      <div class="tab-pane fade show active" id="diagram" >
        <div id="section2" class="w-100">


          <br />
          <label for="fileToUpload">Please Select An Image</label>
          <input class="btn btn-primary" placeholder="Select An Image" type="file" name="fileToUpload"
            id="fileToUpload">
          <br />
          <canvas id="canvas" width="500" height="400"></canvas>


        </div>
      </div>

      <div class="tab-pane fade p-2" id="backgrounds" role="tabpanel" aria-labelledby="home-tab">

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

      <div class="tab-pane fade" id="output" >

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
  <script src="../../assets/js/parts.js"></script>
</body>

</html>