<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label The Diagram</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('excercise/assets/css/parts.css') }}">
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
        function showLoader(show = true) {
            document.querySelector('.container-loader').style.display = show ? 'flex' : 'none';
        }
        // Add a delay to simulate loading
        setTimeout(function() {
            showLoader(false)
        }, 1000);
    </script>

    <div class="container d-flex  justify-content-center h-100">
        <div style="
          display: flex;
    flex-direction: column;
    justify-content: center;
    width : 30% !important;
          ">
            <h1 style="color: white">Label The Diagram</h1>
            <p style="font-style: italic; color : red;">* First Select An Image , Second click on image to add a label , At Last click Next and Select theme</p>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <button class="btn btn-secondary" id="showPrev">Prev</button>
                <button class="btn btn-primary" id="showNext">Next</button>
            </ul>
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade" id="theme" role="tabpanel" aria-labelledby="theme-tab">
                <ul>
                    <li type='1'><img src='{{ asset('excercise/assets/images/parts_theme_1.PNG') }}' /></li>
                    <li type='2'><img src='{{ asset('excercise/assets/images/parts_theme_2.PNG') }}' /></li>
                    <li type='3'><img src='{{ asset('excercise/assets/images/parts_theme_3.PNG') }}' /></li>
                </ul>
            </div>
            <div class="tab-pane fade show active" id="diagram">
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
                    $folderPath = public_path('excercise/assets/images/themes/');
                    if (is_dir($folderPath)) {
                        if ($dh = opendir($folderPath)) {
                            while (($file = readdir($dh)) !== false) {
                                if ($file !== '.' && $file !== '..') {
                                    echo "<li theme='$file'><img src='" . asset("excercise/assets/images/themes/$file") . " ' /></li>";
                                }
                            }
                            closedir($dh);
                        }
                    }
                    ?>
                </ul>

            </div>

            <div class="tab-pane fade" id="output">

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
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
    <script src="{{ asset('excercise/assets/js/parts.js') }}"></script>
</body>

</html>
