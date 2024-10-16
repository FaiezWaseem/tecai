<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Match the Column</title>
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
  <!-- MDB -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="{{ asset('excercise/assets/css/match.css') }}">
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
    function showLoader(show = true){
      document.querySelector('.container-loader').style.display = show ? 'flex' :  'none';
    }
    // Add a delay to simulate loading
    setTimeout(function () {
      showLoader(false)
    }, 1000);
  </script>

  <div class="p-4 d-flex flex-column justify-content-center">
    <div class="d-flex align-items-start">
      <div class="nav flex-end nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <button class="btn btn-secondary" id="showPrev">Prev</button>
      <button class="btn btn-primary" id="showNext">Next</button>
        </div>
      <div class="tab-content" id="v-pills-tabContent">

        <div class="tab-pane fade" id="background" role="tabpanel" aria-labelledby="v-pills-home-tab">
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
          <ul id="theme_links">
            <?php
            $folderPath = public_path('excercise/assets/images/themes/');
            if (is_dir($folderPath)) {
              if ($dh = opendir($folderPath)) {
                while (($file = readdir($dh)) !== false) {
                  if ($file !== "." && $file !== "..")
                    echo "<li theme='$file'><img src='" .  asset("excercise/assets/images/themes/$file") . " ' /></li>";
                }
                closedir($dh);
              }
            }
            ?>
          </ul>

        </div>


        <div class="tab-pane fade  show active" id="content" role="tabpanel" aria-labelledby="v-pills-profile-tab">
          <div class="row d-flex" >
            <div class="col-6 justify-content-center align-items-center">
              <div class="input-group mt-5" style="width: 300px;">
                <div class="form-outline" data-mdb-input-init>
                  <input type="search" id="columnleft" class="form-control" />
                  <label class="form-label" for="form1">Column Left</label>
                </div>
              </div>
             </div>
             <div class="col-6 justify-content-center align-items-center">
              <div class="input-group mt-5" style="width: 300px;">
                <div class="form-outline" data-mdb-input-init>
                  <input type="search" id="columnright" class="form-control" />
                  <label class="form-label" for="form1">Column Right</label>
                </div>
                <button type="button" id="addColumn" class="btn btn-primary" style="width: 60px;" >
                 Add
                </button>
              </div>
             </div>

          </div>
          <table class="table bg-white mt-2">
            <thead>
              <tr>
                <th scope="col" style="font-weight: bold;">Column Left</th>
                <th scope="col" style="font-weight: bold;">Column Right</th>
              </tr>
            </thead>
            <tbody class="output" >
   

            </tbody>
          </table>
        </div>


        <div class="tab-pane fade" id="output" role="tabpanel" aria-labelledby="v-pills-messages-tab">
          <button class="btn btn-primary" onclick="postData()">GENERATE OUTPUT</button>
        </div>
    
      </div>
    </div>


  </div>

  <div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="toast" class="toast bg-primary" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-body text-white"></div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
  <script src="{{ asset('excercise/assets/js/match.js') }}"></script>
</body>

</html>