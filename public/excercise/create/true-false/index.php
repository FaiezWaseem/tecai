<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>True False</title>
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
  <!-- MDB -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="../../assets/css/blanks.css">
</head>

<body>

<style>
    .container-loader {
      position: absolute;
      height: 100vh;
      width: 100vw;
      z-index: 99999;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: white;
      flex-direction: column;
    }

    .loader {
      display: inline-block;
      width: 60px;
      height: 60px;
      border: 6px solid #3498db;
      border-top-color: transparent;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }
  </style>
  <div class="container-loader">
    <div class="loader"></div>
    <p>loading Please Wait ...</p>
  </div>

  <script>
    // Add a delay to simulate loading
    setTimeout(function () {
      document.querySelector('.container-loader').style.display = 'none';
    }, 2000);
  </script>

  <div class="container d-flex flex-column justify-content-center">
    <h1>Create New True/False Questions</h1>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#background" type="button"
          role="tab" aria-controls="background" aria-selected="true">Theme</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
          role="tab" aria-controls="profile" aria-selected="false">Content</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
          role="tab" aria-controls="contact" aria-selected="false">Output</button>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="background" role="tabpanel" aria-labelledby="home-tab">
        <div class="d-flex justify-content-center align-items-center">
          <div class="input-group mt-5" style="width: 300px;">
            <div class="form-outline" data-mdb-input-init>
              <input type="text" id="link" class="form-control" />
              <label class="form-label" for="form1">Add from Link</label>
            </div>
            <button type="button" id="addLink" class="btn btn-primary" style="width: 60px;" >
             Add
            </button>
          </div>
         </div>
         <div id="scroll">
         <?php 
            if (is_dir("../../assets/images/themes/")) {
              if ($dh = opendir("../../assets/images/themes/")) {
                  while (($file = readdir($dh)) !== false) {
                    if($file !== "." && $file !== "..")
                      echo "<li theme='$file'><img src='../../assets/images/themes/$file' /></li>";
                  }
                  closedir($dh);
              }
            }       
          ?>
         </div>
        <ul id="theme_links">
     
        </ul>

      </div>
      <div class="tab-pane fade p-2" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div id="section2 w-100">

          <div class="d-flex justify-content-center align-items-center mt-3 flex-column">
            <div class="d-flex justify-content-center align-items-center">
              <div class="input-group mt-5" style="width: 300px;">
                <div class="form-outline" data-mdb-input-init>
                  <input type="search" id="question" class="form-control" />
                  <label class="form-label" for="form1">Question</label>
                </div>
                <button type="button" id="addQuestion" class="btn btn-primary" style="width: 60px;" >
                 Add
                </button>
              </div>
             </div>
            <div class="form-row">
              <div class="form-group" style="
              display: flex;
              justify-content: space-between;
              min-width: 20vw;
              margin: 10px;
          ">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="option" id="radiobutton1" value="true" checked>
                  <label class="form-check-label" for="radiobutton1">
                    true
                  </label>
                </div>

                <div class="form-check">
                  <input class="form-check-input" type="radio" name="option" id="radiobutton2" value="false">
                  <label class="form-check-label" for="exampleRadios2">
                    false
                  </label>
                </div>

              </div>
              
            </div>
            <div class="d-flex flex-column mt-3" id="questions">
            </div>
          </div>

        </div>
      </div>
      <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        <button class="btn btn-primary" onclick="postData()">GENERATE OUTPUT</button>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
  <script src="../../assets/js/truefalse.js"></script>
</body>

</html>