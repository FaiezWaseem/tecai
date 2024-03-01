<?php

include_once('./utils/file.php');


class GenerateParts
{

    protected $pinpoints;
    protected $dropImage;
    protected $bg;
    protected $type;
    protected $istheme = false;
    protected $outPath = '../../out/';

    public function setDropImage($______CREATOR______FAIEZ___)
    {
        $this->dropImage = $______CREATOR______FAIEZ___;
    }
    public function setType($______CREATOR______FAIEZ___)
    {
        $this->type = $______CREATOR______FAIEZ___;
    }
    public function setPinpoints($______CREATOR______FAIEZ___)
    {
        $this->pinpoints = $______CREATOR______FAIEZ___;
    }
    public function setBg($______CREATOR______FAIEZ___)
    {
        $this->bg = $______CREATOR______FAIEZ___;
    }
    public function setTheme($______CREATOR______FAIEZ___)
    {
        $this->istheme = $______CREATOR______FAIEZ___;
    }

    function generate($default = true)
    {
        // To Remove Old Content
        deleteDirectory($this->outPath);
        // Recreate empty folder again
        mkdir($this->outPath);
        // Creates HTML,CSS,JS based on Type
        new ThemeType($this->type , $this->bg , $this->dropImage , $this->pinpoints);

        $this->copyDragDropJS();
        // if local theme is Selected Copy
        if ($this->istheme) {
            copy('../../assets/images/themes/' . $this->bg, $this->outPath . $this->bg);
        }
        // Copy Uploaded Image
        copy('../../assets/images/btn.png' , $this->outPath . 'btn.png');

        copy('../../grade.js', $this->outPath . "/grade.js");

        // Create Zip of Out Folder
        ziptoFolder($this->outPath, $this->outPath . 'parts.zip');

        // Make A Copy 
        $backupPath = '../../files/' . date("Y-m-d") . '/';
        $fullpath = $backupPath . date("Y-m-d") . '-' . time() . '-parts.zip';
        mkdir($backupPath);
        copy($this->outPath . 'parts.zip', $fullpath);
        // Start Download
        if($default){
            downloadFile($this->outPath . 'parts.zip');
        }
        return $this->outPath;
    }


    private function copyDragDropJS()
    {
        copy('../../template/Fill_in_the_blanks/draganddrop.js', $this->outPath . 'draganddrop.js');
    }
}


class ThemeType
{

    private $bg;
    private $dropImage;
    private $pinpoints;

    public function __construct($type, $bg, $dropImage, $pinpoints)
    {
        $this->bg = $bg;
        $this->dropImage = $dropImage;
        $this->pinpoints = $pinpoints;
        if ($type == 1 || $type == '1') {
            $this->createHTMLType1();
            $this->createCSSType1();
            $this->createJSType1();
        }
        if ($type == 2 || $type == '2') {
            $this->createHTMLType2();
            $this->createCSSType2();
            $this->createJSType2();
        }
        if ($type == 3 || $type == '3') {
            $this->createHTMLType3();
            $this->createCSSType3();
            $this->createJSType3();
        }
    }
    private function createHTMLType1()
    {
        $html = '
       <!DOCTYPE html>
        <html>

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <title>Image Pinpoints</title>
            <link rel="stylesheet" href="style.css">
        </head>

        <body>
            <div class="container">
            <h1 id="score" >Score : 0</h1>
                <canvas id="canvas" width="500" height="400"></canvas>
                <div id="names">
                </div>
                <img src="./btn.png" width="200" height="60" style="margin: 8px;" onclick="window.location.reload()" />
            </div>
            <script src="./grade.js"></script>
            <script src="./main.js">

            </script>
        </body>

        </html>
        ';
        saveFile('index.html', $html);
        return $html;
    }
    private function createCSSType1()
    {
        $css = '
        body {
            background-image: url("'.$this->bg.'");
            background-repeat: no-repeat;
            background-size: cover;
            height: 100vh;
        }
        #names {
            margin-top: 1rem;
            width: 80%;
            display: flex;
            justify-content: start;
            align-items: center;
            cursor: pointer;
            flex-wrap: wrap;
        }
        .name {
            margin: 1px;
            background-color: orange;
            padding: 3px 12px;
            border-radius: 4px;
            color: white;
            font-family: "Courier New", Courier, monospace;
        }
        .container{
            display: flex;
            width: 80%;
            margin: 0 auto;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 90vh;
            padding: 1rem;
        }
        .container canvas {
            width: 500px;
            height: 400px;
            margin-top: 1rem;
        }
        
