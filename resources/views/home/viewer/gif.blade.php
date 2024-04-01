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
            background: rgba(0,0,0,0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        img{
            width: 350px;
            height: 280px;
            max-width: 100vw;
            max-height: 100vh;
        }
    </style>
</head>
<body>
    <img src="{{ route('preview.file.download',['id'=> $id]) }}" alt="Gif Image" />
</body>
</html>