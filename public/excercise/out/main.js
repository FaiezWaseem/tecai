

        var currentCategory= ["dnd","history", "language", "nature", "technology"];
        var Questions= [{"category":"history","question":"No So Lovely Question","answer":true},{"category":"history","question":"Not So Lovely Question","answer":true}];
    
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



        
        