<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clue Game</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />

    <style>
        body {
            min-height: 100vh;
        }
        #header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 1em;
            flex-wrap: wrap;
        }

        .div-remove {
            position: absolute;
            cursor: pointer;
            right: 10px;
            color: red;
            transition: all 1s;
        }

        .div-remove i:hover {
            transform: scale(1.1);
        }

        body {
            background-image: url({{ asset('excercise/assets/images/themes/theme2.png') }});
            background-size: cover;
            background-repeat: no-repeat;

        }

        .button {
            backface-visibility: hidden;
            position: relative;
            cursor: pointer;
            display: inline-block;
            white-space: nowrap;
            background: #19399b;
            border-radius: 100px;
            border: 0.5px solid rgba(0, 0, 0, 0.2);
            border-width: 0.5px 0.5px 0.5px 0.5px;
            padding: 4px 22px 5px 22px;
            box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.6), 0px 0px 5px rgba(255, 255, 255, 1), 0px 1px 0px 3px rgba(0, 0, 0, 0.2), inset 0px 1px 0px rgba(255, 255, 255, 1);
            color: #ffffff;
            font-size: 16px;
            font-family: Comic Sans MS;
            font-weight: 900;
            font-style: normal
        }

        .button>div {
            color: #999;
            font-size: 10px;
            font-family: Helvetica Neue;
            font-weight: initial;
            font-style: normal;
            text-align: center;
            margin: 0px 0px 0px 0px
        }

        .button>i {
            font-size: 1em;
            border-radius: 0px;
            border: 0px solid transparent;
            border-width: 0px 0px 0px 0px;
            padding: 0px 0px 0px 0px;
            margin: 0px 0px 0px 0px;
            position: static
        }

        .button>.ld {
            font-size: initial
        }

        .button:hover {
            transform: scale(1.1);
        }
    </style>

    

    <script src="https://unpkg.com/react@18/umd/react.development.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js" crossorigin></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>

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



    <div class="container">
        <div id="root">

        </div>
    <div>



            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Create</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">


                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Word (Max 10 letter)*</label>
                                <input type="text" maxlength="10" class="form-control" id="word"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Clue Type*</label>
                                <select name="type" id="hintType" class="form-select"
                                    aria-label="Default select example">
                                    <option value="text">Text</option>
                                    <option value="image">Image</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label" id="clue">Clue *</label>
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Enter a Clue" id="hint"></textarea>
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="saveWord">Save
                                changes</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div id="toast" class="toast bg-primary" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body text-white"></div>
                </div>
            </div>


            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
                crossorigin="anonymous"></script>
            <script type="text/javascript"
                src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>


            <script>


                function showToast(message, color) {
                    const toastElement = document.getElementById('toast');
                    const toastBodyElement = toastElement.querySelector('.toast-body');

                    // Update the toast message
                    toastBodyElement.innerText = message;

                    // Change the toast color
                    toastElement.classList.remove('bg-primary', 'bg-secondary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info');
                    toastElement.classList.add(color);

                    // Show the toast
                    const toast = new bootstrap.Toast(toastElement);
                    toast.show();

                    // Hide the toast after 3 seconds
                    setTimeout(function () {
                        toast.hide();
                    }, 3000);
                }



                function deleteWord(index) {
                    wordsJson.splice(index, 1);
                    renderWords()
                    showToast('Removed', 'bg-danger');
                }

                async function previewOutput() {
                    if (wordsJson.length >= 2) {

                        const form = new FormData();
                        form.append('type', 'crossword')
                        form.append('wordsjson', JSON.stringify(wordsJson))

                        const req = await fetch('../../assets/php/create.php', {
                            method: 'POST',
                            body: form,
                        })

                        const res = await req.blob()
                        console.log(res)

                        var link = document.createElement("a"); // Or maybe get it from the current document
                        link.href = "../../out/index.html";
                        document.body.appendChild(link);
                        link.click();
                    } else {
                        showToast('Please Add Atleast Two Clue', 'bg-danger')
                    }

                }
            </script>

            <script src="{{ asset('excercise/assets/js/App.jsx') }}" type="text/babel"> </script>

</body>

</html>