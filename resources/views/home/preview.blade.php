<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <object id="myflash" width="550" height="400">
        <embed src="{{ $url }}"
        type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="500" height="400"></embed>
        <param name="movie" value="{{ $url }}" />
        <param name="bgcolor" value="#ffffff" />
        <param name="height" value="550" />
        <param name="width" value="400" />
        <param name="quality" value="high" />
        <param name="menu" value="false" />
        <param name="allowscriptaccess" value="always" />
    </object>
</body>
</html>