        canvas{
            border: 2px solid black;
            border-radius: 8px;
        }
        img{
            transition: all 1s;
            cursor: pointer;
        }
        
        img:hover , .name:hover{
            transform: scale(1.1);
        }
        ';
        saveFile('style.css', $css);
        return $css;
    }
    private function createJSType1()
    {
        saveFile('main.js', '
        let points = 0;
        let total = -1;
        let counter = 0;
        // Get the canvas element
        const canvas = document.getElementById("canvas");
        const context = canvas.getContext("2d");
   
        // Load the image
        const image = new Image();
        image.src = "'. $this->dropImage .'";
        image.onload = function () {
            // Draw the image on the canvas
            context.drawImage(image, 0, 0, canvas.width, canvas.height);
            drawPinpoints();
        };
   
        // Store the pinpoints and their names
        const pinpoints = '. json_encode($this->pinpoints) .';
        function updateGrades(){
            let total = pinpoints.length;
            
            if(total === counter){
                gradeAssignment(points,total)
                .then(res => {
                    if(res){
                        if(res.success){
                            alert("You Are Graded")
                        }
                    }
                })
            }else{
                counter = counter + 1;
                if(total === counter){
                    updateGrades();
                }
            }
        }
        const dropped = [];
        pinpoints.forEach(point => {
            document.getElementById("names").innerHTML += `<div class="name" draggable="true">${point.name}</div>`
        })
        // Store the color for highlighting the correct answer
        const highlightColor = "green";
   
        // Draw the pinpoints on the canvas
        function drawPinpoints() {
            context.clearRect(0, 0, canvas.width, canvas.height);
            context.drawImage(image, 0, 0, canvas.width, canvas.height);
   
            pinpoints.forEach(pinpoint => {
                context.beginPath();
                context.arc(pinpoint.x, pinpoint.y, 5, 0, 2 * Math.PI, false);
                context.fillStyle = "red";
                context.fill();
                context.closePath();
            });
        }
   
        // Handle drag-and-drop
        const draggableElements = document.querySelectorAll(".name");
   
        draggableElements.forEach(element => {
            element.addEventListener("dragstart", dragStart);
        });
   
        canvas.addEventListener("dragover", dragOver);
        canvas.addEventListener("drop", drop);
   
        let draggedElement = null;
   
        function dragStart(event) {
            draggedElement = event.target;
            event.dataTransfer.setData("text/plain", event.target.innerText);
        }
   
        function dragOver(event) {
            event.preventDefault();
        }
   
        function drop(event) {
            event.preventDefault();
            const rect = canvas.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;
   
            const name = event.dataTransfer.getData("text/plain");
            const matchingPinpoint = pinpoints.find(pinpoint => pinpoint.name === name);
            if (matchingPinpoint) {
                console.log(matchingPinpoint,{x,y})
                if (matchingPinpoint.name === name && x >= matchingPinpoint.x - 15 && x <= matchingPinpoint.x + 15 && y >= matchingPinpoint.y - 15 && y <= matchingPinpoint.y + 15) {
                    matchingPinpoint.showName = true;
                    drawPinpoints();
   
   
                    dropped.push(matchingPinpoint.name)
                    document.getElementById("names").innerHTML = "";
                    pinpoints.forEach(point => {
                       if(!dropped.includes(point.name)){
                           document.getElementById("names").innerHTML += `<div class="name" draggable="true">${point.name}</div>`
                       }
                   })
                   const draggableElements = document.querySelectorAll(".name");
   
                   draggableElements.forEach(element => {
                       element.addEventListener("dragstart", dragStart);
                   });
                   points += 1;
                   document.getElementById("score").innerHTML = `Score : ${points}/${pinpoints.length}`;
                   updateGrades();
                } else {
                    console.log({
                        points,
                        matchingPinpoint
                    })
                    matchingPinpoint.showName = true;
                    matchingPinpoint.error = true;
                    drawPinpoints();
                    dropped.push(matchingPinpoint.name)
                    document.getElementById("names").innerHTML = "";
                    pinpoints.forEach(point => {
                        if (!dropped.includes(point.name)) {
                            document.getElementById("names").innerHTML += `<div class="name" draggable="true">${point.name}</div>`
                        }
                    })
                    const draggableElements = document.querySelectorAll(".name");

                    draggableElements.forEach(element => {
                        element.addEventListener("dragstart", dragStart);
                    });
                    updateGrades();
                    alert("Wrong answer!");
                }
            }
        }
   
        // Render the names on the pinpoints
        function renderNames() {
            pinpoints.forEach(pinpoint => {
                if (pinpoint.showName) {
                    const name = pinpoint.name;
                    const textWidth = context.measureText(name).width;
                    const textHeight = 14; // Adjust the height of the background box as needed
                    const boxPadding = 4; // Adjust the padding around the text as needed
                    const boxX = pinpoint.x + 10;
                    const boxY = pinpoint.y - 10 - textHeight;
                    const boxWidth = textWidth + 2 * boxPadding;
                    const boxHeight = textHeight + 4;
   
                    // Draw the background box
                    context.fillStyle = pinpoint?.error ? "red" : "green"; // Adjust the color and opacity as needed
                    context.fillRect(boxX, boxY, boxWidth, boxHeight);
        
                    // Draw the text
                    context.font = "bold 16px Arial"; // Set the font weight to bold
                    context.fillStyle = "white";
                    context.fillText(name, boxX + boxPadding, boxY + boxHeight - boxPadding);
                }
            });
        }
   
        canvas.addEventListener("mousemove", function () {
            context.clearRect(0, 0, canvas.width, canvas.height);
            context.drawImage(image, 0, 0, canvas.width, canvas.height);
            drawPinpoints()
            renderNames();
        });
   
   
   
        ');
    }
    private function createHTMLType2(){
        $html = '
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <title>Image Pinpoints</title>
            <link rel="stylesheet" href="style.css">
        </head>

        <body>
            <div class="container">
            <h1 id="score" >Score : 0</h1>
                <canvas id="canvas" width="500" height="400"></canvas>
                <div id="names">
                    
                </div>
                <img src="./btn.png" width="200" height="60" onclick="window.location.reload()" />
            </div>
            <script src="./grade.js"></script>
            <script src="./main.js">
        
            </script>
        </body>

        </html>
        ';
        saveFile('index.html', $html);
    }
    private function createCSSType2(){
        saveFile('style.css' , '
        body {
            background-image: url("'.$this->bg.'");
            background-repeat: no-repeat;
            background-size: cover;
            height: 100vh;
        }
        #names {
            margin-left: 1rem;
            width: 15vw;
            height: 80%;
            display: flex;
            justify-content: start;
            align-items: center;
            cursor: pointer;
            flex-wrap: wrap;
        }
        .name {
            margin: 4px;
            background-color: orange;
            padding: 3px 12px;
            border-radius: 4px;
            color: white;
            font-family: "Courier New", Courier, monospace;
        }
        .container{
            display: flex;
            width: 90%;
            margin: 0 auto;
            justify-content: center;
            align-items: center;
            height: 90vh;
            padding: 1rem;
        }
        
        .container canvas {
            width: 500px;
            height: 400px;
            margin-top: 1rem;
        }
        
        canvas{
            border: 2px solid black;
            border-radius: 8px;
        }
        img{
            transition: all 1s;
            cursor: pointer;
        }
        
        img:hover , .name:hover{
            transform: scale(1.1);
        }
        
        ');
    }
    private function createJSType2(){   
        saveFile('main.js', '
        let points = 0;
        let total = -1;
        let counter = 0;
                // Get the canvas element
                const canvas = document.getElementById("canvas");
                const context = canvas.getContext("2d");
        
                // Load the image
                const image = new Image();
                image.src = "'.$this->dropImage.'";
                image.onload = function () {
                    // Draw the image on the canvas
                    context.drawImage(image, 0, 0, canvas.width, canvas.height);
                    drawPinpoints();
                };
        
                // Store the pinpoints and their names
                const pinpoints ='.  json_encode($this->pinpoints).' ;
                function updateGrades(){
                    let total = pinpoints.length;
                    
                    if(total === counter){
                        gradeAssignment(points,total)
                        .then(res => {
                            if(res){
                                if(res.success){
                                    alert("You Are Graded")
                                }
                            }
                        })
                    }else{
                        counter = counter + 1;
                        if(total === counter){
                            updateGrades();
                        }
                    }
                }
                const dropped = [];
                pinpoints.forEach(point => {
                    document.getElementById("names").innerHTML += `<div class="name" draggable="true">${point.name}</div>`
                })
                // Store the color for highlighting the correct answer
                const highlightColor = "green";
        
                // Draw the pinpoints on the canvas
                function drawPinpoints() {
                    context.clearRect(0, 0, canvas.width, canvas.height);
                    context.drawImage(image, 0, 0, canvas.width, canvas.height);
        
                    pinpoints.forEach(pinpoint => {
                        context.beginPath();
                        context.arc(pinpoint.x, pinpoint.y, 5, 0, 2 * Math.PI, false);
                        context.fillStyle = "red";
                        context.fill();
                        context.closePath();
                    });
                }
        
                // Handle drag-and-drop
                const draggableElements = document.querySelectorAll(".name");
        
                draggableElements.forEach(element => {
                    element.addEventListener("dragstart", dragStart);
                });
        
                canvas.addEventListener("dragover", dragOver);
                canvas.addEventListener("drop", drop);
        
                let draggedElement = null;
        
                function dragStart(event) {
                    draggedElement = event.target;
                    event.dataTransfer.setData("text/plain", event.target.innerText);
                }
        
                function dragOver(event) {
                    event.preventDefault();
                }
        
                function drop(event) {
                    event.preventDefault();
                    const rect = canvas.getBoundingClientRect();
                    const x = event.clientX - rect.left;
                    const y = event.clientY - rect.top;
        
                    const name = event.dataTransfer.getData("text/plain");
                    const matchingPinpoint = pinpoints.find(pinpoint => pinpoint.name === name);
                    if (matchingPinpoint) {
                        console.log(matchingPinpoint,{x,y})
                        if (matchingPinpoint.name === name && x >= matchingPinpoint.x - 15 && x <= matchingPinpoint.x + 15 && y >= matchingPinpoint.y - 15 && y <= matchingPinpoint.y + 15) {
                            matchingPinpoint.showName = true;
                            drawPinpoints();
        
        
                            dropped.push(matchingPinpoint.name)
                            document.getElementById("names").innerHTML = "";
                            pinpoints.forEach(point => {
                            if(!dropped.includes(point.name)){
                                document.getElementById("names").innerHTML += `<div class="name" draggable="true">${point.name}</div>`
                            }
                        })
                        const draggableElements = document.querySelectorAll(".name");
        
                        draggableElements.forEach(element => {
                            element.addEventListener("dragstart", dragStart);
                        });
                        points += 1;
                        document.getElementById("score").innerHTML = `Score : ${points}/${pinpoints.length}`;
                        updateGrades();
                    } else {
                        console.log({
                            points,
                            matchingPinpoint
                        })
                        matchingPinpoint.showName = true;
                        matchingPinpoint.error = true;
                        drawPinpoints();
                        dropped.push(matchingPinpoint.name)
                        document.getElementById("names").innerHTML = "";
                        pinpoints.forEach(point => {
                            if (!dropped.includes(point.name)) {
                                document.getElementById("names").innerHTML += `<div class="name" draggable="true">${point.name}</div>`
                            }
                        })
                        const draggableElements = document.querySelectorAll(".name");

                        draggableElements.forEach(element => {
                            element.addEventListener("dragstart", dragStart);
                        });
                        updateGrades();
                        alert("Wrong answer!");
                                    }
                                }
                            }
        
                // Render the names on the pinpoints
                function renderNames() {
                    pinpoints.forEach(pinpoint => {
                        if (pinpoint.showName) {
                            const name = pinpoint.name;
                            const textWidth = context.measureText(name).width;
                            const textHeight = 14; // Adjust the height of the background box as needed
                            const boxPadding = 4; // Adjust the padding around the text as needed
                            const boxX = pinpoint.x + 10;
                            const boxY = pinpoint.y - 10 - textHeight;
                            const boxWidth = textWidth + 2 * boxPadding;
                            const boxHeight = textHeight + 4;
        
                            // Draw the background box
                            context.fillStyle = pinpoint?.error ? "red" : "green"; // Adjust the color and opacity as needed
            context.fillRect(boxX, boxY, boxWidth, boxHeight);

            // Draw the text
            context.font = "bold 16px Arial"; // Set the font weight to bold
            context.fillStyle = "white";
                            context.fillText(name, boxX + boxPadding, boxY + boxHeight - boxPadding);
                        }
                    });
                }
        
                canvas.addEventListener("mousemove", function () {
                    context.clearRect(0, 0, canvas.width, canvas.height);
                    context.drawImage(image, 0, 0, canvas.width, canvas.height);
                    drawPinpoints()
                    renderNames();
                });
        
        
   
        ');

    }
    private function createHTMLType3(){
        saveFile('index.html', '
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <title>Image Pinpoints</title>
            <link rel="stylesheet" href="style.css">
        </head>

        <body>
            <div class="container">
            <h1 id="score" >Score : 0</h1>
                <div id="names">
                    
                </div>
                <canvas id="canvas" width="500" height="400"></canvas>
            </div>
            <img src="./btn.png" width="200" height="60" onclick="window.location.reload()" />
            <script src="./grade.js"></script>
            <script src="./main.js">
        
            </script>
        </body>

        </html>
        ');
    }
    private function createCSSType3(){
     saveFile('style.css' , '
        body {
            background-image: url("'.$this->bg.'");
            background-repeat: no-repeat;
            background-size: cover;
            height: 100vh;
            flex-direction: column;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #names {
            margin-left: 1rem;
            width: 15vw;
            height: 80%;
            display: flex;
            justify-content: start;
            align-items: center;
            cursor: pointer;
            flex-wrap: wrap;
        }
        .name {
            margin: 4px;
            background-color: orange;
            padding: 3px 12px;
            border-radius: 4px;
            color: white;
            font-family: "Courier New", Courier, monospace;
        }
        .container{
            display: flex;
            width: 90%;
            margin: 0 auto;
            justify-content: center;
            align-items: center;
            height: 80vh;
            padding: 1rem;
        }
        .container canvas {
            width: 500px;
            height: 400px;
            margin-top: 1rem;
        }
        canvas{
            border: 2px solid black;
            border-radius: 8px;
        }
        img{
            transition: all 1s;
            cursor: pointer;
        }
        
        img:hover , .name:hover{
            transform: scale(1.1);
        }
     ');
    }
    private function createJSType3(){
      saveFile('main.js' , '
            // Get the canvas element
            const canvas = document.getElementById("canvas");
            const context = canvas.getContext("2d");
            let points = 0;
            let total = -1;
            let counter = 0;
            // Load the image
            const image = new Image();
            image.src = "'.$this->dropImage.'";
            image.onload = function () {
                // Draw the image on the canvas
                context.drawImage(image, 0, 0, canvas.width, canvas.height);
                drawPinpoints();
            };
        
            // Store the pinpoints and their names
            const pinpoints = '.json_encode($this->pinpoints).';
            function updateGrades(){
                let total = pinpoints.length;
                
                if(total === counter){
                    gradeAssignment(points,total)
                    .then(res => {
                        if(res){
                            if(res.success){
                                alert("You Are Graded")
                            }
                        }
                    })
                }else{
                    counter = counter + 1;
                    if(total === counter){
                        updateGrades();
                    }
                }
            }
            const dropped = [];
            pinpoints.forEach(point => {
                document.getElementById("names").innerHTML += `<div class="name" draggable="true">${point.name}</div>`
            })
            // Store the color for highlighting the correct answer
            const highlightColor = "green";
        
            // Draw the pinpoints on the canvas
            function drawPinpoints() {
                context.clearRect(0, 0, canvas.width, canvas.height);
                context.drawImage(image, 0, 0, canvas.width, canvas.height);
        
                pinpoints.forEach(pinpoint => {
                    context.beginPath();
                    context.arc(pinpoint.x, pinpoint.y, 5, 0, 2 * Math.PI, false);
                    context.fillStyle = "red";
                    context.fill();
                    context.closePath();
                });
            }
        
            // Handle drag-and-drop
            const draggableElements = document.querySelectorAll(".name");
        
            draggableElements.forEach(element => {
                element.addEventListener("dragstart", dragStart);
            });
        
            canvas.addEventListener("dragover", dragOver);
            canvas.addEventListener("drop", drop);
        
            let draggedElement = null;
        
            function dragStart(event) {
                draggedElement = event.target;
                event.dataTransfer.setData("text/plain", event.target.innerText);
            }
        
            function dragOver(event) {
                event.preventDefault();
            }
        
            function drop(event) {
                event.preventDefault();
                const rect = canvas.getBoundingClientRect();
                const x = event.clientX - rect.left;
                const y = event.clientY - rect.top;
        
                const name = event.dataTransfer.getData("text/plain");
                const matchingPinpoint = pinpoints.find(pinpoint => pinpoint.name === name);
                if (matchingPinpoint) {
                    console.log(matchingPinpoint,{x,y})
                    if (matchingPinpoint.name === name && x >= matchingPinpoint.x - 15 && x <= matchingPinpoint.x + 15 && y >= matchingPinpoint.y - 15 && y <= matchingPinpoint.y + 15) {
                        matchingPinpoint.showName = true;
                        drawPinpoints();
        
        
                        dropped.push(matchingPinpoint.name)
                        document.getElementById("names").innerHTML = "";
                        pinpoints.forEach(point => {
                            if(!dropped.includes(point.name)){
                                document.getElementById("names").innerHTML += `<div class="name" draggable="true">${point.name}</div>`
                            }
                        })
                        const draggableElements = document.querySelectorAll(".name");
        
                        draggableElements.forEach(element => {
                            element.addEventListener("dragstart", dragStart);
                        });
                        points += 1;
                        document.getElementById("score").innerHTML = `Score : ${points}/${pinpoints.length}`;
                        updateGrades();
                    } else {
                        console.log({
                            points,
                            matchingPinpoint
                        })
                        matchingPinpoint.showName = true;
                        matchingPinpoint.error = true;
                        drawPinpoints();
                        dropped.push(matchingPinpoint.name)
                        document.getElementById("names").innerHTML = "";
                        pinpoints.forEach(point => {
                            if (!dropped.includes(point.name)) {
                                document.getElementById("names").innerHTML += `<div class="name" draggable="true">${point.name}</div>`
                            }
                        })
                        const draggableElements = document.querySelectorAll(".name");
            
                        draggableElements.forEach(element => {
                            element.addEventListener("dragstart", dragStart);
                        });
                        updateGrades();
                        alert("Wrong answer!");
                    }
                }
            }
        
            // Render the names on the pinpoints
            function renderNames() {
                pinpoints.forEach(pinpoint => {
                    if (pinpoint.showName) {
                        const name = pinpoint.name;
                        const textWidth = context.measureText(name).width;
                        const textHeight = 14; // Adjust the height of the background box as needed
                        const boxPadding = 4; // Adjust the padding around the text as needed
                        const boxX = pinpoint.x + 10;
                        const boxY = pinpoint.y - 10 - textHeight;
                        const boxWidth = textWidth + 2 * boxPadding;
                        const boxHeight = textHeight + 4;
        
                        // Draw the background box
                        context.fillStyle = pinpoint?.error ? "red" : "green"; // Adjust the color and opacity as needed
            context.fillRect(boxX, boxY, boxWidth, boxHeight);

            // Draw the text
            context.font = "bold 16px Arial"; // Set the font weight to bold
            context.fillStyle = "white";
                        context.fillText(name, boxX + boxPadding, boxY + boxHeight - boxPadding);
                    }
                });
            }
        
            canvas.addEventListener("mousemove", function () {
                context.clearRect(0, 0, canvas.width, canvas.height);
                context.drawImage(image, 0, 0, canvas.width, canvas.height);
                drawPinpoints()
                renderNames();
            });
      ');
    }
}