<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body{
            padding: 0px;
            margin: 0px;
        }
        video{
            width: 100%;
            height: 100%;
            max-width: 100vw;
            max-height: 100vh;
        }
    </style>
</head>
<body>
    <video src="{{ route('preview.file.download',['id'=> $id]) }}" controls></video>
</body>
</html>