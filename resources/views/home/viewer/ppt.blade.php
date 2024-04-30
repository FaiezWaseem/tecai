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
    </style>
</head>
<body>
    {{-- <iframe src="https://docs.google.com/gview?url={{  route('preview.file.download',['id'=> $id]) }}&embedded=true" style="min-width:962px; height:565px;" frameborder="0"></iframe> --}}
    <iframe src='https://view.officeapps.live.com/op/embed.aspx?src={{  route('preview.file.download',['id'=> $id]) }}' width='962px' height='565px' frameborder='0'></iframe>
</body>
</html>