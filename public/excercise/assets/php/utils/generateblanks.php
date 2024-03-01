<?php

include_once('./utils/file.php');


class GenerateBlanks{
    
    public $dropHtml;
    public $dragHtml;
    public $bg;
    public $istheme = false;
    public $outPath = '../../out/';

    public function setDropHtml($______CREATOR______FAIEZ___){
        $this->dropHtml = $______CREATOR______FAIEZ___;
    }
    public function setDragHtml($______CREATOR______FAIEZ___){
        $this->dragHtml = $______CREATOR______FAIEZ___;
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
        $this->copyDragDropJS();
        if($this->istheme){
            copy('../../assets/images/themes/'.$this->bg, $this->outPath.$this->bg);
        }
        ziptoFolder($this->outPath,$this->outPath.'blanks.zip');
        $backupPath = '../../files/'.date("Y-m-d").'/';
        $fullpath = $backupPath.date("Y-m-d").'-'.time().'-blanks.zip';
        mkdir($backupPath);
        copy($this->outPath.'blanks.zip', $fullpath);

        if($default){
           return downloadFile($this->outPath.'blanks.zip');
        }
        return $this->outPath;
    }

    private function createHTML(){
        $html = "
        <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <link rel='stylesheet' href='style.css'>
                <title>Document</title>
            </head>
            <body>
                <div class='main-container'>
                    <div class='paragraphcontainer'>
                        <span>
                        $this->dragHtml
                      
                        </span>
                    </div>
                        
                    <div class='selection'>
                    $this->dropHtml
                    </div>
                </div>

                <script src='https://code.jquery.com/jquery-1.12.4.min.js'></script>
                <script src='draganddrop.js'></script>
                <script src='script.js'></script>
            </body>
            </html>
        
         ";
         saveFile('index.html',$html);
         return $html;
    }
    private function createCSS(){
        $css = "
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            height: 100vh;
            width: 100vw;
            overflow: hidden;
            background-image: url($this->bg);
            background-size: cover;
        }
        
        
        .main-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }
        
        .selection {
            display: flex;
            color: black;
            padding: 8px;
            font-size: 31px;
            border-radius: 6px;
            width: 80%;
            max-height: 60vh;
        }
        
        .drop {
            width: 150px;
            height: 30px;
            display: inline-block;
            border-radius: 8px;
            display: inline-block;
            border: 2px dotted white;
            background-color: rgba(0, 0, 0, 0.2);
        }
        
        .paragraphcontainer {
            background-color: rgba(255, 255, 255, 0.8);
            border: 2px solid black;
            color: black;
            padding: 8px;
            font-size: 31px;
            border-radius: 6px;
            width: 80%;
            max-height: 60vh;
        }
        
        .paragraphcontainer p {
            display: contents;
        }
        
        .paragraphcontainer span {
            text-align: center;
            font-family: 'Courier New', Courier, monospace;
            word-wrap: break-word;
        }
        
        .item {
            width: 150px;
            height: 30px;
            border: 0.8px solid grey;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0.8%;
            border-radius: 8px;
            cursor: pointer;
            background-color: rgba(255, 255, 255, 0.8);
            font-size: 1.5rem;
        }
        
        .item:hover {
            border: 0.5px solid black;
            background-color: rgba(255, 255, 255, 1);
        }
        .hovering {
            background-color: rgba(255, 255, 255, 1);
        }
        
        
        @media screen and (max-width : 768px) {
            .paragraphcontainer{
                font-size: 18px;
            }
            .item {
                font-size: 12px;
            }
        }
        ";
        saveFile('style.css',$css);
        return $css;
    }
    private function createJS(){
        saveFile('script.js',"
            $(function() {
                $('.dragdrop').draggable({
                    revert: true,
                    placeholder: true,
                    droptarget: '.drop',
                    drop: function (evt, droptarget) {
                        var drag_id = $(this)[0].getAttribute('sid')
                        var drop_id = droptarget.getAttribute('target')
                        var dragtarget = $(this)
                        ondropTarget(drag_id , drop_id , dragtarget  ,droptarget)
                        console.log({ drag_id, drop_id, dragtarget, droptarget })
                    }
                });
            });
            
            function ondropTarget(drag_id, drop_id, dragtarget, droptarget) {
            
                if(drag_id == drop_id){
                dragtarget.appendTo(droptarget).draggable('destroy')
                // The rest of your code
                } else {
                // The rest of your code
                console.log('error');
                }
            }
        ");
    }
    private function copyDragDropJS(){
        copy('../../template/Fill_in_the_blanks/draganddrop.js', $this->outPath.'draganddrop.js');
    }
}

