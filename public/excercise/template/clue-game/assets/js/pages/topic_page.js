var topic_page = {
    pageData: {},

    init: function (valuePassed) {
        //isGamePlayOn = false;
        this.pageData = JSON.parse(gameService.dbGet("topicPageData", "{\"showIntro\": true}"));
        this.populate();
        this.addListeners();
        if(gameService.dbGet("IsSoundOn", "NULLVALUE") == "NULLVALUE")
        {
            gameService.dbSet("IsSoundOn", "YES");
        }

        // if(dbBank[selectedGrade].Topics.length==1 && gameService.previousPageViewed != "game_page") {
        //     selectedTopic=0;
        //     index_page.showPage(AppSet.pages.CoreGame);
        // }
        // if(dbBank[selectedGrade].length==1 || dbBank[selectedGrade].length==undefined)
        //         {
        //             if(gameService.previousPageViewed=="game_page")
        //             {

        //                 console.log("previousPageViewed TRUE");
        //                 selectedTopic=0;
        //                index_page.showPage(AppSet.pages.Entry);
 
        //             } else {

                        
        //                 console.log("previousPageViewed FALSE");
        //             selectedTopic=0;
        //             index_page.showPage(AppSet.pages.CoreGame);

        //             }
        //         }
    },

    generateTopicButton: function (i, Status) {
        console.log("Creating button with Status: " + Status);
        var idTmpName = "";
        var htmlIconString = "";

        switch (Status) {
            case 3:
                idTmpName = "CBtn";
                $("#" + idTmpName + i + "").remove();
                $('#topicsButtonsList').append("<div id='" + idTmpName + i + "'>" + $('#singleCompleteButton').clone().show().html() + "</div>");
                htmlIconString = "<div class=\"cupIcon\"></div>";
                break;
            case 2:
                idTmpName = "FBtn";
                $("#" + idTmpName + i + "").remove();
                $('#topicsButtonsList').append("<div id='" + idTmpName + i + "'>" + $('#singleFailedButton').clone().show().html() + "</div>");
                htmlIconString = "<div class=\"failedLevelIcon\"></div>";
                break;
            case 1:
                idTmpName = "UBtn";
                $("#" + idTmpName + i + "").remove();
                $('#topicsButtonsList').append("<div id='" + idTmpName + i + "'>" + $('#singleUnlockedButton').clone().show().html() + "</div>");
                htmlIconString = "<div class=\"unlockedIconforLevelProgress\"></div>";
                break;
            default:
                if (ulockAllTopics == true) {
                    idTmpName = "UBtn";
                    $("#" + idTmpName + i + "").remove();
                    $('#topicsButtonsList').append("<div id='" + idTmpName + i + "'>" + $('#singleUnlockedButton').clone().show().html() + "</div>");
                    htmlIconString = "<div class=\"unlockedIconforLevelProgress\"></div>";
                    break;
                } else {
                    idTmpName = "LBtn";
                    $("#" + idTmpName + i + "").remove();
                    $('#topicsButtonsList').append("<div id='" + idTmpName + i + "'>" + $('#singleLockedButton').clone().show().html() + "</div>");
                    htmlIconString = "<div class=\"lockLevelIcon\"></div>";
                    break;
                }
        }


        var completionScoreEach = 0;

        if (dbBank[selectedGrade].Topics[i].ListOrder.length > 0) {
            for (var j = 0; j < dbBank[selectedGrade].Topics[i].ListOrder.length; j++) {
                if (dbBank[selectedGrade].Topics[i].Questions[dbBank[selectedGrade].Topics[i].ListOrder[j]].Status > 2)
                    completionScoreEach += 100 / dbBank[selectedGrade].Topics[i].ListOrder.length;
            }

            console.log("completionScoreEach: " + completionScoreEach);

            //completionScoreEach = parseInt((completionScoreEach / dbBank[selectedGrade].Topics[i].ListOrder.length) * 100);
            console.log("completionScoreEach After: " + completionScoreEach);
            if (completionScoreEach > 100)
                completionScoreEach = 100;
            if (completionScoreEach < 0)
                completionScoreEach = 0;
        }
        $('#' + idTmpName + i + ' .levelNum').text((i + 1));
        $('#' + idTmpName + i + ' .levelNameText').text(dbBank[selectedGrade].Topics[i].Name);
        $('#' + idTmpName + i + ' .meterValueBold').text(Math.round(completionScoreEach) + '%');
        if(idTmpName=="LBtn")
        $('#' + idTmpName + i + ' .meterValueBold').text("LOCKED");
        else if(idTmpName=="UBtn") {
            $('#' + idTmpName + i + ' .meterValueBold').text("-");
            $('#' + idTmpName + i + ' .meterBGGreen').css('width','0%');
        }
        else
        $('#' + idTmpName + i + ' .meterBGGreen').css('width', completionScoreEach + '%');
        $('#' + idTmpName + i + ' #eachLevButton').data("index", i);
        $('#' + idTmpName + i + ' #eachLevButton').attr("name", "btnTopic-" + i);
        $('#' + idTmpName + i + ' .meterIcon').html(htmlIconString);


        if(dbBank[selectedGrade].Topics[i].Status >= 1)
        {
         if(dbBank[selectedGrade].Topics[i].Score>0)
           $('#' + idTmpName + i + ' .tScoreTxt').text(dbBank[selectedGrade].Topics[i].Score);
       //  else
        // $('#' + idTmpName + i + ' .currentScorePerTopic').hide();
        }

        if(dbBank[selectedGrade].Topics[i].Status >= 2)
        {
            
            $('#' + idTmpName + i + ' .currentScorePerTopic').hide();
        }
        if(dbBank[selectedGrade].Topics[i].Status == 2) {
            $('#' + idTmpName + i + ' .meterBGGreen').addClass('meterBGRed');
        }
        if (dbBank[selectedGrade].Topics[i].Status != 0 || classroomMode == true || ulockAllTopics == true) {
            $('#' + idTmpName + i + ' #eachLevButton').click(function (e) {



                if ($('#' + idTmpName + i + ' #eachLevButton').is(':disabled'))
                    return;
                $('#' + idTmpName + i + ' #eachLevButton').prop('disabled', true);
                setTimeout(function () {
                    $('#' + idTmpName + i + ' #eachLevButton').prop('disabled', false);
                }, 600);


                console.log("I value: " + i);
                selectedTopic = e.currentTarget.getAttribute('name').split('-')[1];
                console.log("THE ONE SELECTED TOPIC: " + $(e.currentTarget).data("index"));
                console.log("SELECTED TOPIC NAME: " + $(e.currentTarget.id).id);
                console.log("SELECTED TOPIC NAME2: " + e.currentTarget.getAttribute('name'));
                console.log("SELECTED TOPIC NAME FFFF: " + e.currentTarget.getAttribute('name').split('-')[1]);

                if (dbBank[selectedGrade].Topics[i].Status >= 2) {
                    $('#popupBackground').show();
                    animateMe('#topicResetConfirmationPopup', 'zoomIn', 300, function() { $('#topicResetConfirmationPopup').show(); });
                    
                } else {
                    playSound("goPressSound", false);
                    index_page.showPage(AppSet.pages.CoreGame, 1);
                }

            });
        }
    },

    populate: function () {

        // if (gameService.dbGet("IsSoundOn", "NO") == "YES") {
        //     if (currentBGTrack == "bg_sound") {
        //         gameService.playSound("entry_bg_sound", true);
        //         gameService.stopSound("bg_sound", true);
        //         currentBGTrack = "entry_bg_sound";
        //     } else 
        //     {
                
        //     }
            
        // } else {
        //     gameService.stopSound("entry_bg_sound", true);
        //     gameService.stopSound("bg_sound", true);
        // }
        
        
        
        topicsUnlocked = 0;
        if(dbBank[selectedGrade].Topics[0].Status == 0)
        dbBank[selectedGrade].Topics[0].Status = 1;
        $('#selectedGradeValue').text(dbBank[selectedGrade].Name);

        if (!$('#popupBackground').is(":hidden"))
            $('#popupBackground').hide();

        if (!$('#topicResetConfirmationPopup').is(":hidden"))
         $('#topicResetConfirmationPopup').hide();

        if ($('#singleCompleteButton').is(":hidden"))
            $('#singleCompleteButton').show();

        if ($('#singleUnlockedButton').is(":hidden"))
            $('#singleUnlockedButton').show();

        if ($('#singleFailedButton').is(":hidden"))
            $('#singleFailedButton').show();

        if ($('#singleLockedButton').is(":hidden"))
            $('#singleLockedButton').show();


        for (var i = 0; i < dbBank[selectedGrade].Topics.length; i++) {

            // switch (dbBank[selectedGrade].Topics[i].Status) {
            //     default:
            //     this.generateTopicButton(i,dbBank[selectedGrade].Topics.Status);
            //         break;
            //     case 2:
            //         break;
            //     case 1:
            //         break;
            //     case 3:
            //         break;
            // }

            if (classroomMode == true && dbBank[selectedGrade].Topics[i].Status == 0)
                this.generateTopicButton(i, 1);
            else
                this.generateTopicButton(i, dbBank[selectedGrade].Topics[i].Status);
        }

        $('#singleCompleteButton').hide();
        $('#singleUnlockedButton').hide();
        $('#singleFailedButton').hide();
        $('#singleLockedButton').hide();

        /*
                topicsUnlocked =0;
                var firstZero = true;
                for(var tv = 0; tv < dbBank[selectedGrade].Topics.length; tv++)
                {
                    
                    if(dbBank[selectedGrade].Topics[tv].Status==0 && firstZero==true)
                    {
                        topicsUnlocked++;
                        firstZero=false;
                    }

                    if(dbBank[selectedGrade].Topics[tv].Status!=0)
                        topicsUnlocked++;
                    
                }
                // if (topicsUnlocked != -1) {
                //     for (var i = 0; i < dbBank[selectedGrade].Topics.length; i++) {
                //         if(dbBank[selectedGrade].Topics[i].Status==0 || dbBank[selectedGrade].Topics[i].Status==3 || dbBank[selectedGrade].Topics[i].Status==1)
                //         {
                //             topicsUnlocked = i+1;
                //             if(topicsUnlocked >= dbBank[selectedGrade].Topics.length)
                //             topicsUnlocked -= 1;
                //             break;
                //         }
                //     }
                // }
                // $('#singleUnlockedButton').hide();
                // $('#topicsButtonsList').append("<div id='UBtn1'>"+$('#singleUnlockedButton').clone().show().html()+"</div>");
                // $('#UBtn1 .levelNum').text('11');
                // $('#UBtn1 .levelNameText').text('The quick brown fox jumps over the lazy dog.');
                // $('#UBtn1 .meterValue').text('50%');
                // $('#UBtn1 .meterBGGreen').css('width', '50%');
                // $('#UBtn1 #eachLevButton').click(function() {
                //     index_page.showPage(AppSet.pages.CoreGame, 1);
                // });

                // $('#singleLockedButton').hide();
                // $('#topicsButtonsList').append("<div id='LBtn1'>" + $('#singleLockedButton').clone().show().html() + "</div>");
                // $('#LBtn1 .levelNum').text('47');
                // $('#LBtn1 .levelNameText').text('Another quick brown fox jumps over the lazy dog.');
                // $('#LBtn1 .meterValue').text('0%');

                // to write selected grade in top bar
                $('#selectedGradeValue').text(dbBank[selectedGrade].Name);



                //Add General Score.
                if (gameService.dbGet("totalScore") == null) {
                    updateGeneralScore(totalScore);
                } else {
                    updateGeneralScore(0, true);
                }


                for (var i = 0; i < dbBank[selectedGrade].Topics.length; i++) {
                    // console.log("TName: "+dbBank[selectedGrade].Topics[i].Name);
                    uniqueTopicsList[i] = dbBank[selectedGrade].Topics[i].Name;

                }

                // to Grab Topics + Details Matrix and putting them in unlocked + locked topics bricks

                // Adding Unlocked Topic Buttons

                var gradeTopicPair;
                var completionScoreEach = 0;
                $('#singleUnlockedButton').hide();
                for (var i = 0; i < topicsUnlocked; i++) {
                    completionScoreEach = 0;
                    // Creation of topic + grade pair to find uniquely customized items per topic.
                    gradeTopicPair = selectedGrade + "|||" + uniqueTopicsList[i];
                    gradeAndTopic = gradeAndTopic;
                    console.log("GTP: " + gradeTopicPair);

                    // Getting questions current/competition status of each topic.
                    /*if (gameService.dbGet("Qstatus_" + gradeTopicPair) == null) {
                        gameService.dbSet("Qstatus_" + gradeTopicPair, "0000000000");
                        qStatuses = "0000000000";
                        console.log("QSPLIT: " + qStatuses.split('0').length);
                        completionScoreEach = 0;
        } else {
                                    qStatuses = gameService.dbGet("Qstatus_" + gradeTopicPair);
                        completionScoreEach = (10-(qStatuses.split('0').length-1))*10;
                    }

                    for (var j = 0; j < dbBank[selectedGrade].Topics[i].Questions.length; j++) {
                        if (dbBank[selectedGrade].Topics[i].Questions[j].Status >= 2)
                            completionScoreEach += 10;
                    }

                    console.log("CompletionScoreEach: " + completionScoreEach);

                    // Getting questions number of clues consumed each topic.
                    // if (gameService.dbGet("QclueCount_" + gradeTopicPair) === null) {
                    //     gameService.dbSet("QclueCount_" + gradeTopicPair, "0000000000");
                    //     clueCountofQuestions = "0000000000";
                    // } else {
                    //     clueCountofQuestions = gameService.dbGet("QclueCount_" + gradeTopicPair);
                    // }



                    $('#topicsButtonsList').append("<div id='UBtn" + i + "'>" + $('#singleUnlockedButton').clone().show().html() + "</div>");
                    $('#UBtn' + i + ' .levelNum').text((i + 1));
                    $('#UBtn' + i + ' .levelNameText').text(uniqueTopicsList[i]);
                    $('#UBtn' + i + ' .meterValueBold').text(completionScoreEach + '%');
                    $('#UBtn' + i + ' .meterBGGreen').css('width', completionScoreEach + '%');
                    $('#UBtn' + i + ' #eachLevButton').data("index", i);
                    $('#UBtn' + i + ' #eachLevButton').attr("name", "btnTopic-"+i);
                    $('#UBtn' + i + ' #eachLevButton').click(function (e) {
                       
                        console.log("I value: "+i);
                       // selectedTopic = $(e.currentTarget).data("index");
                        selectedTopic = e.currentTarget.getAttribute('name').split('-')[1];
                        console.log("THE ONE SELECTED TOPIC: " +$(e.currentTarget).data("index"));
                        console.log("SELECTED TOPIC NAME: " +$(e.currentTarget.id).id);
                        console.log("SELECTED TOPIC NAME2: " +e.currentTarget.getAttribute('name'));
                        console.log("SELECTED TOPIC NAME FFFF: " +e.currentTarget.getAttribute('name').split('-')[1]);
                      // selectedTopic = getTopicIndex(selectedGrade, uniqueTopicsList[parseInt($(e.currentTarget).data("index"))]);
                      // selectedTopic = getTopicIndex(selectedGrade, dbBank[selectedGrade].Topic[i].Name);
                    //      alert($('#UBtn' + i + ' .levelNum').text());
                      // console.log(i + ") Topic selected; " + selectedTopic);
                        index_page.showPage(AppSet.pages.CoreGame, 1);
                    });
                }


                // Adding Locked Topic Buttons
                $('#singleLockedButton').hide();
                for (var i = (topicsUnlocked); i < uniqueTopicsList.length; i++) {

                    $('#topicsButtonsList').append("<div id='LBtn" + i + "'>" + $('#singleLockedButton').clone().show().html() + "</div>");
                    $('#LBtn' + i + ' .levelNum').text((i + 1));
                    $('#LBtn' + i + ' .levelNameText').text(uniqueTopicsList[i]);
                    $('#LBtn' + i + ' .meterValue').text('0%');

                }


        */

    //  updateSound();
        $('#scoreDisplay').text(nFormatter(dbBank[selectedGrade].Score,1));

    },

    addListeners: function () {


        $("#toggleSoundButton").click(function () {
            // if ($("#toggleSoundButton").is(':disabled'))
            //     return;
            // $("#toggleSoundButton").prop('disabled', true);
            // setTimeout(function () {
            //     $("#toggleSoundButton").prop('disabled', false);
            // }, 500);
           toggleSound();
        });


        $("#gotoHomeButton").on("click",function () {
            // if ($("#gotoHomeButton").is(':disabled'))
            //     return;
            // $("#gotoHomeButton").prop('disabled', true);
            // setTimeout(function () {
            //     $("#gotoHomeButton").prop('disabled', false);
            // }, 1000);
            playSound("smallPressSound", false);
            index_page.showPage(AppSet.pages.Entry, 1);
        });


        var yesResetLock = false;
        $('#yesResetTopicButton').click(function () {
            // if ($("#yesResetTopicButton").is(':disabled'))
            //     return;
            // $("#yesResetTopicButton").prop('disabled', true);
            // setTimeout(function () {
            //     $("#yesResetTopicButton").prop('disabled', false);
            // }, 100);
            




            // dbBank[selectedGrade].Topics[selectedTopic].Status = 1;
            // dbBank[selectedGrade].Topics[selectedTopic].Lives = totalNumberOfLives;
            // dbBank[selectedGrade].Topics[selectedTopic].ClueCount = 0;
            // dbBank[selectedGrade].Topics[selectedTopic].ListOrder = [];
            // dbBank[selectedGrade].Topics[selectedTopic].Score = 0; //winningScoreGift * dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length;
            // game_page.shuffleQuestions();
    
            // for (var i = 0; i < dbBank[selectedGrade].Topics[selectedTopic].Questions.length; i++) {
            //     // dbBank[selectedGrade].Topics[selectedTopic].Score += dbBank[selectedGrade].Topics[selectedTopic].Questions[dbBank[selectedGrade].Topics[selectedTopic].ListOrder[i]].Questions[i].Score;
            //     dbBank[selectedGrade].Topics[selectedTopic].Questions[i].Score = winningScoreGift;
            //     dbBank[selectedGrade].Topics[selectedTopic].Questions[i].ClueCount = 0;
            //     dbBank[selectedGrade].Topics[selectedTopic].Questions[i].Status = 0;
            //     dbBank[selectedGrade].Topics[selectedTopic].Questions[i].Lives = totalNumberOfLives;
            //     dbBank[selectedGrade].Topics[selectedTopic].Questions[i].UserLastEntry = "0";
              
    
            // }
            // saveJSON();

            

            if(yesResetLock==false) {
                yesResetLock=true;
                playSound("smallPressSound", false);
            if ($('#popupBackground').is(":visible"))
                $('#popupBackground').hide();
            if ($('#topicResetConfirmationPopup').is(":visible"))
            animateMe('#topicResetConfirmationPopup', 'zoomOut', 0, function() { $('#topicResetConfirmationPopup').hide(); });
                resetQuestionsSwitch = true;
            index_page.showPage(AppSet.pages.CoreGame, 1);
            yesResetLock = false;
            }

        });
        $('#noResetTopicButton').click(function () {
            // if ($("#noResetTopicButton").is(':disabled'))
            //     return;
            // $("#noResetTopicButton").prop('disabled', true);
            // setTimeout(function () {
            //     $("#noResetTopicButton").prop('disabled', false);
            // }, 1000);
            playSound("smallPressSound", false);
            if ($('#popupBackground').is(":visible"))
                $('#popupBackground').hide();
            if ($('#topicResetConfirmationPopup').is(":visible"))
            animateMe('#topicResetConfirmationPopup', 'zoomOut', 300, function() { $('#topicResetConfirmationPopup').hide(); });

        });

    }
};