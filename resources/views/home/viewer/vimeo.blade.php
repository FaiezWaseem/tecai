<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Video</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }
        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>

<body>
    <iframe src="{{ $content_link }}" allow="autoplay; fullscreen" allowfullscreen></iframe>
</body>

</html>


{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Hello</h1>
    <object id="myflash" width="550" height="400">
        <embed src="{{ route('preview.file.download',['id'=> $id]) }}"
        type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="500" height="400"></embed>
        <param name="movie" value="{{ route('preview.file.download',['id'=> $id]) }}" />
        <param name="bgcolor" value="#ffffff" />
        <param name="height" value="550" />
        <param name="width" value="400" />
        <param name="quality" value="high" />
        <param name="menu" value="false" />
        <param name="allowscriptaccess" value="always" />
    </object>
</body>
</html> --}}