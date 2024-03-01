<?php

include_once('./utils/file.php');


class GenerateMatchtheColumns{
    
    public $leftColumn;
    public $rightColumn;
    public $bg;
    public $istheme = false;
    public $outPath = '../../out/';

    public function setLeftColumn($______CREATOR______FAIEZ___){
        $this->leftColumn = $______CREATOR______FAIEZ___;
    }
    public function setRightColumn($______CREATOR______FAIEZ___){
        $this->rightColumn = $______CREATOR______FAIEZ___;
    }
    public function setBg($______CREATOR______FAIEZ___){
        $this->bg = $______CREATOR______FAIEZ___;
    }
    public function setTheme($______CREATOR______FAIEZ___){
       $this->istheme =  $______CREATOR______FAIEZ___; 
    }

     function generate($default = true){
        deleteDirectory($this->outPath);
        mkdir($this->outPath);
        $this->createHTML();
        $this->createCSS();
        $this->createJS();
        if($this->istheme){
            copy('../../assets/images/themes/'.$this->bg, $this->outPath.$this->bg);
        }
        copy('../../assets/claps.mp3', $this->outPath.'claps.mp3');
        copy('../../assets/images/btn.png', $this->outPath.'btn.png');
        ziptoFolder($this->outPath,$this->outPath.'parts.zip');
        $backupPath = '../../files/'.date("Y-m-d").'/';
        $fullpath = $backupPath.date("Y-m-d").'-'.time().'-match.zip';
        mkdir($backupPath);
        copy($this->outPath.'parts.zip', $fullpath);
        if($default){
          return downloadFile($this->outPath.'parts.zip');
        }
        return $this->outPath;
    }

    private function createHTML(){
        $html = '
        <!doctype html>
            <html lang="en">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>MATCH</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
                <link rel="stylesheet" href="style.css">  
            </head>
            <body>
                <div id="title" class="row lesson-titles">
                <h1 class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">Matching columns </h1>
                <h1 class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" id="points">0 Points</h1>
                </div>
                <div class="resetBtn" onclick="window.location.reload()">
                <img src="./btn.png" width="200" height="60"  >
                </div>
                
                
                <div class="row">
                    <div id="column-left" class="col-xs-6 col-sm-5 col-md-4 col-lg-3 column-left">
                        
                    </div>
                
                    <div id="column-right" class="col-xs-6 col-xs-push-6 col-sm-5 col-sm-push-7 col-md-4 col-md-push-8 col-lg-3 col-lg-push-9 column-right">
                        
                    </div>
                
                </div>
                
                <canvas id="canvas" width="320" height="160">
                    Get a better browser, bro.
                </canvas>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
            <script src="./main.js"></script>  
            </body>
            </html>
        ';
         saveFile('index.html',$html);
         return $html;
    }
    private function createCSS(){
        $css = '
        * {
            box-sizing: border-box;
        }
        #title {
            background-color: transparent;
        }
        
        html {
        overflow: hidden;
        }
        
        body {
            margin: 0px;
            padding: 0px;
            background-image: url('.$this->bg.');
            background-size: cover;
            position: relative;
        }
        .resetBtn{
            position: absolute;
            top: 5%;
            right: 5%;
            z-index: 9999;
        }
        h1 {
            font-size: 32px;
        }
        
        h2 {
            font-size: 24px;
        }
        
        p {
            padding: 4px;
            font-size: 16px;
        }
        
        .lesson-titles .arabic-letter {
            color: #D31145;
            font-size: 92px;
            line-height: 92px;
            
        }
        
