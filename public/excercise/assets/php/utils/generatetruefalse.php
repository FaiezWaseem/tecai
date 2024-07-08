<?php

include_once('./utils/file.php');


class GenerateTrueFalse{
    
    public $questions;
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
    public function setQuestions($______CREATOR______FAIEZ___){
        $this->questions = $______CREATOR______FAIEZ___;
    }

    public function generate($default = true){
        deleteDirectory($this->outPath);
        mkdir($this->outPath);
        $this->createHTML();
        $this->createCSS();
        $this->createJS();
        if($this->istheme){
            copy('../../assets/images/themes/'.$this->bg, $this->outPath.$this->bg);
        }
        copy('../../grade.js', $this->outPath . "/grade.js");
        ziptoFolder($this->outPath,$this->outPath.'truefalse.zip');
        $backupPath = '../../files/'.date("Y-m-d").'/';
        $fullpath = $backupPath.date("Y-m-d").'-'.time().'-truefalse.zip';
        mkdir($backupPath);
        copy($this->outPath.'truefalse.zip', $fullpath);
        if($default){
            return downloadFile($this->outPath.'truefalse.zip');
        }
        return $this->outPath;
    }
    private function createHTML(){
        $html = '
        <html>

            <head>

                <!-- Content Type Meta tag -->
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

                <!--Responsive Viewport Meta tag-->
                <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">


                <title>True False</title>

                <!-- FONT -->
                <link href="https://fonts.googleapis.com/css?family=Bungee+Shade" rel="stylesheet">
                <link href="https://fonts.googleapis.com/css?family=Coda" rel="stylesheet">

                <!-- Stylesheets -->
                <link rel="stylesheet" type="text/css" href="./style.css">

            </head>

            <body>

                <header>


                    <button onclick="catAndQuest()" id="start"> START </button>
                </header>


                <div class="container">
                    <div id="questions" style="display: none;">
                        <div id="count"></div>
                        <div id="category"></span> </div>
                        <div id="quest"> </div>
                        <button onclick="answer(true)" style="display:none;" id="answerT"> TRUE</button>
                        <button onclick="answer(false)" style="display:none;" id="answerF"> FALSE</button>

                    </div>
                    <div id="gameOver" style="display: none;" >
                        <div id="looser" style="display:none;">Sorry, no more questions</div>
                        <div id="points" style="display:none;">0</div>
                        <button onclick="restart()" style="display:none;" id="reset"> PLAY AGAIN? </button>
                    </div>
                </div>
                </div>


                <!-- JavaScript -->
                <script src="./main.js"></script>
            </body>

            </html>
        ';
         saveFile('index.html',$html);
         return $html;
    }
    private function createCSS(){
        $css = '
          @charset "UTF-8";

            .container {
                margin: 0px auto;
                width: 90%;
                min-height: 80vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            #questions,
            #gameOver {
                background-color: rgba(255, 255, 255, 1);
                border: 2px dashed orange;
                padding: 0.9rem 0;
            }

            #answerT {
                border-radius: 30% 70% 70% 30% / 30% 37% 63% 70%;
            }