        p#attempts {
            font-size: 20px;
            font-weight: 700;
            color: gray;
        }
        .lesson-titles {
            display: block;
            position:relative;
            z-index: 999;
            min-width: 100%;
             
            padding-top: 20px;
            padding-bottom: 20px;
        }
        
        .row {
            z-index: 999;
        }
        
        .column-left {
            position: absolute;
            z-index: 99;
            left: 0;
        }
        .column-right {
            position: absolute;
            z-index: 99;
            right: 0;
        }
        
        .button-column {
            width: 100%;
            margin-top: 20px;
            margin-bottom: 20px;
            padding: 20px 0;
        }
        
        
        @media screen and(max-width : 768px) {
            .button-column{
                width: 80px !important;
            }
        }
        ';
        saveFile('style.css',$css);
        return $css;
    }
    private function createJS(){

        saveFile('main.js',"
        $(function() {
            'use strict';
            var columnLeftNamesInSequence = ". json_encode($this->leftColumn) .",
                columnRightNamesInSequence = ". json_encode($this->rightColumn) .", 
                canvasBackgroundColor = 'transparent',
                lineWidth = 5,points=0, audio = new Audio('./claps.mp3'),
                
                
                
                columnLeftIndexesInSequence = [],
                columnLeftIndexesShuffled = [],
                columnRightIndexesInSequence = [],
                columnRightIndexesShuffled = [],
                answeredIdsArray = [],
                wrongAnsweredIdsArray = [],
                canvas,
                context,
                i,
                x1,
                y1,
                x2,
                y2,
                offsetX = 0,
                offsetY = 0,
                windowHeight,
                windowWidth,
                titleSection,
                clickButtonIdPrevious,
                clickButtonIdCurrent,
                clickColumnIdPrevious,
                clickColumnIdCurrent,
                previousColButton,
                currentColButton,
                leftAnswersIdArray = [],
                rightAnswersIdArray = [],
                isCurrentLeft = false;
            
            var click1 = false, click2 = false, clickId, clickColumn, lastColumn, clickButtonIndex, buttonLeftIndex, buttonRightIndex;
            
            
            // Setting up canvas
            windowHeight = window.innerHeight;
            windowWidth = window.innerWidth;
            
            canvas = document.getElementById('canvas');
            canvas.height = windowHeight;
            canvas.width = windowWidth;
            canvas.style.backgroundColor = canvasBackgroundColor;
            
            titleSection = document.getElementById('title');
            offsetY = titleSection.offsetHeight;
            
            context = canvas.getContext('2d');
            
            
            
            // Generating Random Column Data
            
            for (i = 0; i < columnLeftNamesInSequence.length; i = i + 1) {
                columnLeftIndexesInSequence[i] = i;
                columnLeftIndexesShuffled[i] = i;
                columnRightIndexesInSequence[i] = i;
                columnRightIndexesShuffled[i] = i;
            }
            shuffle(columnLeftIndexesShuffled);
            shuffle(columnRightIndexesShuffled);
            
            // Generating Random Structure for Column 1 - only for column Left
            $('.column-left').each(function (index) {
                for(i = 0; i < columnLeftIndexesInSequence.length; i = i +1) {
                    $(this).append(
                        '<div class=\'col-lg-12 left-button\'>' +
                            '<button id=\'btn-left-'+columnLeftIndexesShuffled[i]+'\' type=\'button\' class=\'button-column btn btn-primary btn-lg\'>'+columnLeftNamesInSequence[columnLeftIndexesShuffled[i]]+'</button>' +
                        '</div>'
                    );
                }
            });
            // Generating Random Structure for Column 2 - only for column Right
            $('.column-right').each(function (index) {
                for(i = 0; i < columnRightIndexesInSequence.length; i = i +1) {
                    $(this).append(
                        '<div class=\'col-lg-12 right-button\'>' +
                            '<button id=\'btn-right-'+columnRightIndexesShuffled[i]+'\' type=\'button\' class=\'button-column btn btn-primary btn-lg\'>'+columnRightNamesInSequence[columnRightIndexesShuffled[i]]+'</button>' +
                        '</div>'
                    );
                }
            });
            
            
            
            function GetStartPoints() {
              // This function sets start points
                x1 = event.clientX;
                y1 = event.clientY;
            }
            
            function GetEndPoints() {
              // This function sets end points
                x2 = event.clientX;
                y2 = event.clientY;
            }
            function drawLine() {
                context.beginPath();
                context.moveTo(x1, y1);
                context.lineTo(x2, y2);
                context.stroke();
            }
            
            
            document.onclick= function(event) {
            // Compensate for IE<9's non-standard event model
            if (event===undefined) event= window.event;
            var target= 'target' in event? event.target : event.srcElement;
            if (target.id == undefined || target.id == 'title' || target.id == '' || target.id == 'canvas') {
               // if any of these ids are clicked then return from click event and dont proceed
                return false;
            }
            
            // if doesnt exist in array
            if (click1 == false && click2 == false) {
        
                clickId = target.id;
                clickColumn = clickId.split('-')[1];
                clickButtonIndex = clickId.split('-')[2];
        
                clickColumnIdCurrent = clickColumn;
                clickButtonIdCurrent = clickButtonIndex;
        
                clickColumnIdPrevious = clickColumnIdCurrent;
                clickButtonIdPrevious = clickButtonIdCurrent;
                
                previousColButton = clickColumn + '-' + clickButtonIndex;
                
                // Getting clicked Coords: x1, y1
                GetStartPoints();
        
                if (clickColumn == 'left') {
                    buttonLeftIndex = clickButtonIndex;
        //            alert(clickColumn + ' : '+ buttonLeftIndex);
                    lastColumn = clickColumn;
                    // Reposition the x1 coord to the right of the clicked button on left column rather than getting the clicked position
                    x1 = document.querySelector('#' + clickId).getBoundingClientRect().right;
                    
                } else if (clickColumn == 'right') {
                    buttonRightIndex = clickButtonIndex;
        //            alert(clickColumn + ' : '+ buttonRightIndex);
                    lastColumn = clickColumn;
                    
                    // Reposition the x1 coord to the left of the clicked button on right column rather than getting the clicked position
                    x1 = document.querySelector('#' + clickId).getBoundingClientRect().left;
                }
        
                click1 = true;
                
        
            } else if (click2 == false) {
                clickId = target.id;
                clickColumn = clickId.split('-')[1];
                clickButtonIndex = clickId.split('-')[2];
        
                clickColumnIdCurrent = clickColumn;
                clickButtonIdCurrent = clickButtonIndex;
                currentColButton = clickColumn + '-' + clickButtonIndex;
                
                if (clickColumn == 'left') {
                    isCurrentLeft = true;
                    
                } else if (clickColumn == 'right') {
                    isCurrentLeft = false;
                }
                
                if (lastColumn != clickColumn) {
        //            alert(clickColumn + ' : '+ lastColumn);
                    
                    if (isCurrentLeft == true) {
                        
                        if (jQuery.inArray(currentColButton, leftAnswersIdArray) == -1 
                            && jQuery.inArray(previousColButton, rightAnswersIdArray) == -1) {
                            
                            if (clickColumn == 'left') {
                                buttonLeftIndex = clickButtonIndex;
        
                                leftAnswersIdArray.push(currentColButton);
                                rightAnswersIdArray.push(previousColButton);
        
                            } else if (clickColumn == 'right') {
                                buttonRightIndex = clickButtonIndex;
        
                                leftAnswersIdArray.push(previousColButton);
                                rightAnswersIdArray.push(currentColButton);
                            }
                            
                            // Getting clicked Coords: x2, y2
                            GetEndPoints();
                            
                            // Reposition the x2 coord to the right of the clicked button on left column rather than getting the clicked position
                            x2 = document.querySelector('#' + clickId).getBoundingClientRect().right;
                            
                            context.beginPath();
                            context.moveTo(x1, y1 - offsetY);
                            context.lineTo(x2, y2 - offsetY);
                            context.lineWidth = lineWidth;
        
                            // set line color
                            if (clickButtonIdCurrent == clickButtonIdPrevious) {
                                // If answer is right
                                
                                context.strokeStyle = '#008800';
                                answeredIdsArray.push(clickButtonIdCurrent);
                                context.stroke();
                                points +=1;
                                console.log(points)
                                document.getElementById('points').innerText = points+ 'Points';
                                audio.play()
                
                            } else {
                                // if it doesnt exist -- it not already answered wrong
                                context.strokeStyle = '#ff0000';
                                context.stroke();
                            }
                            
                        }
                        isCurrentLeft = false;
                        
                    } else if (isCurrentLeft == false) {
                        
                        if (jQuery.inArray(currentColButton, rightAnswersIdArray) == -1 
                            && jQuery.inArray(previousColButton, leftAnswersIdArray) == -1) {
                            if (clickColumn == 'left') {
                                buttonLeftIndex = clickButtonIndex;
        
                                leftAnswersIdArray.push(currentColButton);
                                rightAnswersIdArray.push(previousColButton);
        
                            } else if (clickColumn == 'right') {
                                buttonRightIndex = clickButtonIndex;
        
                                leftAnswersIdArray.push(previousColButton);
                                rightAnswersIdArray.push(currentColButton);
                            }
                            
                            // Getting clicked Coords: x2, y2
                            GetEndPoints();
                            
                            // Reposition the x2 coord to the left of the clicked button on right column rather than getting the clicked position
                            x2 = document.querySelector('#' + clickId).getBoundingClientRect().left;
                            context.beginPath();
                            context.moveTo(x1, y1 - offsetY);
                            context.lineTo(x2, y2 - offsetY);
                            context.lineWidth = lineWidth;
        
                            // set line color
                            if (clickButtonIdCurrent == clickButtonIdPrevious) {
                                // If answer is right
        
                                context.strokeStyle = '#008800';
                                answeredIdsArray.push(clickButtonIdCurrent);
                                context.stroke();
        
                                points +=1;
                                console.log(points)
                                document.getElementById('points').innerText = points +' Points';
                                audio.play()
        
                            } else {
                                // if answer is wrong, now we will collect ids of wrong answer from both columns like 1 != 4
                                // So we will pair it and store it on an array index e.g. '1-4' on index n
                                // We will also have to look for if user click on 4 then 1, we shouldn't make '4-1' paid, so will do greater and less than comparison and smaller number will be placed before dash and then greater number id will come so it will become '1-4', which will help us in comparison
        
                                // if it doesnt exist -- it not already answered wrong
                                context.strokeStyle = '#ff0000';
                                context.stroke();
                            }
                            
                        }
                        
                        
                    }
        
                }
                click1 = false;
                click2 = false;
        
                }
                
            };
            
            // Shuffle Array functions
            function shuffle(a) {
            var j, x, i;
            for (i = a.length; i; i--) {
                    j = Math.floor(Math.random() * i);
                    x = a[i - 1];
                    a[i - 1] = a[j];
                    a[j] = x;
                }
            }
            
        });
        ");
    }
}