            #answerF {
                border-radius: 30% 70% 70% 30% / 30% 37% 63% 70%;
                background-color: red;

            }

            @media (min-width: 110px) and (max-width: 711px) {

                #outerBox {
                    border: 2pt solid black;
                    height: 100px;
                }

                header h1 {
                    font-size: 12px !important;
                }

                header p {
                    padding-top: 10px !important;
                    font-size: 10px !important;
                    letter-spacing: 7px !important;
                }

                #start {
                    margin-left: 0% !important;
                    margin-right: 0% !important;
                }

                #quest {
                    font-size: 12px !important;
                    padding-left: 15px !important;
                    padding-right: 15px !important;
                }

                #answerT {
                    margin: 10% 0% 0% 15% !important;
                }

                #answerF {
                    margin: 10% 0% 0% 15% !important;
                }

                #reset {
                    margin: 0% 27% 0% 23% !important;
                }
            }

            @media (min-width: 508px) and (max-width: 711px) {
                header h1 {
                    font-size: 12px !important;
                }

                header p {
                    letter-spacing: 7px !important;
                }
            }



            @media (min-width: 712px) and (max-width: 910px) {

                #start {
                    margin-left: 0% !important;
                }

                #answerT {
                    margin: 5% 0% 0% 30% !important;
                }

                #answerF {
                    margin: 5% 0% 0% 15% !important;
                }

                #quest {

                    padding-left: 15px !important;
                    padding-right: 15px !important;
                }

            }

            body {
                font-family: "Coda", cursive;
                font-size: 12px;
                background-image: url(./Background_true_false.svg);
                background-size: cover;
            }

            header h1 {
                font-family: "Bungee Shade", cursive;
                font-size: 20px;
                text-align: center;
            }

            header {
                text-align: center;
                text-transform: uppercase;
                font-size: 18px;
                letter-spacing: 0px;
                margin-top: 70px;
                padding-bottom: 10px;
            }

            #start {
                font-size: 40px;
                position: relative;
                background-color: #4CAF50;
                border: none;
                font-size: 28px;
                color: #FFFFFF;
                padding: 20px;
                width: 200px;
                text-align: center;
                -webkit-transition-duration: 1s;
                /* Safari */
                transition-duration: 1s;
                text-decoration: none;
                overflow: hidden;
                cursor: pointer;
                -webkit-animation-name: changecolour;
                /* Safari 4.0 - 8.0 */
                -webkit-animation-duration: 1.5s;
                /* Safari 4.0 - 8.0 */
                -webkit-animation-iteration-count: infinite;
                /* Safari 4.0 - 8.0 */
                animation-name: changecolour;
                animation-duration: 1.5s;
                animation-iteration-count: infinite;

            }

            #start:after {
                content: "";
                background: #868679;
                display: block;
                position: absolute;
                margin-top: -120%;
                opacity: 0;

            }

            /* Safari 4.0 - 8.0 */
            @-webkit-keyframes changecolour {
                0% {
                    color: white;
                }

                50% {
                    color: black;
                }

                100% {
                    color: white;
                }
            }

            /* Standard syntax */
            @keyframes changecolour {
                0% {
                    color: white;
                }

                50% {
                    color: black;
                }

                100% {
                    color: white;
                }
            }



            #count {
                text-align: center;
                font-size: 16px;
                padding-bottom: 10px;
            }

            #points {
                text-align: center;
                font-size: 25px;
                padding-bottom: 10px;
                padding-top: 10px;
            }


            #category {
                text-align: center;
                padding-bottom: 20px;
                text-transform: uppercase;
                font-size: 15px;
                letter-spacing: 1px;
            }

            #quest {
                text-align: center;
                padding-top: 10px;
                padding-bottom: 10px;
                font-size: 30px;
                padding-left: 20px;
                padding-right: 20px;
            }

            #answerT:hover {
                background: linear-gradient(#5cb811, #77d42a);
            }

            #answerT {
                margin: 5% 10% 0% 30%;
                font-family:Arial;
                background-color: #4CAF50;
                border: none;
                font-size: 20px;
                color: #FFFFFF;
                padding: 20px;
                width: 100px;
                text-align: center;
                -webkit-transition-duration: 0.4s;
                /* Safari */
                transition-duration: 0.4s;
                text-decoration: none;
                overflow: hidden;
                cursor: pointer;


                border-width: 1px;
                /* color:#306108; */
                border-color: #268a16;
                font-weight: bold;
                border-top-left-radius: 6px;
                border-top-right-radius: 6px;
                border-bottom-left-radius: 6px;
                border-bottom-right-radius: 6px;
                box-shadow: inset 0px 1px 0px 0px #caefab;
                text-shadow: inset 0px 1px 0px #aade7c;
                background: linear-gradient(#77d42a, #5cb811);

            }

            #answerF:hover {
                background: linear-gradient(#ce0100, #fe1a00);
            }

            #answerF {
                margin: 5% 20% 0% 15%;
                font-family:Arial;
                background-color: red;
                border: none;
                font-size: 20px;
                color: #FFFFFF;
                padding: 20px;
                width: 100px;
                text-align: center;
                -webkit-transition-duration: 0.4s;
                /* Safari */
                transition-duration: 0.4s;
                text-decoration: none;
                overflow: hidden;
                cursor: pointer;



                border-width: 1px;
                color: #fff;
                border-color: #d02718;
                font-weight: bold;
                border-top-left-radius: 6px;
                border-top-right-radius: 6px;
                border-bottom-left-radius: 6px;
                border-bottom-right-radius: 6px;
                box-shadow: inset 0px 1px 0px 0px #f5978e;
                text-shadow: inset -19px -12px 0px #810e05;
                background: linear-gradient(#f24537, #c62d1f);
            }


            #winner {
                text-align: center;
                font-size: 45px;
                padding-bottom: 10px;
            }

            #looser {
                text-align: center;
                font-size: 45px;
                padding-bottom: 10px;
            }

            #reset {
                background-color: #4CAF50;
                border: none;
                font-size: 20px;
                color: #FFFFFF;
                padding: 20px;
                width: 200px;
                position: relative;
                text-align: center;
                -webkit-transition-duration: 0.4s;
                /* Safari */
                transition-duration: 0.4s;
                text-decoration: none;
                overflow: hidden;
                cursor: pointer;
                -webkit-animation-name: changecolour;
                /* Safari 4.0 - 8.0 */
                -webkit-animation-duration: 1.5s;
                /* Safari 4.0 - 8.0 */
                -webkit-animation-iteration-count: infinite;
                /* Safari 4.0 - 8.0 */
                animation-name: changecolour;
                animation-duration: 1.5s;
                animation-iteration-count: infinite;
                margin-left: 40%;
                margin-top: 5%;

            }
        ';
        saveFile('style.css',$css);
        return $css;
    }
    private function createJS(){
        saveFile('main.js','

        var currentCategory= ["dnd","history", "language", "nature", "technology"];
        var Questions= '.json_encode($this->questions).';
    
        // when declared over here other functions will see it; it"s not best practice to register them in global/window scope, but better than nothing ;)
        var count = 0;
        var points = 0;
        var category;
        var question;
        const questionsSize = Questions.length;

        //show answer buttons only after clicking start button
        function showButtons() {
            document.getElementById("answerT").style.display = "";
            document.getElementById("answerF").style.display = "";
            document.getElementById("questions").style.display = "";

        }

        // choose a category and a question
        function catAndQuest() {





            start.style.display = "none";


            showButtons();

            document.getElementById("points").innerHTML = "Points: " + (points);
            document.getElementById("count").innerHTML = "Question " + (++count) + " \/" + questionsSize;

            currentCategory = Questions.map(function (question) {
                return question.category;
            });
            category = currentCategory[Math.floor(Math.random() * currentCategory.length)];
            document.getElementById("category").innerHTML = "Category: " + (category);

            var questionList = Questions.filter(function (question) {
                return question.category === category;
            });

            question = questionList[Math.floor(Math.random() * questionList.length)];
            document.getElementById("quest").innerHTML = question.question;
        }

        // create a copy of Questions array
        var copy = [].concat(Questions);

        // delete used question out of the copy array
        function deleteUsed() {

            if (Questions.length > 0) {
                Questions.splice(Questions.indexOf(question), 1);
            }
        }

        //user answered question
        function answer(value) {

            if (count === questionsSize) {

                const point = document.getElementById("points");
                console.log(point)

                // All Questions finished
                document.getElementById("questions").style.display = "none";
                document.getElementById("gameOver").style.display = "";
                document.getElementById("looser").style.display = "";
                document.getElementById("reset").style.display = "";
                point.style.display = "";
                point.textContent = "Points: " + (points);

                gradeAssignment(points, questionsSize)
                    .then(res => {
                        if (res) {
                            if (res.success) {
                                alert("You Are Graded")
                            }
                        }
                    })

                return;
            }

            deleteUsed();


            if (value === question.answer) {
                points++;
            }
            catAndQuest();
        }

        //restart the game
        function restart() {
            document.location.href = "";
        }



        
        ');
    }
}

