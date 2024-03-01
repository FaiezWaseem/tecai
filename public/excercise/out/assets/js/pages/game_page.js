var game_page = {
  pageData: {},
  previousRange: -1,

  init: function (valuePassed) {
    console.log("init page for background");
    this.pageData = JSON.parse(
      gameService.dbGet("topicPageData", '{"showIntro": true}')
    );
    this.populate();
    console.log("adding events page for background");
    this.addListeners();
    console.log("success background");
    console.log("Current page in oldPage is: " + index_page.oldPage);
    //isGamePlayOn = true;
    //  updateSound();
    if (gameService.dbGet("IsSoundOn", "NULLVALUE") == "NULLVALUE") {
      gameService.dbSet("IsSoundOn", "YES");
    }
  },

  getQuestionsOfTopic: function () {
    console.log("CCCCCCCCCCCCCCC", dbBank);
    var results = [];
    for (var k = 1; k < dataBank.length; k++) {
      if (
        dataBank[k].Topic == selectedTopic &&
        dataBank[k].Grade == selectedGrade &&
        $.inArray(dataBank[k].Ans, results) === -1
      )
        results.push(dataBank[k].Ans);
      // console.log(dataBank[k].Topic + "==" + selectedTopic);
      // console.log(dataBank[k].Grade + "==" + selectedGrade);
      // console.log((dataBank[k].Topic==selectedTopic) && (dataBank[k].Grade==selectedGrade));
    }
    return results;
  },

  getQuestionsClues: function (topicWord) {
    console.log("DDDDDDDDDDDDDDDDDDDDDDD", dbBank);
    var results = [];
    var eachResultRow = [];
    for (var k = 1; k < dataBank.length; k++) {
      if (
        dataBank[k].Topic == selectedTopic &&
        dataBank[k].Grade == selectedGrade &&
        dataBank[k].Ans == topicWord
      ) {
        eachResultRow["Ans"] = dataBank[k].Ans;
        eachResultRow["ClueType"] = dataBank[k].ClueType;
        eachResultRow["Content"] = dataBank[k].Content;
        results.push(eachResultRow);
        eachResultRow = [];
        // console.log(dataBank[k].Ans + "<=");
        // console.log(dataBank[k].ClueType + "<=");
        // console.log(dataBank[k].Content + "<=");
      }
    }
    return results;
  },

  toggleDiv: function (objectName, classNameList) {
    var element, name, arr;
    element = document.getElementById(objectName);
    name = classNameList;
    arr = element.className.split(" ");
    if (arr.indexOf(name) == -1) {
      element.className += " " + name;
    } else {
      element.className = element.className.replace(classNameList, "");
    }
  },

  addClass: function (objectName, classNameList) {
    var element, name, arr;
    element = document.getElementById(objectName);
    name = classNameList;
    arr = element.className.split(" ");
    if (arr.indexOf(name) == -1) {
      element.className += " " + name;
    }
  },

  removeClass: function (objectName, classNameList) {
    var element, name, arr;
    element = document.getElementById(objectName);
    name = classNameList;
    arr = element.className.split(" ");
    if (!arr.indexOf(name) == -1) {
      element.className = element.className.replace(classNameList, "");
    }
  },
  closeAllPopups: function () {
    if (!$("#popupBackground").is(":hidden")) $("#popupBackground").hide();
    if (!$("#noClueLeftPopup").is(":hidden")) {
      animateMe("#noClueLeftPopup", "zoomOut", 300, function () {
        $("#noClueLeftPopup").hide();
      });
    }

    if (!$("#clueConsumptionPopup").is(":hidden")) {
      animateMe("#clueConsumptionPopup", "zoomOut", 300, function () {
        $("#clueConsumptionPopup").hide();
      });
    }

    if (!$("#answerConsumptionPopup").is(":hidden")) {
      animateMe("#answerConsumptionPopup", "zoomOut", 300, function () {
        $("#answerConsumptionPopup").hide();
      });
    }
  },

  updateQUI: function (qNo) {
    qNo = qNoOld;
    //  if(
    //dbBank[selectedGrade].Topics[selectedTopic].Questions[dbBank[selectedGrade].Topics[selectedTopic].ListOrder[qNo]].Status == 0)
    // dbBank[selectedGrade].Topics[selectedTopic].Questions[dbBank[selectedGrade].Topics[selectedTopic].ListOrder[qNo]].Status = 1;
    var v = 0;
    var currentexistslockcolorchange = false;
    // $('.eachLockInTopBar').each(function (i, obj) {
    for (var qp = 0; qp < 10; qp++) {
      if (qp < dbBank[selectedGrade].Topics[selectedTopic].Questions.length) {
        $("#Qlock" + qp).show();
        if (
          dbBank[selectedGrade].Topics[selectedTopic].Questions[
            dbBank[selectedGrade].Topics[selectedTopic].ListOrder[qp]
          ].Status == "3"
        ) {
          $("#Qlock" + qp).removeClass("greyLockedIcon");
          $("#Qlock" + qp).removeClass("redLockedIcon");
          $("#Qlock" + qp).addClass("unlockedIcon");
        } else if (
          dbBank[selectedGrade].Topics[selectedTopic].Questions[
            dbBank[selectedGrade].Topics[selectedTopic].ListOrder[qp]
          ].Status == "2"
        ) {
          $("#Qlock" + qp).removeClass("greyLockedIcon");
          $("#Qlock" + qp).removeClass("unlockedIcon");
          $("#Qlock" + qp).addClass("redLockedIcon");
        } else if (
          dbBank[selectedGrade].Topics[selectedTopic].Questions[
            dbBank[selectedGrade].Topics[selectedTopic].ListOrder[qp]
          ].Status == "1"
        ) {
          $("#Qlock" + qp).removeClass("greyLockedIcon");
          $("#Qlock" + qp).removeClass("greyLockedIcon");
          $("#Qlock" + qp).removeClass("unlockedIcon");
          $("#Qlock" + qp).removeClass("redLockedIcon");
        } else {
          $("#Qlock" + qp).removeClass("unlockedIcon");
          $("#Qlock" + qp).removeClass("redLockedIcon");
          $("#Qlock" + qp).addClass("greyLockedIcon");
        }
        console.log(qp + " - " + qNoOld);
        if (qp == qNo) $("#Qlock" + qp).addClass("lockSelected");
        else $("#Qlock" + qp).removeClass("lockSelected");
      } else {
        currentexistslockcolorchange = true;
        $("#Qlock" + qp).hide();
      }

      currentexistslockcolorchange = false;
    }
    // v++;
    //});

    // $('.eachLockInTopBar').each(function (i, obj) {
    //     $(this).attr('class', 'eachLockInTopBar');
    //     if (questionslist[v] == 3) {
    //         $(this).addClass('unlockedIcon');
    //     } else if (questionslist[v] == 2) {
    //         $(this).addClass('redLockedIcon');

    //     } else if (questionslist[v] == 1) {

    //     } else {
    //         $(this).addClass('greyLockedIcon');
    //     }

    //     if (v == qNoActive)
    //         $(this).addClass('lockSelected');

    //     v++;
    // });
    v = 0;
  },

  loadQuestion: function (qNo) {
   

    console.log(
      "LoadQuestion called with qNo: " +
        qNo +
        " && qNoActive:" +
        qNoActive +
        ".."
    );
    tempTopicDataForReview = null;

    if (qNo == null || qNo == "0" || qNo == undefined) qNo = 0;

    if (qNoActive == null || qNoActive == "0" || qNoActive == undefined)
      qNoActive = 0;

    if (dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length == 0) {
      console.log("Warning: List Order Length is 0, Shuffling Qs.");
      this.shuffleQuestions();
    }

    prevQinFoc = qNo;
    dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus = qNo;

    qNoActive = dbBank[selectedGrade].Topics[selectedTopic].ListOrder[qNo];
    qNoOld = qNo;
    qNo = dbBank[selectedGrade].Topics[selectedTopic].ListOrder[qNo];

    if (
      !(dbBank[selectedGrade].Topics[selectedTopic].Score >= 0) ||
      !(dbBank[selectedGrade].Topics[selectedTopic].Lives >= 0) ||
      dbBank[selectedGrade].Topics[selectedTopic].Status >= 2
    ) {
      game_page.resetQuestionsOfThisTopic();
      console.log(
        "**** RESTTING TOPIC DATA DUE TO UNAVB OF LIVES AND/OR SCORE DETAILS ****"
      );
      if (!dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]) {
        return;
      }
      dbFromServer = dbBank[selectedGrade].Topics[selectedTopic];
    }

    if (!$("#correctAnsLabelBubble").is(":hidden")) {
      $("#correctAnsLabelBubble").hide();
    }
    dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus = qNoOld;
    console.log("Loading Question ------: " + qNoOld);

    ansList = game_page.getQuestionsOfTopic();
    cluesList = game_page.getQuestionsClues(ansList[0]);

    clueCount =
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNo].ClueCount; //("clueCount_" + selectedGrade + "_" + selectedTopic + "_" + qNo, 0);

    game_page.updateQUI(qNoOld);
    game_page.calculateDeductionScore();

    //tempTopicDataForReview = null;
    clearTimeout(clearFocusTimeout);

    // if ($('.swiper-wrapper').hasClass('centeredSliderForThreeCards'))
    //     $('.swiper-wrapper').removeClass('centeredSliderForThreeCards');
    // if ($('.swiper-wrapper').hasClass('centeredSliderForTwoCards'))
    //     $('.swiper-wrapper').removeClass('centeredSliderForTwoCards');
    // if ($('.swiper-wrapper').hasClass('centeredSliderForOneCard'))
    //     $('.swiper-wrapper').removeClass('centeredSliderForOneCard');
    // if (dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues.length == 3) {
    //     if (!$('.swiper-wrapper').hasClass('centeredSliderForThreeCards'))
    //         $('.swiper-wrapper').addClass('centeredSliderForThreeCards');
    // } else if (dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues.length == 2) {
    //     if (!$('.swiper-wrapper').hasClass('centeredSliderForTwoCards'))
    //         $('.swiper-wrapper').addClass('centeredSliderForTwoCards');

    // } else if (dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues.length == 1) {
    //     if (!$('.swiper-wrapper').hasClass('centeredSliderForOneCard'))
    //         $('.swiper-wrapper').addClass('centeredSliderForOneCard');

    // } else {
    // }
    //  if (!$('.swiper-wrapper').hasClass('centeredSliderForThreeCards'))
    //       $('.swiper-wrapper').addClass('centeredSliderForThreeCards');

    $("#qSelectedDisplay").text(
      qNoOld +
        1 +
        "/" +
        dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length
    );

    if (
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues
        .length >= defaultNumberOfCluesToShow
    )
      maxCluesAllowedPerQuestion =
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues
          .length - defaultNumberOfCluesToShow;
    else maxCluesAllowedPerQuestion = 0;

    currentScore =
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNo].Score +
      winningScoreGift;
    if (
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNo].ClueCount ==
        "0" &&
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNo].Status < 2
    )
      if (
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNo].Status == 2
      )
        //currentNumberOfClues = dbBank[selectedGrade].Topics[selectedTopic].Questions[qNo].Clues.length;
        //else
        currentNumberOfClues = 0;
      else
        currentNumberOfClues =
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNo].ClueCount;

    currentNumberOfLives = dbBank[selectedGrade].Topics[selectedTopic].Lives;
    //dbBank[selectedGrade].Topics[selectedTopic].Questions[qNo].Status = 1;
    $("#livesDisplay").text(
      nFormatter(dbBank[selectedGrade].Topics[selectedTopic].Lives)
    );
    $("#cluesDisplay").text(
      nFormatter(
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues
          .length -
          defaultNumberOfCluesToShow -
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
            .ClueCount
      )
    );
    $("#scoreDisplay").text(
      nFormatter(dbBank[selectedGrade].Topics[selectedTopic].Score)
    );
    if (
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues
        .length -
        defaultNumberOfCluesToShow -
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
          .ClueCount <
      0
    )
      $("#cluesDisplay").text("0");
    $("#answerScoreToDeduceText").text(
      "-" +
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Score
    );

    // if(dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Status >= 2)
    // {

    //     $('#cluesDisplay').text(nFormatter(dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].ClueCount));
    //     $('#livesDisplay').text(nFormatter(totalNumberOfLives - dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Lives));
    //     $('#scoreDisplay').text(nFormatter(dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Score));
    // }

    // if(dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Status >= 2) {

    //     $('#tempScoreRow').show();
    //     $('#tempScoreTotal').show();
    //     $('#currentScoreText').text(nFormatter(dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Score));
    //     $('#tempScoreChange').hide();

    // } else {

    //     $('#tempScoreRow').hide();
    //     $('#tempScorehide').show();
    //     $('#tempScoreChange').hide();
    // }
    if (
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Status >=
      2
    ) {
      console.log(
        "Locked Question - Status is " +
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNo].Status
      );

      $("#livesDisplay").text(
        dbBank[selectedGrade].Topics[selectedTopic].Lives
      ); //totalNumberOfLives -  .Questions[qNoActive]
      $("#cluesDisplay").text(
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
          .ClueCount
      );
      $("#scoreDisplay").text(
        dbBank[selectedGrade].Topics[selectedTopic].Score
      );

      if (
        Resumeables.dbFromServer &&
        UBJ_API.TrackingEnabled &&
        dbBank[selectedGrade].Name == gameService.initParams.grade &&
        selectedTopic == gameService.initParams.level - 1
      ) {
        $("#livesDisplay").text(Resumeables.dbFromServer.TopicLives);
        $("#cluesDisplay").text(
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
            .ClueCount
        );
        $("#scoreDisplay").text(Resumeables.dbFromServer.TopicScore);
      }

      $("#userEnteredAnswer").prop("disabled", true);
    }
    if (!$("#answerSection").is(":hidden")) {
      $("#noClueLeftBtnOverlay").hide();
      //Buggy line follows

      isAnimPending = true;
      animateMe("#answerSection", "slideOutDown", 300, function () {
        isAnimPending = false;
        game_page.refreshClueButton();
        $("#noClueLeftBtnOverlay").hide();
        $("#getHintButton").hide();

        if (
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
            .ClueCount +
            defaultNumberOfCluesToShow >=
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues
            .length
        ) {
          $("#getHintButton").hide();
          $("#noClueLeftBtnOverlay").show();
          $("#answerScoreToDeduceText").text(
            "-" +
              dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
                .Score
          );
        } else {
          $("#getHintButton").show();
          $("#noClueLeftBtnOverlay").hide();
        }

        //Score + Lives Wagera
        // currentScore = gameService.dbGet("currentScore_" + gradeAndTopic + "_" + qNo, 0);
        // currentNumberOfClues = gameService.dbGet("currentClues_" + gradeAndTopic + "_" + qNo, 0);
        // currentNumberOfLives = gameService.dbGet("currentLives_" + gradeAndTopic + "_" + qNo, 0);

        // $('#tempScoreTotal').text(dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Score);
        // $('#tempScoreChange').text(winningScoreGift-dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Score+'');
        // animateMe("#tempScoreRow", "zoomOut", 1200, function () { }, 4000);

        if (!$("correctAnsLabelBubble").is(":hidden")) {
          $("#correctAnsLabelBubble").hide();
        }
        if ($("#answerTypeSection").hasClass("wrongedtRealAnsBox")) {
          //  $('#answerTypeSection').removeClass('wrongedtBox');
          $("#answerTypeSection").removeClass("wrongedtRealAnsBox");

          //     //$('#answerTypeSection').text((dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Word).split('|')[0].trim());
        }

        currentScore =
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
            .TempScore;
        $("#tempScoreTotal").text(
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Score
        );
        $("#tempScoreChange").text(" ");
        if (
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNo]
            .UserLastEntry == "" ||
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNo]
            .UserLastEntry == "0" ||
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNo]
            .UserLastEntry == 0 ||
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNo]
            .UserLastEntry == null
        ) {
          $("#userEnteredAnswer").val("");
        } else {
          $("#userEnteredAnswer").val(
            dbBank[selectedGrade].Topics[selectedTopic].Questions[qNo]
              .UserLastEntry
          );
        }
        $("#popupErrorMessage").text(
          "Sorry, all possible clues of this question are consumed."
        );

        //QList
        //questionslist = getQuestionsListString(selectedGrade, selectedTopic);
        /*cluesList = getWordsandClues(dataBank, "Grade", "Topic", 1);
         */

        if (
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
            .Status >= 2
        ) {
          console.log(
            "Locked Question - Status is " +
              dbBank[selectedGrade].Topics[selectedTopic].Questions[qNo].Status
          );
          if (!$("#answerSection").hasClass("showNoClue"))
            $("#answerSection").addClass("showNoClue");

          if (
            dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
              .Status == 2
          ) {
            if (!$("#answerTypeSection").hasClass("wrongedtBox"))
              $("#answerTypeSection").addClass("wrongedtBox");
            if ($("#answerTypeSection").hasClass("correctTBox"))
              $("#answerTypeSection").removeClass("correctTBox");

            // if ($('#submitGuessButton').is(":hidden")) {
            $("#correctGuessMark").hide();
            $("#submitGuessButton").hide();
            $("#wrongGuessSButton").show();

            $(".textSubmitCombo").removeClass("correctTBoxtextSubmitCombo");

            //   }
          } else if (
            dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
              .Status == 3
          ) {
            if ($("#answerTypeSection").hasClass("wrongedtBox"))
              $("#answerTypeSection").removeClass("wrongedtBox");
            if (!$("#answerTypeSection").hasClass("correctTBox"))
              $("#answerTypeSection").addClass("correctTBox");
            // if (!$('#submitGuessButton').is(":hidden")) {
            $("#correctGuessMark").show();
            $("#submitGuessButton").hide();
            $("#wrongGuessSButton").hide();
            $(".textSubmitCombo").addClass("correctTBoxtextSubmitCombo");

            // }
          } else {
            if (!$("#answerT`peSection").hasClass("wrongedtBox"))
              $("#answerTypeSection").addClass("wrongedtBox");
            if ($("#answerTypeSection").hasClass("correctTBox"))
              $("#answerTypeSection").removeClass("correctTBox");
            //  if ($('#submitGuessButton').is(":hidden")) {
            $("#correctGuessMark").hide();
            $("#wrongGuessSButton").hide();
            $("#submitGuessButton").show();
            $(".textSubmitCombo").removeClass("correctTBoxtextSubmitCombo");
            //}
          }
        } else {
          $("#userEnteredAnswer").prop("disabled", false);
          // document.getElementById("userEnteredAnswer").disabled = false;
          console.log(
            "Unlocked Question - Status is " +
              dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
                .Status
          );
          if ($("#answerSection").hasClass("showNoClue"))
            $("#answerSection").removeClass("showNoClue");
          if ($("#answerTypeSection").hasClass("correctTBox"))
            $("#answerTypeSection").removeClass("correctTBox");
          if ($("#answerTypeSection").hasClass("wrongedtBox"))
            $("#answerTypeSection").removeClass("wrongedtBox");

          //  if ($('#submitGuessButton').is(":hidden")) {
          $("#correctGuessMark").hide();
          $("#submitGuessButton").show();
          $("#wrongGuessSButton").hide();
          $(".textSubmitCombo").removeClass("correctTBoxtextSubmitCombo");
          // }
        }

        isAnimPending = true;
        animateMe("#answerSection", "slideInUp", 300, function () {
          isAnimPending = false;
          if ($("#answerSection").is(":hidden")) $("#answerSection").show();
          $("#answerScoreToDeduceText").text(
            "-" +
              dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
                .Score
          );
          clearFocusTimeout = setTimeout(function () {
            $("#userEnteredAnswer").focus();
          }, 500);
        });
      });
    } else {
      isAnimPending = true;
      animateMe("#answerSection", "slideInUp", 300, function () {
        isAnimPending = false;
        if ($("#answerSection").is(":hidden")) $("#answerSection").show();
        clearFocusTimeout = setTimeout(function () {
          $("#userEnteredAnswer").focus();
        }, 500);
      });
    }
    console.log("Prev Range: " + this.previousRange);
    if (this.previousRange != -1) {
      // for (var cc = 0; cc < dbBank[selectedGrade].Topics[selectedTopic].Questions[this.previousRange].Clues.length; cc++) {
      for (var cc = 0; cc < 199; cc++) {
        if ($("#clueSlide" + cc).length > 0) $("#clueSlide" + cc).remove();
      }

      $("#eachCardSlide").show();
    }
    this.previousRange = qNo;

    // To add Clue Cards
    var myClone = $("#eachCardSlide").clone(); //[0];
    console.log(myClone);

    var clen =
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues
        .length + 1;
    var fAddonHintGap = true;
    console.log("*****qNoActive***** " + qNoActive);
    if (
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues
        .length <= defaultNumberOfCluesToShow ||
      true
    ) {
      clen =
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues
          .length;
      fAddonHintGap = false;
    }
    for (var cc = 0; cc < clen; cc++) {
      myClone = $("#eachCardSlide").clone();
      console.log("Clone Data: " + myClone);
      myClone[0].id = "clueSlide" + cc;
      myClone.appendTo(".swiper-wrapper");
      //$('.swiper-wrapper').append(myClone);
      $("#clueSlide" + cc + " " + ".clueNumText").html(
        '<b class="clueNoTxt shadowedFont">' + (cc + 1) + "</div>"
      );
      $("#clueSlide" + cc + " .flippedCard").prop("id", "cardcoverid" + cc);
      if (
        cc ==
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues
            .length &&
        fAddonHintGap == true
      ) {
        $(
          "#clueSlide" +
            dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
              .Clues.length
        ).css("visibility", "hidden");
        $(
          "#clueSlide" +
            dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
              .Clues.length +
            " .cardHintImage"
        ).hide();
      }
    }

    if (
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Status >=
      2
    ) {
      for (
        var ectf = defaultNumberOfCluesToShow;
        ectf <
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
          .ClueType.length;
        ectf++
      ) {
        /*    console.log("ECTF: " + ectf);
                //   dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues[f];
                 //  dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].ClueType[f];
                   console.log("Revealing Clue# " + ectf);
                   if (dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].ClueType[ectf].toLowerCase() == "image") {
                       $("#clueSlide" + ectf + " .parag").html("<div class='imageOnlyClue'>" + dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues[ectf] + '</div>');
                   } else if ((dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].ClueType[ectf]).toLowerCase() == "both") {
                       $("#clueSlide" + ectf + " .parag").html("<div class='bothClue'>" + dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues[ectf] + '</div>');
                   } else {
                       $("#clueSlide" + ectf + " .parag").html("<div class='textOnlyClue'>" + dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues[ectf] + '</div>');
                   }

                   animateMe("#clueSlide" + ectf, "flipInYb", 300, function () {


                    $('.flippedCard').removeClass('flippedCard');

                    animateMe("#clueSlide" + ectf, "flipOutYb", 500, function () {}, 500);

                });
                   */
        this.revealClue(ectf);
      }
    }

    $("#eachCardSlide").hide();
    swiper.update();

    for (var o = 0; o < defaultNumberOfCluesToShow + parseInt(clueCount); o++) {
      if (
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNo].Clues[o] !=
        null
      ) {
        if (
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNo].Clues[o]
            .length > 0
        )
          this.revealClue(o, true);
      }
    }

    swiper.slideTo(0, 1000, false);
    if (
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNo].Status == 3
    ) {
    }

    if (
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
        .ClueCount > 0 &&
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Status <
        2
    ) {
      $("#tempScoreRow").show();
      if (
        winningScoreGift -
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive] >
          0 &&
        winningScoreGift -
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive] <=
          100
      )
        $("#tempScoreChange").text(
          "-" +
            winningScoreGift -
            dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
        );
      else $("#tempScoreChange").text(" ");
      $("#tempScoreTotal").text(
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Score
      );
    } else {
      $("#tempScoreRow").hide();
    }

    if (
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Status >=
      2
    ) {
      $("#tempScoreRow").show();
      $("#tempScoreChange").text(" ");
      $("#tempScoreTotal").text(
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Score
      );
    }

    if (
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues
        .length <= 3
    ) {
      if (!$(".leftArrow").is(":hidden")) {
        $(".leftArrow").hide();
      }
      if (!$(".rightArrowOfGameScreen").is(":hidden")) {
        $(".rightArrowOfGameScreen").hide();
      }
    } else {
      if ($(".rightArrowOfGameScreen").is(":hidden")) {
        $(".rightArrowOfGameScreen").show();
      }
    }

    $("#tempScoreTotal").text(
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Score
    );

    if (
      $("#tempScoreRow").is(":hidden") &&
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Status <
        2
    ) {
      isAnimPending = true;
      animateMe(
        "#tempScoreRow",
        "flipInX",
        1000,
        function () {
          animateMe(
            "#tempScoreChange",
            "flipOutX",
            1000,
            function () {
              $("#tempScoreChange").hide();
              isAnimPending = false;
            },
            8000
          );
        },
        500
      );
    } else {
      $("#tempScoreChange").hide();
    }

    // $('#userEnteredAnswer').focus();
    // setTimeout(function () {
    //     $('#userEnteredAnswer').focus();
    // }, 1400);
  },
  reviewQuestion: function (qNo) {
    clearTimeout(clearFocusTimeout);

    if (qNo == null || qNo == "0") qNo = 0;

    tempTopicDataForReview.CurrentQuestionInFocus = qNo;

    qNoActive = tempTopicDataForReview.ListOrder[qNo];
    qNoOld = qNo;
    qNo = tempTopicDataForReview.ListOrder[qNo];

    ansList = getQuestionsOfTopic();
    cluesList = getQuestionsClues(ansList[0]);

    clueCount = tempTopicDataForReview.Questions[qNo].ClueCount; //("clueCount_" + selectedGrade + "_" + selectedTopic + "_" + qNo, 0);

    game_page.updateQUI(qNoOld);

    $("#qSelectedDisplay").text(
      qNoOld + 1 + "/" + tempTopicDataForReview.ListOrder.length
    );

    if (
      tempTopicDataForReview.Questions[qNoActive].Clues.length >=
      defaultNumberOfCluesToShow
    )
      maxCluesAllowedPerQuestion =
        tempTopicDataForReview.Questions[qNoActive].Clues.length -
        defaultNumberOfCluesToShow;
    else maxCluesAllowedPerQuestion = 0;

    currentScore =
      tempTopicDataForReview.Questions[qNo].Score + winningScoreGift;
    if (
      tempTopicDataForReview.Questions[qNo].ClueCount == "0" &&
      tempTopicDataForReview.Questions[qNo].Status < 2
    )
      if (tempTopicDataForReview.Questions[qNo].Status == 2)
        //currentNumberOfClues = tempTopicDataForReview.Questions[qNo].Clues.length;
        //else
        currentNumberOfClues = 0;
      else
        currentNumberOfClues = tempTopicDataForReview.Questions[qNo].ClueCount;

    currentNumberOfLives = tempTopicDataForReview.Lives;
    //tempTopicDataForReview.Questions[qNo].Status = 1;
    $("#livesDisplay").text(nFormatter(tempTopicDataForReview.Lives));
    $("#cluesDisplay").text(nFormatter(tempTopicDataForReview.ClueCount));
    $("#scoreDisplay").text(nFormatter(tempTopicDataForReview.Score)); //winningScoreGift-
    if (
      tempTopicDataForReview.Questions[qNoActive].Clues.length -
        defaultNumberOfCluesToShow -
        tempTopicDataForReview.Questions[qNoActive].ClueCount <
      0
    )
      $("#cluesDisplay").text("0");

    if (tempTopicDataForReview.Questions[qNoActive].Status >= 2) {
      console.log(
        "Locked Question - Status is " +
          tempTopicDataForReview.Questions[qNo].Status
      );

      $("#livesDisplay").text(tempTopicDataForReview.Lives);
      $("#cluesDisplay").text(tempTopicDataForReview.ClueCount);
      $("#scoreDisplay").text(tempTopicDataForReview.Score);

      if (
        Resumeables.dbFromServer &&
        UBJ_API.TrackingEnabled &&
        dbBank[selectedGrade].Name == gameService.initParams.grade &&
        selectedTopic == gameService.initParams.level - 1
      ) {
        $("#livesDisplay").text(tempTopicDataForReview.Lives);
        $("#cluesDisplay").text(tempTopicDataForReview.ClueCount);
        $("#scoreDisplay").text(tempTopicDataForReview.Score);
      }

      $("#userEnteredAnswer").prop("disabled", true);
    }

    if (!$("#answerSection").is(":hidden")) {
      $("#noClueLeftBtnOverlay").hide();
      $("#userEnteredAnswer").prop("disabled", true);

      isAnimPending = true;
      animateMe("#answerSection", "slideOutDown", 500, function () {
        isAnimPending = false;
        $("#noClueLeftBtnOverlay").hide();
        $("#getHintButton").hide();

        if (!$("correctAnsLabelBubble").is(":hidden")) {
          $("#correctAnsLabelBubble").hide();
        }
        if ($("#answerTypeSection").hasClass("wrongedtRealAnsBox")) {
          $("#answerTypeSection").removeClass("wrongedtRealAnsBox");
        }

        currentScore = tempTopicDataForReview.Questions[qNoActive].TempScore;
        $("#tempScoreTotal").text(
          tempTopicDataForReview.Questions[qNoActive].Score
        );
        $("#tempScoreChange").text(" ");
        if (
          tempTopicDataForReview.Questions[qNo].UserLastEntry == "" ||
          tempTopicDataForReview.Questions[qNo].UserLastEntry == "0" ||
          tempTopicDataForReview.Questions[qNo].UserLastEntry == 0 ||
          tempTopicDataForReview.Questions[qNo].UserLastEntry == null
        ) {
          $("#userEnteredAnswer").val("");
        } else {
          $("#userEnteredAnswer").val(
            tempTopicDataForReview.Questions[qNo].UserLastEntry
          );
        }
        $("#popupErrorMessage").text(
          "Sorry, all possible clues of this question are consumed."
        );

        if (tempTopicDataForReview.Questions[qNoActive].Status >= 2) {
          console.log(
            "Locked Question - Status is " +
              tempTopicDataForReview.Questions[qNo].Status
          );
          if (!$("#answerSection").hasClass("showNoClue"))
            $("#answerSection").addClass("showNoClue");

          //     $('#livesDisplay').text(totalNumberOfLives-tempTopicDataForReview.Questions[qNoActive].Lives);
          //     $('#cluesDisplay').text(tempTopicDataForReview.Questions[qNoActive].ClueCount);
          //     $('#scoreDisplay').text(tempTopicDataForReview.Score);

          //     if(Resumeables.dbFromServer && UBJ_API.TrackingEnabled && dbBank[selectedGrade].Name == gameService.initParams.grade && selectedTopic == (gameService.initParams.level-1)) {

          //         $('#livesDisplay').text(totalNumberOfLives-Score.TopicLives);
          //         $('#cluesDisplay').text(tempTopicDataForReview.Questions[qNoActive].ClueCount);
          //         $('#scoreDisplay').text(tempTopicDataForReview.Score);
          //     }

          // $("#userEnteredAnswer").prop("disabled", true);
          if (tempTopicDataForReview.Questions[qNoActive].Status == 2) {
            if (!$("#answerTypeSection").hasClass("wrongedtBox"))
              $("#answerTypeSection").addClass("wrongedtBox");
            if ($("#answerTypeSection").hasClass("correctTBox"))
              $("#answerTypeSection").removeClass("correctTBox");

            // if ($('#submitGuessButton').is(":hidden")) {
            $("#correctGuessMark").hide();
            $("#submitGuessButton").hide();
            $("#wrongGuessSButton").show();
            $(".textSubmitCombo").removeClass("correctTBoxtextSubmitCombo");

            //   }
          } else if (tempTopicDataForReview.Questions[qNoActive].Status == 3) {
            if ($("#answerTypeSection").hasClass("wrongedtBox"))
              $("#answerTypeSection").removeClass("wrongedtBox");
            if (!$("#answerTypeSection").hasClass("correctTBox"))
              $("#answerTypeSection").addClass("correctTBox");
            // if (!$('#submitGuessButton').is(":hidden")) {
            $("#correctGuessMark").show();
            $("#submitGuessButton").hide();
            $("#wrongGuessSButton").hide();
            $(".textSubmitCombo").addClass("correctTBoxtextSubmitCombo");

            // }
          } else {
            if (!$("#answerTypeSection").hasClass("wrongedtBox"))
              $("#answerTypeSection").addClass("wrongedtBox");
            if ($("#answerTypeSection").hasClass("correctTBox"))
              $("#answerTypeSection").removeClass("correctTBox");
            //  if ($('#submitGuessButton').is(":hidden")) {
            $("#correctGuessMark").hide();
            $("#submitGuessButton").show();
            $("#wrongGuessSButton").hide();
            $(".textSubmitCombo").removeClass("correctTBoxtextSubmitCombo");
            //}
          }
        } else {
          //  $("#userEnteredAnswer").prop("disabled", false);
          $("#userEnteredAnswer").prop("disabled", true);
          // document.getElementById("userEnteredAnswer").disabled = false;
          console.log(
            "Unlocked Question - Status is " +
              tempTopicDataForReview.Questions[qNoActive].Status
          );
          if ($("#answerSection").hasClass("showNoClue"))
            $("#answerSection").removeClass("showNoClue");
          if ($("#answerTypeSection").hasClass("correctTBox"))
            $("#answerTypeSection").removeClass("correctTBox");
          if ($("#answerTypeSection").hasClass("wrongedtBox"))
            $("#answerTypeSection").removeClass("wrongedtBox");

          //  if ($('#submitGuessButton').is(":hidden")) {
          $("#correctGuessMark").hide();
          $("#submitGuessButton").show();
          $("#wrongGuessSButton").hide();
          $(".textSubmitCombo").removeClass("correctTBoxtextSubmitCombo");
          // }
        }

        isAnimPending = true;
        animateMe("#answerSection", "slideInUp", 500, function () {
          isAnimPending = false;
          $("#userEnteredAnswer").prop("disabled", true);
          //$("#userEnteredAnswer").prop("disabled", false);
          $("#answerSection").show();
        });
      });
    } else {
      isAnimPending = true;
      animateMe("#answerSection", "slideInUp", 300, function () {
        isAnimPending = false;
        $("#answerSection").show();
      });
    }
    console.log("Prev Range: " + this.previousRange);
    if (this.previousRange != -1) {
      // for (var cc = 0; cc < tempTopicDataForReview.Questions[this.previousRange].Clues.length; cc++) {
      for (var cc = 0; cc < 199; cc++) {
        if ($("#clueSlide" + cc).length > 0) $("#clueSlide" + cc).remove();
      }

      $("#eachCardSlide").show();
    }
    this.previousRange = qNo;

    // To add Clue Cards
    var myClone = $("#eachCardSlide").clone(); //[0];
    console.log(myClone);

    var clen = tempTopicDataForReview.Questions[qNoActive].Clues.length + 1;
    var fAddonHintGap = true;
    console.log("*****qNoActive***** " + qNoActive);
    if (
      tempTopicDataForReview.Questions[qNoActive].Clues.length <=
        defaultNumberOfCluesToShow ||
      true
    ) {
      clen = tempTopicDataForReview.Questions[qNoActive].Clues.length;
      fAddonHintGap = false;
    }
    for (var cc = 0; cc < clen; cc++) {
      myClone = $("#eachCardSlide").clone();
      console.log("Clone Data: " + myClone);
      myClone[0].id = "clueSlide" + cc;
      myClone.appendTo(".swiper-wrapper");
      //$('.swiper-wrapper').append(myClone);
      $("#clueSlide" + cc + " " + ".clueNumText").html(
        '<b class="clueNoTxt shadowedFont">' + (cc + 1) + "</div>"
      );
      $("#clueSlide" + cc + " .flippedCard").prop("id", "cardcoverid" + cc);
      if (
        cc == tempTopicDataForReview.Questions[qNoActive].Clues.length &&
        fAddonHintGap == true
      ) {
        $(
          "#clueSlide" +
            tempTopicDataForReview.Questions[qNoActive].Clues.length
        ).css("visibility", "hidden");
        $(
          "#clueSlide" +
            tempTopicDataForReview.Questions[qNoActive].Clues.length +
            " .cardHintImage"
        ).hide();
      }
    }

    if (tempTopicDataForReview.Questions[qNoActive].Status >= 2) {
      for (
        var ectf = defaultNumberOfCluesToShow;
        ectf < tempTopicDataForReview.Questions[qNoActive].ClueType.length;
        ectf++
      ) {
        this.revealClue(ectf);
      }
    }

    $("#eachCardSlide").hide();
    swiper.update();

    for (var o = 0; o < defaultNumberOfCluesToShow + parseInt(clueCount); o++) {
      if (tempTopicDataForReview.Questions[qNo].Clues[o] != null) {
        if (tempTopicDataForReview.Questions[qNo].Clues[o].length > 0)
          this.revealClue(o, true);
      }
    }

    swiper.slideTo(0, 1000, false);
    if (tempTopicDataForReview.Questions[qNo].Status == 3) {
    }

    if (
      tempTopicDataForReview.Questions[qNoActive].ClueCount > 0 &&
      tempTopicDataForReview.Questions[qNoActive].Status < 2
    ) {
      $("#tempScoreRow").show();
      if (
        winningScoreGift - tempTopicDataForReview.Questions[qNoActive] > 0 &&
        winningScoreGift - tempTopicDataForReview.Questions[qNoActive] <= 100
      )
        $("#tempScoreChange").text(
          "-" + winningScoreGift - tempTopicDataForReview.Questions[qNoActive]
        );
      else $("#tempScoreChange").text(" ");
      $("#tempScoreTotal").text(
        tempTopicDataForReview.Questions[qNoActive].Score
      );
    } else {
      $("#tempScoreRow").hide();
    }

    if (tempTopicDataForReview.Questions[qNoActive].Clues.length <= 3) {
      if (!$(".leftArrow").is(":hidden")) {
        $(".leftArrow").hide();
      }
      if (!$(".rightArrowOfGameScreen").is(":hidden")) {
        $(".rightArrowOfGameScreen").hide();
      }
    } else {
      if ($(".rightArrowOfGameScreen").is(":hidden")) {
        $(".rightArrowOfGameScreen").show();
      }
    }

    $("#tempScoreTotal").text(
      tempTopicDataForReview.Questions[qNoActive].Score
    );

    isAnimPending = true;
    if (
      $("#tempScoreRow").is(":hidden") &&
      tempTopicDataForReview.Questions[qNoActive].Status < 2
    ) {
      animateMe(
        "#tempScoreRow",
        "flipInX",
        1000,
        function () {
          animateMe(
            "#tempScoreChange",
            "flipOutX",
            1000,
            function () {
              isAnimPending = false;
              $("#tempScoreChange").hide();
            },
            8000
          );
        },
        500
      );
    } else {
      $("#tempScoreChange").hide();
    }
  },

  showErrorPopup: function (textToShow) {
    this.closeAllPopups();
    $("#popupBackground").show();
    $("#noClueLeftPopup").show();
    playSound("errorPopupSound", false);
    if (textToShow == null) {
      $("#popupErrorMessage").text(
        "Sorry, all possible clues of this question are consumed."
      );
    } else {
      $("#popupErrorMessage").text(textToShow);
    }

    isAnimPending = true;
    animateMe("#noClueLeftPopup", "zoomIn", 300, function () {
      isAnimPending = false;
    });
  },

  revealClue: function (num, deductScore) {
    if (num >= 0 && $("#clueSlide" + num).length > 0) {
      console.log("Revealing Clue# " + num);

      if (
        dbBank[selectedGrade].Topics[selectedTopic].Questions[
          qNoActive
        ].ClueType[num].toLowerCase() == "image"
      ) {
        $("#clueSlide" + num + " .parag").html(
          "<div class='imageOnlyClue'>" +
            dbBank[selectedGrade].Topics[selectedTopic].Questions[
              qNoActive
            ].Clues[num].trim() +
            "</div>"
        );
      } else if (
        dbBank[selectedGrade].Topics[selectedTopic].Questions[
          qNoActive
        ].ClueType[num].toLowerCase() == "both"
      ) {
        $("#clueSlide" + num + " .parag").html(
          "<div class='bothClue'>" +
            dbBank[selectedGrade].Topics[selectedTopic].Questions[
              qNoActive
            ].Clues[num].trim() +
            "</div>"
        );
      } else if (
        dbBank[selectedGrade].Topics[selectedTopic].Questions[
          qNoActive
        ].ClueType[num].toLowerCase() == "audio"
      ) {
        $("#clueSlide" + num + " .parag").html(
          `<div class="audioOnlyClue">
            <button
              id=${num}-clueAudioButton
              class="bubblyButton   smallBubblyButtonAudioOnly lessBordered sizeForTopMenu"
             
              audioSrc= ${dbBank[selectedGrade].Topics[selectedTopic].Questions[
                qNoActive
              ].Clues[num].trim()}
            >
              <span id=${num}-clueAudioButton class="lessBordered" audioSrc= ${dbBank[
            selectedGrade
          ].Topics[selectedTopic].Questions[qNoActive].Clues[num].trim()} >
          <div class="bubble bubbleAudioClueOnly"></div>
                <div id=${num}-clueAudioButton audioSrc= ${dbBank[
            selectedGrade
          ].Topics[selectedTopic].Questions[qNoActive].Clues[
            num
          ].trim()} class="soundIcon soundIconMain playOn soundIconPlayAudioOnly "  >
                </div>
              </span>
            </button>
         
            
             
              
         
      
          </div>`
        );
      } else if (
        dbBank[selectedGrade].Topics[selectedTopic].Questions[
          qNoActive
        ].ClueType[num].toLowerCase() == "textandaudio"
      ) {
        const audioAndText =
          dbBank[selectedGrade].Topics[selectedTopic].Questions[
            qNoActive
          ].Clues[num].trim();

        const splitBoth = audioAndText.split("%$#@!");
        const audioValue = splitBoth[0];
        const textValue = splitBoth[1];
        $("#clueSlide" + num + " .parag").html(
          `<div class="textAndAudioClue">
          <button
        
          id=${num}-clueTextAndAudioButton
          class="bubblyButton bubbleButtonAllClue  smallBubblyButtonAudio lessBordered sizeForTopMenu"

          audioSrc =  ${audioValue}
        >
          <span id=${num}-clueTextAndAudioButton audioSrc =  ${audioValue} class=" lessBordered">
          <div class="bubble bubbleAudioClue"></div>
            <div  id=${num}-clueTextAndAudioButton  class="soundIcon soundIconMain playOn soundIconPlay" audioSrc =  ${audioValue}>
               
                </div>
              </span>
            </button><br/>
            <span>${textValue}</span>
          </div>`
        );
      } else if (
        dbBank[selectedGrade].Topics[selectedTopic].Questions[
          qNoActive
        ].ClueType[num].toLowerCase() == "all"
      ) {
        const all =
          dbBank[selectedGrade].Topics[selectedTopic].Questions[
            qNoActive
          ].Clues[num].trim();

        const splitAll = all.split("%$#@!");
        const audioValue = splitAll[0];
        const imageAndText = splitAll[1];
        console.log("splitAll", splitAll);
        $("#clueSlide" + num + " .parag").html(
          `<div class="textAndAudioClue">
          <button
          id=${num}-clueAllButton
          audioSrc =  ${audioValue}
          class="bubblyButton bubbleButtonAllClue  smallBubblyButtonAudio lessBordered sizeForTopMenu"
        >
          <span  id=${num}-clueAllButton class=" lessBordered" audioSrc =  ${audioValue}>
          <div class="bubble bubbleAudioClue"></div>
            <div id=${num}-clueAllButton class="soundIcon soundIconMain  playOn soundIconPlay" audioSrc =  ${audioValue}>
                
                </div>
              </span>
            </button>
           ${imageAndText}
          </div>`
        );
      } else {
        $("#clueSlide" + num + " .parag").html(
          "<div class='textOnlyClue'>" +
            dbBank[selectedGrade].Topics[selectedTopic].Questions[
              qNoActive
            ].Clues[num].trim() +
            "</div>"
        );
        // $("#clueSlide" + num + " .parag").html(dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues[num]);
      }

      // $("#clueSlide" + num + " .bodyClueCard").removeClass('flippedCard');
      if (num >= defaultNumberOfCluesToShow && num > 1) {
        swiper.slideTo(num - 1, 1000, false);
      }

      // if (dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].ClueCount > 0)
      // {
      //     game_page.showAnimationScoreDeduction(num);
      // }

      isAnimPending = true;

      animateMe("#clueSlide" + num, "flipInYb", 300, function () {
        $("#clueSlide" + num).addClass("backFaceEnabled");
        $("#cardcoverid" + num).hide();
        try {
          MathJax.Hub.Queue([
            "Typeset",
            MathJax.Hub,
            $("#clueSlide" + num + " .parag")[0],
          ]);
          //MathJax.Hub.Queue(["Delay", MathJax.Callback, 200], onCompleteCallback);
        } catch (e) {
          console.log(e);
        }
        animateMe("#clueSlide" + num, "flipOutYb", 300, function () {
          isAnimPending = false;
          $("#clueSlide" + num).removeClass("backFaceEnabled");
        });
      });

      if (num == 2) {
        $(".leftArrow").hide();
      }
      // if(deductScore==true)
      // {
      //     dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].ClueCount++;
      // }
    }

    //clearFocusTimeout = setTimeout(function(){ $('#userEnteredAnswer').focus(); } , 500);
  },
  reduceLife: function (qNoActive, qNoOld) {
    if (
      dbBank[selectedGrade].Topics[selectedTopic].Lives > 0 &&
      enforcedSurrender == false
    ) {
      clearTimeout(clearFocusTimeout);
      dbBank[selectedGrade].Topics[selectedTopic].Lives--;
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Lives--;
      // dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Score-=scoreDeductionPerLife;
      // currentScore = dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Score;
      currentNumberOfLives = dbBank[selectedGrade].Topics[selectedTopic].Lives;
      $("#livesDisplay").text(
        nFormatter(dbBank[selectedGrade].Topics[selectedTopic].Lives)
      );
      // $('#scoreDisplay').text(currentScore);
      $("#lifeNotifierDisplay").show();
      /*.toggleClass("animate fadeOutUp", function() {
                        $(this).remove();
                    });*/
      // $('#submitGuessButton').prop('disabled', true);
      $("#getHintButton").prop("disabled", true);
      //        var animSpeedToggle = 2000;
      //          if(currentNumberOfLives<=0)
      //            animSpeedToggle = 0;
      isAnimPending = true;
      animateMe("#lifeNotifierDisplay", "fadeOutUp", 1500, function () {
        $("#lifeNotifierDisplay").hide();
        clearFocusTimeout = setTimeout(function () {
          $("#userEnteredAnswer").focus();
        }, 500);
        isAnimPending = false;
        // $('#submitGuessButton').prop('disabled', false);
        $("#getHintButton").prop("disabled", false);
      });
    } else {
      if (
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
          .Lives == 0 ||
        true
      ) {
        dbBank[selectedGrade].Topics[selectedTopic].Questions[
          qNoActive
        ].Score = 0;
      }
      //            dbBank[selectedGrade].Topics[selectedTopic].Lives = 0;
      //          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Lives = 0;
      currentNumberOfLives = dbBank[selectedGrade].Topics[selectedTopic].Lives;
      // if(dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Lives < 0)
      //     dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Liv
      dbBank[selectedGrade].Topics[selectedTopic].Questions[
        qNoActive
      ].Status = 2;
      dbBank[selectedGrade].Topics[selectedTopic].Questions[
        qNoActive
      ].UserLastEntry = $("#userEnteredAnswer").val().trim();

      // if (dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Status == 2)
      //     dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Score = 0;

      //   animateMe('#lifeNotifierDisplay', 'fadeOutUp', 2000, function () {
      $("#lifeNotifierDisplay").hide();
      // $('#submitGuessButton').prop('disabled', false);
      $("#getHintButton").prop("disabled", false);
      es = 0;
      $("#livesDisplay").text(
        dbBank[selectedGrade].Topics[selectedTopic].Lives
      );

      game_page.evaluateQs();
      setTimeout(game_page.showResultPopup(0, qNoActive, qNoOld), 300);

      //  game_page.evaluateAllAnswers(qNoActive, qNoOld);
      // });

      enforcedSurrender = false;
    }
  },
  showResultPopup: function (resultStatus, qNoActive, qNoOld) {
    if ($("#popupBackground").is(":hidden")) {
      $("#popupBackground").show();
    }
    if (!$("#clueConsumptionPopup").is(":hidden")) {
      $("#clueConsumptionPopup").hide();
    }
    if (!$("#answerConsumptionPopup").is(":hidden")) {
      $("#answerConsumptionPopup").hide();
    }
    if (!$("#noClueLeftPopup").is(":hidden")) {
      $("#noClueLeftPopup").hide();
    }
    if (!$("#pausePopup").is(":hidden")) {
      $("#pausePopup").hide();
    }
    if (!$("#completeResultPopup").is(":hidden")) {
      $("#completeResultPopup").hide();
    }
    $("#singleResultPopup").show();
    isAnimPending = true;
    animateMe("#singleResultPopup", "zoomIn", 500, function () {
      isAnimPending = false;
    });

    // $("#wordResultOKBtn").prop('disabled', true);
    // setTimeout(function () {
    //     $("#wordResultOKBtn").prop('disabled', false);
    // }, 1000);

    if (resultStatus == 1) {
      if ($("#correctText").hasClass("incorrectRibbon"))
        $("#correctText").removeClass("incorrectRibbon");
      $("#wordResultTitleTextDisp").text("Correct!");
      $("#wordIntroTextPopup").text("The word is");
    } else {
      playSound("loseQuestionSound", false);
      if (!$("#correctText").hasClass("incorrectRibbon"))
        $("#correctText").addClass("incorrectRibbon");
      $("#wordResultTitleTextDisp").text("Oops!");
      $("#wordIntroTextPopup").text("The word was");
    }

    $("#wordCorrectDisp").text(
      dbBank[selectedGrade].Topics[selectedTopic].Questions[
        qNoActive
      ].Word.split("|")[0]
    );
    //  if (dbBank[selectedGrade].Topics[selectedTopic].Lives == 0) {
    //         $('#lifeDisplayWordResult').text('0');
    // } else {
    $("#lifeDisplayWordResult").text(
      totalNumberOfLives -
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Lives
    );
    //  }
    $("#clueDisplayWordResult").text(
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].ClueCount
    );
    if (
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Score > 0
    )
      $("#scoreDisplayWordResult").text(
        "+" +
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Score
      );
    else
      $("#scoreDisplayWordResult").text(
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Score
      );

    console.log(
      "Score: " +
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Score
    );
    //  $('#scoreMinusLivesDisplay').text(parseInt(dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Lives)*parseInt(scoreDeductionPerLife));
    $("#scoreMinusCluesDisplay").text(
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Score -
        winningScoreGift
    );
    if (
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
        .ClueCount == 0
    ) {
      $("#clueScoreDeductionDisplay").hide();
    } else {
      $("#clueScoreDeductionDisplay").show();
    }

    if (dbBank[selectedGrade].Topics[selectedTopic].Status >= 2) {
      // saveJSON();
    }
  },
  showOverallResultPopup: function (qNoActive, qNoOld) {
    if ($("#popupBackground").is(":hidden")) {
      $("#popupBackground").show();
    }
    if (!$("#clueConsumptionPopup").is(":hidden")) {
      $("#clueConsumptionPopup").hide();
    }
    if (!$("#answerConsumptionPopup").is(":hidden")) {
      $("#answerConsumptionPopup").hide();
    }
    if (!$("#noClueLeftPopup").is(":hidden")) {
      $("#noClueLeftPopup").hide();
    }
    if (!$("#pausePopup").is(":hidden")) {
      $("#pausePopup").hide();
    }
    if (!$("#singleResultPopup").is(":hidden")) {
      $("#singleResultPopup").hide();
    }
    if (!$("#completeResultNextBtn").is(":hidden")) {
      $("#completeResultNextBtn").show();
    }

    $("#completeResultPopup").show();
    animateMe("#completeResultPopup", "zoomIn", 300, function () {});

    console.log("Correct ans in topic: " + completionQScore);

    var resultStatus = -1;

    if (
      (completionQScore /
        dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length) *
        100 >=
      winningPercentage
    ) {
      resultStatus = 1;
    } else {
      resultStatus = -1;
    }

    console.log("ResultStatus: " + resultStatus);
    if (resultStatus == -1) {
      playSound("loseTopicSound", false);
      if (!$("#overallResultPopupRibbon").hasClass("incorrectRibbon"))
        $("#overallResultPopupRibbon").addClass("incorrectRibbon");
      $("#overallResultTitleTextDisplay").text("Ouch!");
      if (completionQScore == 0)
        $("#overallResultSubTextDisplay").html(
          "<b>You are not able to guess any word!</b>"
        );
      else
        $("#overallResultSubTextDisplay").html(
          "<b>You are only able to guess <strong>" +
            completionQScore +
            "/" +
            dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length +
            "</strong> words!</b>"
        );
      dbBank[selectedGrade].Topics[selectedTopic].Status = 2;
      $("#nextbtnOverallDiv").hide();
    } else {
      playSound("winTopicSound", false);
      if ($("#overallResultPopupRibbon").hasClass("incorrectRibbon"))
        $("#overallResultPopupRibbon").removeClass("incorrectRibbon");
      $("#overallResultTitleTextDisplay").text("Great!");
      $("#overallResultSubTextDisplay").html(
        "<b>You have guessed <strong>" +
          completionQScore +
          "/" +
          dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length +
          "</strong> words correctly!</b>"
      );
      dbBank[selectedGrade].Topics[selectedTopic].Status = 3;
      if (selectedTopic < dbBank[selectedGrade].Topics.length - 1) {
        if (
          dbBank[selectedGrade].Topics[parseInt(parseInt(selectedTopic) + 1)]
            .Status == 0
        ) {
          dbBank[selectedGrade].Topics[
            parseInt(parseInt(selectedTopic) + 1)
          ].Status = 1;
        }
      }
      // else {

      //     $('#popupBackground').show();
      //     $('#victoryPopup').show();
      // }
    }

    //$('#wordCorrectDisp').text(dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Word.split("|")[0]);
    $("#overallResulLivesDisplayText").text(
      totalNumberOfLives - dbBank[selectedGrade].Topics[selectedTopic].Lives
    );
    $("#overallResultCluesDisplayText").text(completionTotalClues);
    $("#overallscoreIncludedDisplayText").text(completionTotalScore);
    tempTopicDataForReview.Score = completionTotalScore;
    tempTopicDataForReview.ClueCount = completionTotalClues;
    //  $('#scoreMinusLivesDisplayO').text(parseInt(dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Lives)*parseInt(scoreDeductionPerLife));
    //$('#scoreMinusCluesDisplayO').text(dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].ClueCount * (scoreDeductionPerClue * -1));
    $("#completeResultHomeBtn").click(function () {
      $("#popupBackground").hide();
      $("#completeResultPopup").hide();
      playSound("smallPressSound", false);
      index_page.showPage(AppSet.pages.Topic, 1);
    });
    $("#completeResultNextBtn").click(function () {
      playSound("goPressSound", false);
      if ($("#completeResultNextBtn").is(":disabled")) return;
      $("#completeResultNextBtn").prop("disabled", true);
      setTimeout(function () {
        $("#completeResultNextBtn").prop("disabled", false);
      }, 1000);

      reviewModeOn = false;
      console.log("Current Topic# before Moving to Next: " + selectedTopic);
      $("#popupBackground").hide();
      $("#completeResultPopup").hide();
      selectedTopic++;

      if (selectedTopic >= dbBank[selectedGrade].Topics.length) {
        $("#popupBackground").show();
        $("#victoryPopup").show();
        animateMe("#victoryPopup", "zoomIn", 300, function () {});
        selectedTopic--;
      } else {
        // selectedTopic++;
        game_page.populate();
        return;
      }
      // if (selectedTopic < (dbBank[selectedGrade].Topics.length)) {

      //     while (dbBank[selectedGrade].Topics[selectedTopic].Status > 1 && (selectedTopic < dbBank[selectedGrade].Topics.length-1))
      //         selectedTopic++;

      //     if (selectedTopic >= (dbBank[selectedGrade].Topics.length)) {

      //         $('#popupBackground').show();
      //         $('#victoryPopup').show();
      //         animateMe("#victoryPopup", "zoomIn", 300, function() { });
      //     } else {
      //     game_page.populate();
      // }
      // } else {

      //     $('#popupBackground').show();
      //     $('#victoryPopup').show();
      // }
      // game_page.loadQuestion(0);
      //index_page.showPage(AppSet.pages.CoreGame, 1);
    });
    $("#completeResultRetryButton").click(function () {
      $("#popupBackground").hide();

      $("#completeResultRetryButton").prop("disabled", true);
      setTimeout(function () {
        $("#completeResultRetryButton").prop("disabled", false);
      }, 1000);
      animateMe("#completeResultPopup", "zoomOut", 300, function () {
        $("#completeResultPopup").hide();
      });
      reviewModeOn = false;
      playSound("smallPressSound", false);
      //tempTopicDataForReview = null;
      dbFromServer = [];
      // for (var v = 0; v < dbBank[selectedGrade].Topics[parseInt(selectedTopic)].Questions.length; v++) {
      //     dbBank[selectedGrade].Topics[parseInt(selectedTopic)].Questions[v].Status = 0;
      //     dbBank[selectedGrade].Topics[parseInt(selectedTopic)].Questions[v].Lives = totalNumberOfLives;
      //     dbBank[selectedGrade].Topics[parseInt(selectedTopic)].Questions[v].UserLastEntry = "0";
      //     dbBank[selectedGrade].Topics[parseInt(selectedTopic)].Questions[v].Score = winningScoreGift;
      // }

      // dbBank[selectedGrade].Topics[parseInt(selectedTopic)].Lives = totalNumberOfLives;
      // dbBank[selectedGrade].Topics[parseInt(selectedTopic)].Status = 1;
      // dbBank[selectedGrade].Topics[parseInt(selectedTopic)].ListOrder = [];
      // dbBank[selectedGrade].Topics[parseInt(selectedTopic)].CurrentQuestionInFocus = 0;
      game_page.resetQuestionsOfThisTopic();
      // game_page.shuffleQuestions();

      game_page.loadQuestion(0);
      // return;
    });
    $("#reviewOverallButton").click(function () {
      $("#popupBackground").hide();

      $("#reviewOverallButton").prop("disabled", true);
      setTimeout(function () {
        $("#reviewOverallButton").prop("disabled", false);
      }, 1000);
      animateMe("#completeResultPopup", "zoomOut", 300, function () {
        $("#completeResultPopup").hide();
      });
      reviewModeOn = true;

      playSound("smallPressSound", false);
      //dbBank[selectedGrade].Topics[selectedTopic] =  tempTopicDataForReview;
      prevQinFoc = 0;
      game_page.reviewQuestion(0);
      return;
    });

    if (
      UBJ_API?.initParams?.islmsplayer == 1 ||
      UBJ_API?.initParams?.is_offline_lms == 1 ||
      UBJ_API?.initParams?.is_postbookmarking == 1
    ) {
      UBJ_API.SubmitGameScore(
        tempTopicDataForReview?.Score,
        100,
        UBJ_API.COMPLETION_STATUS.COMPLETED,
        UBJ_API.GetTimeDifference() / 1000,
        {},
        dbBank,
        dbBank[selectedGrade].Topics[selectedTopic].Questions
      );
    } else {
      UBJ_API.SubmitGameScore(
        tempTopicDataForReview?.Score,
        100,
        UBJ_API.COMPLETION_STATUS.COMPLETED,
        UBJ_API.GetTimeDifference() / 1000,
        {}
      );
    }
  },
  // evaluateAllAnswers: function (qNoActive, qNoOld) {

  //     //console.log("Moving to question " + qNoOld + " Now");

  // },
  evaluateAnswer: function (userEntered) {
    var isAnswerCorrect = false;
    var lifeReducedFlag = false;

    // qNoActive
    var ansArray =
      dbBank[selectedGrade].Topics[selectedTopic].Questions[
        qNoActive
      ].Word.split("|");
    if (userEntered == "" || userEntered == null) {
      this.showErrorPopup("Please enter answer before submission!");
    } else {
      for (var v = 0; v < ansArray.length; v++) {
        if (ansArray[v].toLowerCase().trim() == userEntered) {
          isAnswerCorrect = true;
          console.log("Correct Answer!");
          break;
        }
      }

      if (isAnswerCorrect == true) {
        console.log("Correct Ans# of " + qNoActive);
        dbBank[selectedGrade].Topics[selectedTopic].Questions[
          qNoActive
        ].Status = 3;

        playSound("winQuestionSound", false);
        dbBank[selectedGrade].Topics[selectedTopic].Questions[
          qNoActive
        ].UserLastEntry = "" + userEntered;
        console.log("Going in evalAllN " + qNoActive);

        // game_page.evaluateAllAnswers(qNoActive, qNoOld);
        game_page.evaluateQs();

        animateMe("#userEnteredAnswer", "pulse", 400, function () {
          game_page.showResultPopup(1, qNoActive, qNoOld);
          pressedAlreadyFlag = false;
        });

        dbBank[selectedGrade].Topics[selectedTopic].Score +=
          dbBank[selectedGrade].Topics[selectedTopic].Questions[
            qNoActive
          ].Score;
          if (UBJ_API?.initParams?.is_postbookmarking) {
            UBJ_API.SubmitGameScore(
              tempTopicDataForReview?.Score,
              100,
              UBJ_API.COMPLETION_STATUS.INCOMPLETE,
              UBJ_API.GetTimeDifference() / 1000,
              {},
              dbBank,
              dbBank[selectedGrade].Topics[selectedTopic].Questions
            );
          }
      } else {
        playSound("wrongBuzzSound", false);
        game_page.reduceLife(qNoActive, qNoOld);
        animateMe("#userEnteredAnswer", "shake", 300, function () {
          lifeReducedFlag = true;
          // saveJSON();
          pressedAlreadyFlag = false;
        });

        console.log("Incorrect Answer!");
      }

      $("#livesDisplay").text(
        dbBank[selectedGrade].Topics[selectedTopic].Lives
      );
      $("#cluesDisplay").text(
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues
          .length -
          defaultNumberOfCluesToShow -
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
            .ClueCount
      );
      if (
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues
          .length -
          defaultNumberOfCluesToShow -
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
            .ClueCount <
        0
      )
        $("#cluesDisplay").text("0");
      // $('#scoreDisplay').text(currentScore);
    }
   
    game_page.evaluateQs();

    //  if(lifeReducedFlag==true)
    //      saveJSON();
    //  lifeReducedFlag = false;
  },
  shuffleQuestions: function () {
    console.log("ShuffleQuestions Called in!");
    var tempQOrder = [];
    //   if(dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length==0) {
    for (
      var v = 0;
      v < dbBank[selectedGrade].Topics[selectedTopic].Questions.length;
      v++
    ) {
      // tempQOrder.push()
      // dbBank[selectedGrade].Topics[selectedTopic].ListOrder.push(dbBank[selectedGrade].Topics[selectedTopic].Questions.length-v);

      tempQOrder[v] = v;
    }
    var tmpQQQvv;
    var randFactorQ;
    for (
      var v = 0;
      v < dbBank[selectedGrade].Topics[selectedTopic].Questions.length;
      v++
    ) {
      // tempQOrder.push()
      // dbBank[selectedGrade].Topics[selectedTopic].ListOrder.push(dbBank[selectedGrade].Topics[selectedTopic].Questions.length-v);
      randFactorQ = Math.floor(
        Math.random() *
          dbBank[selectedGrade].Topics[selectedTopic].Questions.length
      );
      tmpQQQvv = tempQOrder[v];
      tempQOrder[v] = tempQOrder[randFactorQ];
      tempQOrder[randFactorQ] = tmpQQQvv;
    }

    if (tempQOrder.length > 10) tempQOrder = tempQOrder.slice(0, 10);

    dbBank[selectedGrade].Topics[selectedTopic].ListOrder = tempQOrder;
    saveJSON();
  },
  resetQuestionsOfThisTopic: function () {
    tempTopicDataForReview = null;
    dbBank[selectedGrade].Topics[selectedTopic].Status = 1;
    console.log(
      "RESETTING - BEFORE LIVES: " +
        dbBank[selectedGrade].Topics[selectedTopic].Lives
    );
    dbBank[selectedGrade].Topics[selectedTopic].Lives = totalNumberOfLives;
    console.log(
      "RESETTING - AFTER LIVES: " +
        dbBank[selectedGrade].Topics[selectedTopic].Lives
    );
    dbBank[selectedGrade].Topics[selectedTopic].ClueCount = 0;
    dbBank[selectedGrade].Topics[selectedTopic].ListOrder = [];
    dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus = 0;
    dbBank[selectedGrade].Topics[selectedTopic].Score = 0; //winningScoreGift * dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length;
    this.shuffleQuestions();

    for (
      var i = 0;
      i < dbBank[selectedGrade].Topics[selectedTopic].Questions.length;
      i++
    ) {
      // dbBank[selectedGrade].Topics[selectedTopic].Score += dbBank[selectedGrade].Topics[selectedTopic].Questions[dbBank[selectedGrade].Topics[selectedTopic].ListOrder[i]].Questions[i].Score;
      dbBank[selectedGrade].Topics[selectedTopic].Questions[i].Score =
        winningScoreGift;
      dbBank[selectedGrade].Topics[selectedTopic].Questions[i].ClueCount = 0;
      dbBank[selectedGrade].Topics[selectedTopic].Questions[i].Status = 0;
      dbBank[selectedGrade].Topics[selectedTopic].Questions[i].Lives =
        totalNumberOfLives;
      dbBank[selectedGrade].Topics[selectedTopic].Questions[i].UserLastEntry =
        "0";

      // dbBank[selectedGrade].Topics[selectedTopic].Questions[dbBank[selectedGrade].Topics[selectedTopic].ListOrder[i]].Score = winningScoreGift;
      // dbBank[selectedGrade].Topics[selectedTopic].Questions[dbBank[selectedGrade].Topics[selectedTopic].ListOrder[i]].ClueCount = 0;
      // dbBank[selectedGrade].Topics[selectedTopic].Questions[dbBank[selectedGrade].Topics[selectedTopic].ListOrder[i]].Status = 0;
      // dbBank[selectedGrade].Topics[selectedTopic].Questions[dbBank[selectedGrade].Topics[selectedTopic].ListOrder[i]].Lives = totalNumberOfLives;
      // dbBank[selectedGrade].Topics[selectedTopic].Questions[dbBank[selectedGrade].Topics[selectedTopic].ListOrder[i]].UserLastEntry = "0";
    }
    saveJSON();
    // this.loadQuestion(0);
  },
  populate: function () {
    qNoActive = 0;
    qNoOld = 0;
    qNo = 0;
    console.log(
      "Populated with defaultQ: " +
        dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus
    );
    tempTopicDataForReview = null;
    reviewModeOn = false;
    if (resetQuestionsSwitch == true) {
      console.log("ResetModeActivated");
      resetQuestionsSwitch = false;
      this.resetQuestionsOfThisTopic();
    }

    //Slider Init + Popups Hide ----- Start
    if (gameService.dbGet("IsSoundOn", "NO") == "YES") {
      if (currentBGTrack == "entry_bg_sound") {
        gameService.stopSound("entry_bg_sound", true);
        gameService.playSound("bg_sound", true);
        currentBGTrack = "bg_sound";
      } else {
      }
    } else {
      gameService.stopSound("entry_bg_sound", true);
      gameService.stopSound("bg_sound", true);
    }

    //$("#gotoHomeButton").prop('disabled', false);
    $("#toggleSoundButton").prop("disabled", false);
    $("#submitGuessButton").prop("disabled", false);
    $("#answerSection").removeClass("showNoClue");
    $("#answerTypeSection").removeClass("wrongedtBox");
    if (!$("#popupBackground").is(":hidden")) $("#popupBackground").hide();
    $("#clueConsumptionPopup").hide();
    $("#answerConsumptionPopup").hide();
    $("#pausePopup").hide();
    $("#singleResultPopup").hide();
    $("#completeResultPopup").hide();
    $("#noClueLeftPopup").hide();
    $("#correctGuessMark").hide();
    $("#wrongGuessSButton").hide();
    $("#lifeNotifierDisplay").hide();
    $("#tempScoreRow").hide();
    $("#victoryPopup").hide();
    $("#correctAnsLabelBubble").hide();
    UBJ_API.InitTimer();
    //           if (dbBank[selectedGrade].Topics[selectedTopic].Status <= 2)

    if (
      Resumeables.dbFromServer &&
      UBJ_API.TrackingEnabled &&
      dbBank[selectedGrade].Name == gameService.initParams.grade &&
      selectedTopic == gameService.initParams.level - 1
    ) {
      dbBank[selectedGrade].Topics[selectedTopic].Lives =
        Resumeables.dbFromServer.TopicLives;
      dbBank[selectedGrade].Topics[selectedTopic].Score =
        Resumeables.dbFromServer.TopicScore;
      dbBank[selectedGrade].Topics[selectedTopic].Status =
        Resumeables.dbFromServer.TopicStatus;
      dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus =
        Resumeables.dbFromServer.CurrentQuestionInFocus;
    }
    //  if(swiper==null){
    swiper = new Swiper(".swiper-container", {
      // slideClass: 'swiper-slide',
      slidesPerView: 3.3,
      //slidesPerGroup: 1,

      speed: 500,
      snapOnRelease: true,
      centeredSlides: false,
      draggable: true,
      preventClicks: true,
      preventClicksPropagation: true,
      threshold: 10,
      nextButton: ".rightArrowOfGameScreen",
      prevButton: ".leftArrow",
      // freeModeSticky: true,

      // transitionEnd: function(e){
      //     console.log("transition end");
      // },
      // slideChange: function(e){
      //     console.log("slide changed! ", e);
      // },
      // onProgress: function(e){
      //     if(e.isBeginning){
      //         $('.leftArrow').hide();
      //     } else if(e.isEnd){
      //         $('.rightArrowOfGameScreen').hide();
      //     } else {
      //         $('.leftArrow').show();
      //         $('.rightArrowOfGameScreen').show();
      //     }
      // },

      pagination: {
        el: ".swiper-pagination",
        clickable: false,
      },
    });

    swiper.on("setTranslate", function () {
      console.log("Rolling through clues..");
      console.log("First Clue is Reached! ", swiper.isBeginning);
      console.log("Last Clue is Reached! ", swiper.isEnd);

      if (swiper.isBeginning) {
        $(".leftArrow").hide();
      } else {
        $(".leftArrow").show();
      }

      if (swiper.isEnd) {
        $(".rightArrowOfGameScreen").hide();
      } else {
        $(".rightArrowOfGameScreen").show();
      }
    });
    //}

    var hasWonAllTopics = false;
    if (selectedTopic >= dbBank[selectedGrade].Topics[selectedTopic].length) {
      $("#popupBackground").show();
      $("#victoryPopup").show();
      hasWonAllTopics = true;
      selectedTopic = dbBank[selectedGrade].Topics[selectedTopic].length - 1;
    }

    // if($('#tempScoreRow').is(':hidden'))
    //     animateMe("#tempScoreRow", "zoomOut", 1200, function () { }, 4000);

    if (dbBank[selectedGrade].Topics[selectedTopic].Status >= 2) {
      // && hasWonAllTopics == false) {
      this.resetQuestionsOfThisTopic();
    }

    if (
      UBJ_API.TrackingEnabled &&
      dbFromServer &&
      dbBank[selectedGrade].Topics[selectedTopic].Name != dbFromServer.Name
    ) {
      console.log("resetQuestionsOfThisTopic Call due to unequal topic names");
      console.log(
        "dbBank Topic Name: " + dbBank[selectedGrade].Topics[selectedTopic].Name
      );
      console.log("dbFromServer Topic Name: " + dbFromServer.Name);
      this.resetQuestionsOfThisTopic();
      saveJSON();
    }
    if (
      dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length < 1 &&
      hasWonAllTopics == false
    ) {
      this.shuffleQuestions();
      console.log("shuffleQuestions Call");
    }

    //Slider Init + Popups Hide ----- End
    //  this.loadQuestion(0);

    // Init Lives, Score and Clues.
    var foundAllComplete = true;
    //var lastQSolved = dbBank[selectedGrade].Topics[selectedTopic].Questions.length-1;
    for (
      var ptrLQchk = 0;
      ptrLQchk < dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length;
      ptrLQchk++
    ) {
      if (
        dbBank[selectedGrade].Topics[selectedTopic].ListOrder[ptrLQchk] >=
        dbBank[selectedGrade].Topics[selectedTopic].Questions.length
      ) {
        this.resetQuestionsOfThisTopic();
        console.log("resetQuestionsOfThisTopic22 Call");

        break;
      }
    }

    for (
      var vac = 0;
      vac < dbBank[selectedGrade].Topics[selectedTopic].Questions.length;
      vac++
    ) {
      console.log("VAC: " + vac);
      if (
        dbBank[selectedGrade].Topics[selectedTopic].Questions[
          dbBank[selectedGrade].Topics[selectedTopic].ListOrder[vac]
        ].Status < 2
      ) {
        //if(foundAllComplete==true)
        foundAllComplete = false;
        // lastQSolved = vac;
        // if (dbBank[selectedGrade].Topics[selectedTopic].Questions[dbBank[selectedGrade].Topics[selectedTopic].ListOrder[vac]].ClueCount > 0)
        //     this.showAnimationScoreDeduction(vac);
        break;
      }
    }

    if (foundAllComplete) {
      console.log(
        "Found All Completed - Opening Q0 " +
          qNo +
          "-" +
          qNoActive +
          "-" +
          qNoOld
      );
      this.loadQuestion(0);
      // this.showAnimationScoreDeduction(0);
    } else {
      if (
        dbBank[selectedGrade].Topics[selectedTopic].Questions[
          dbBank[selectedGrade].Topics[selectedTopic].ListOrder[
            dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus
          ]
        ].Status < 2
      ) {
        console.log(
          "Found All Completed - Opening Q" +
            game_page.loadQuestion(
              dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus
            ) +
            "-" +
            qNo +
            "-" +
            qNoActive +
            "-" +
            qNoOld
        );

        this.loadQuestion(
          dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus
        );
      } else {
        var mostRecentPreviousUnsolved = 0;
        var leastNextQUnsolved = -1;
        for (
          var uipo = 0;
          uipo <
          dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus;
          uipo++
        ) {
          if (
            dbBank[selectedGrade].Topics[selectedTopic].Questions[
              dbBank[selectedGrade].Topics[selectedTopic].ListOrder[uipo]
            ].Status < 2
          ) {
            mostRecentPreviousUnsolved = uipo;
          }
        }
        for (
          var uipo =
            dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus;
          uipo < dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length;
          uipo++
        ) {
          if (
            dbBank[selectedGrade].Topics[selectedTopic].Questions[
              dbBank[selectedGrade].Topics[selectedTopic].ListOrder[uipo]
            ].Status < 2
          ) {
            leastNextQUnsolved = uipo;
            break;
          }
        }
        console.log(
          "Found All Completed - OpeningQ: " +
            qNo +
            "-" +
            qNoActive +
            "-" +
            qNoOld
        );
        console.log("mostRecentPreviousUnsolved" + mostRecentPreviousUnsolved);
        console.log("leastNextQUnsolved" + leastNextQUnsolved);
        if (leastNextQUnsolved == -1)
          this.loadQuestion(mostRecentPreviousUnsolved);
        else this.loadQuestion(leastNextQUnsolved);

        if (!$("#popupBackground").is(":hidden")) $("#popupBackground").hide();
      }

      // if (dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus > 0)
      // // if (dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus < (dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length + 1) && dbBank[selectedGrade].Topics[selectedTopic].Questions[dbBank[selectedGrade].Topics[selectedTopic].ListOrder[dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus+1]].Status < 2)
      // //     {
      // //          } else
      //  {  if(dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus < (dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length + 2) && dbBank[selectedGrade].Topics[selectedTopic].Questions[dbBank[selectedGrade].Topics[selectedTopic].ListOrder[dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus+1]].Status < 2)
      //     game_page.loadQuestion((dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus++));
      //     else
      //     game_page.loadQuestion((dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus));
      // }
      // else {
      //     var fc2 = false;
      //     var qnotm = 0;
      //     for (var qtml = dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus; qtml < dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length; qtml++) {
      //         if (dbBank[selectedGrade].Topics[selectedTopic].Questions[dbBank[selectedGrade].Topics[selectedTopic].ListOrder[qtml]].Status < 2) {
      //             qnotm = qtml;
      //             fc2 = true;
      //             break;
      //         }

      //     }

      //     if (fc2 == true) {
      //         this.loadQuestion(qnotm);
      //     } else {
      //         this.loadQuestion(0);
      //     }
      // }
      /* if (dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus < (dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length + 1))
                this.loadQuestion((dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus++));
            else
                this.loadQuestion(0);*/
    }

    $("#answerSection").hide();

    $(".bodyClueCard img").on("load", function () {
      // hide/remove the loading image
      $(".bodyClueCard img").addClass("noImageBG");
    });

    if (!$("#popupBackground").is(":hidden")) $("#popupBackground").hide();
  },
  refreshClueButton: function () {
    this.calculateDeductionScore();
    if (
      scoreDeductionPerClue > 0 &&
      scoreDeductionPerClue <= 100 &&
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
        .ClueCount <
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues
          .length
    ) {
      $("#clueScoreToDeduceText").text("-" + scoreDeductionPerClue);
      $("#clueDeductionView").text("-" + scoreDeductionPerClue);
    } else $("#clueScoreToDeduceText").text("ø");

    if (
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
        .ClueCount ==
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues
        .length -
        defaultNumberOfCluesToShow -
        1
    ) {
      var temporaryFutureCreditGuess =
        winningScoreGift -
        10 -
        scoreDeductionPerClue *
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
            .ClueCount;
      $("#clueScoreToDeduceText").text("-" + temporaryFutureCreditGuess);
      $("#clueDeductionView").text("-" + temporaryFutureCreditGuess);
    }

    if (
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
        .ClueCount ==
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues
        .length -
        defaultNumberOfCluesToShow
    ) {
      $("#clueScoreToDeduceText").text("ø");
    }
  },
  calculateDeductionScore: function () {
    /*
        Method:
        Let X no of clues user can ask for with 100 total potential score.
        -Each clue costs 100/X (upto X-1th Clue)
        -for Xth Clue, 100-ClueCosts(X1th+X2nd+X3rd+X4th+.........X(X-1)th)
        */
    // var totalCluesAllowed = dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues.length - defaultNumberOfCluesToShow;
    // console.log("totalCluesAllowed: " + totalCluesAllowed);
    // var perClueAverageDeductionRate = Math.floor(100 / totalCluesAllowed);
    // console.log("perClueAverageDeductionRate: " + perClueAverageDeductionRate);
    // console.log("ClueCount: " + dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].ClueCount);
    // if (dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].ClueCount < (totalCluesAllowed)) {
    //     scoreDeductionPerClue = perClueAverageDeductionRate;
    //     console.log("scoreDeductionPerClue-A: " + scoreDeductionPerClue);
    // } else {
    //     scoreDeductionPerClue = winningScoreGift - perClueAverageDeductionRate * (totalCluesAllowed - 1);
    //     console.log("scoreDeductionPerClue-B: " + scoreDeductionPerClue);

    // }

    var totalCluesAllowed =
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues
        .length - defaultNumberOfCluesToShow;
    console.log("totalCluesAllowed: " + totalCluesAllowed);
    var perClueAverageDeductionRate = Math.floor(
      (winningScoreGift - 10) / totalCluesAllowed
    );
    console.log("perClueAverageDeductionRate: " + perClueAverageDeductionRate);
    console.log(
      "ClueCount: " +
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
          .ClueCount
    );
    scoreDeductionPerClue = perClueAverageDeductionRate;
    // if (dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].ClueCount < (totalCluesAllowed)) {
    //     scoreDeductionPerClue = perClueAverageDeductionRate;
    //     console.log("scoreDeductionPerClue-A: " + scoreDeductionPerClue);
    // } else {
    //     scoreDeductionPerClue = winningScoreGift - perClueAverageDeductionRate * (totalCluesAllowed - 1);
    //     console.log("scoreDeductionPerClue-B: " + scoreDeductionPerClue);

    // }
  },
  showAnimationScoreDeduction: function (vac) {
    //  $('#tempScoreChange').text('-99');
    $("#tempScoreChange").show();
    console.log("BeforeShowAnim: " + scoreDeductionPerClue);
    //  if (dbBank[selectedGrade].Topics[selectedTopic].Questions[dbBank[selectedGrade].Topics[selectedTopic].ListOrder[vac]].Score == 0)
    if (
      dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Score ==
      0
    )
      $("#tempScoreChange").text(" ");
    else $("#tempScoreChange").text("-" + parseInt(scoreDeductionPerClue));

    if ($("#tempScoreRow").is(":hidden")) {
      animateMe(
        "#tempScoreChange",
        "bounceIn",
        500,
        function () {
          animateMe(
            "#tempScoreRow",
            "flipInX",
            600,
            function () {
              animateMe("#tempScoreTotal", "flipOutX", 300, function () {
                if (!$("#tempScoreChange").text(" "))
                  $("#tempScoreTotal").text(
                    "-" +
                      parseInt(
                        dbBank[selectedGrade].Topics[selectedTopic].Questions[
                          dbBank[selectedGrade].Topics[selectedTopic].ListOrder[
                            vac
                          ]
                        ].Score - scoreDeductionPerClue
                      )
                  );
                $("#tempScoreChange").text("-" + scoreDeductionPerClue);
                $("#tempScoreTotal").text(
                  dbBank[selectedGrade].Topics[selectedTopic].Questions[
                    qNoActive
                  ].Score
                );
                //   animateMe("#tempScoreTotal", "bounce", 600);
                animateMe("#tempScoreTotal", "flipInX", 300, function () {});
                animateMe(
                  "#tempScoreChange",
                  "flipOutX",
                  800,
                  function () {
                    $("#tempScoreChange").hide();
                  },
                  200
                );
              });

              // animateMe("#tempScoreRow", "zoomOut", 1200, function () {

              // }, 4000);
            },
            200
          );
        },
        0
      );
    } else {
      animateMe(
        "#tempScoreChange",
        "bounceIn",
        500,
        function () {
          animateMe(
            "#tempScoreRow",
            "pulse",
            600,
            function () {
              animateMe("#tempScoreTotal", "flipOutX", 300, function () {
                if (!$("#tempScoreChange").text(" "))
                  $("#tempScoreTotal").text(
                    "-" +
                      parseInt(
                        dbBank[selectedGrade].Topics[selectedTopic].Questions[
                          dbBank[selectedGrade].Topics[selectedTopic].ListOrder[
                            vac
                          ]
                        ].Score - scoreDeductionPerClue
                      )
                  );

                $("#tempScoreChange").text("-" + scoreDeductionPerClue);
                $("#tempScoreTotal").text(
                  dbBank[selectedGrade].Topics[selectedTopic].Questions[
                    qNoActive
                  ].Score
                );
                //  animateMe("#tempScoreTotal", "bounce", 600);
                animateMe("#tempScoreTotal", "flipInX", 300, function () {});
                animateMe(
                  "#tempScoreChange",
                  "flipOutX",
                  800,
                  function () {
                    $("#tempScoreChange").hide();
                  },
                  200
                );
              });

              // animateMe("#tempScoreRow", "zoomOut", 1200, function () {

              // }, 4000);
            },
            200
          );
        },
        0
      );
    }

    //     animateMe("#tempScoreRow", "flipInX", 1000, function () {
    //         animateMe("#tempScoreChange", "fadeOutUp", 5000);
    //         animateMe("#tempScoreTotal", "bounceIn", 2000, function () {
    //             $('#tempScoreChange').hide();
    //          animateMe("#tempScoreRow", "flipOutX", 5000, function () {
    //              $('#tempScoreRow').hide();
    //          }, 4000);

    //     });
    //     }, 2000);
  },

  // evaluateQ: function() {

  // }
  // ,
  evaluateQs: function () {
    completionTotalScore = 0;
    completionTotalClues = 0;
    completionQScore = 0;

    tempTopicDataForReview = null;
    isFoundDone = -1;
    for (
      var vx = 0;
      vx < dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length;
      vx++
    ) {
      if (
        dbBank[selectedGrade].Topics[selectedTopic].Questions[
          dbBank[selectedGrade].Topics[selectedTopic].ListOrder[vx]
        ].Status < 2
      ) {
        isFoundDone = vx;
        break;
      }
    }
    tempTopicDataForReview = JSON.parse(
      JSON.stringify(dbBank[selectedGrade].Topics[selectedTopic])
    );

    if (isFoundDone == -1) {
      for (
        var iv = 0;
        iv < dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length;
        iv++
      ) {
        if (
          dbBank[selectedGrade].Topics[selectedTopic].Questions[
            dbBank[selectedGrade].Topics[selectedTopic].ListOrder[iv]
          ].Status == 3
        ) {
          completionQScore++;
        }
        completionTotalScore +=
          dbBank[selectedGrade].Topics[selectedTopic].Questions[
            dbBank[selectedGrade].Topics[selectedTopic].ListOrder[iv]
          ].Score;
        completionTotalClues +=
          dbBank[selectedGrade].Topics[selectedTopic].Questions[
            dbBank[selectedGrade].Topics[selectedTopic].ListOrder[iv]
          ].ClueCount;
      }

      console.log("Correct ans in topic: " + completionQScore);

      var resultStatus = -1;

      if (
        (completionQScore /
          dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length) *
          100 >=
        winningPercentage
      ) {
        dbBank[selectedGrade].Topics[selectedTopic].Status = 3;
        resultStatus = 1;
      } else {
        resultStatus = -1;
      }

      dbBank[selectedGrade].Score +=
        dbBank[selectedGrade].Topics[selectedTopic].Score;
      if (
        Resumeables.dbFromServer &&
        UBJ_API.TrackingEnabled &&
        dbBank[selectedGrade].Name == gameService.initParams.grade &&
        selectedTopic == gameService.initParams.level - 1
      ) {
        Resumeables.dbFromServer.TopicScore =
          dbBank[selectedGrade].Topics[selectedTopic].Score;
      } else {
        dbBank[selectedGrade].Topics[selectedTopic].Score = 0;
      }
      if (resultStatus == -1) {
        dbBank[selectedGrade].Topics[selectedTopic].Status = 2;
      } else {
        dbBank[selectedGrade].Topics[selectedTopic].Status = 3;
        if (selectedTopic < dbBank[selectedGrade].Topics.length - 1) {
          if (
            dbBank[selectedGrade].Topics[parseInt(parseInt(selectedTopic) + 1)]
              .Status == 0
          ) {
            dbBank[selectedGrade].Topics[
              parseInt(parseInt(selectedTopic) + 1)
            ].Status = 1;
          }
        }
        // else {

        //     $('#popupBackground').show();
        //     $('#victoryPopup').show();
        // }
      }
    } else {
      console.log("VX is : " + vx);
    }

    // if() {

    // }
    //       saveJSON();
  },

  addListeners: function () {
    var _this = this;
    var isPlaying = 0;
    // _this.keyup(function (event) {

    //     console.log(e.id);
    //  });

    $("#wordResultOKBtn").click(function () {
      clearTimeout(clearFocusTimeout);
      $("#wordResultOKBtn").prop("disabled", true);
      setTimeout(function () {
        $("#wordResultOKBtn").prop("disabled", false);
      }, 500);

      $("#popupBackground").hide();
      animateMe("#singleResultPopup", "zoomOut", 300, function () {
        $("#singleResultPopup").hide();
        clearFocusTimeout = setTimeout(function () {
          $("#userEnteredAnswer").focus();
        }, 500);
      });

      playSound("smallPressSound", false);
      // tempTopicDataForReview = null;
      // isFoundDone = -1;

      // for (var vx = 0; vx < dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length; vx++) {
      //     if (dbBank[selectedGrade].Topics[selectedTopic].Questions[dbBank[selectedGrade].Topics[selectedTopic].ListOrder[vx]].Status < 2) {

      //         isFoundDone = vx;
      //         break;
      //     }
      // }

      // if (isFoundDone == -1) {

      //     tempTopicDataForReview = JSON.parse(JSON.stringify(dbBank[selectedGrade].Topics[selectedTopic]));

      // } else {
      //     console.log("VX is : " + (vx));

      // }

      if (dbBank[selectedGrade].Topics[selectedTopic].Status >= 2) {
        game_page.showOverallResultPopup(qNoActive, qNoOld);
      } else {
        isf = -1;
        for (
          var vx =
            dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus;
          vx < dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length;
          vx++
        ) {
          if (
            dbBank[selectedGrade].Topics[selectedTopic].Questions[
              dbBank[selectedGrade].Topics[selectedTopic].ListOrder[vx]
            ].Status < 2
          ) {
            isf = vx;
            break;
          }
        }

        if (isf == -1) {
          for (
            var vx = 0;
            vx <
            dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus;
            vx++
          ) {
            if (
              dbBank[selectedGrade].Topics[selectedTopic].Questions[
                dbBank[selectedGrade].Topics[selectedTopic].ListOrder[vx]
              ].Status < 2
            ) {
              isf = vx;
              break;
            }
          }
        }

        console.log(
          "Infocus Q: " +
            dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus
        );
        console.log("Moving to Q: " + isf);

        if (isf == -1) game_page.loadQuestion(0);
        else game_page.loadQuestion(isf);

        // if(dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Status < 2) {
        //     $("#userEnteredAnswer").focus();
        // }
      }
    });

    $("#toggleSoundButton").click(function () {
      toggleSound();
    });

    $("#popupBackground").click(function () {
      $("#popupBackground").show();
    });

    $("#gotoHomeButton").on("click", function () {
      playSound("smallPressSound", false);

      // if ($("#gotoHomeButton").is(':disabled'))
      //     return;
      // $("#gotoHomeButton").prop('disabled', true);
      // setTimeout(function () {
      //     $("#gotoHomeButton").prop('disabled', false);
      // }, 1000);

      // playSound("smallPressSound", false);
      console.log("Kuch likh diya andar...");
      index_page.showPage(AppSet.pages.Topic, 1);
    });

    function loadSound(audioSrc) {
      var player = document.getElementById("player");
      player.src = audioSrc;
      player.load();
      player.play();
    }

    document.addEventListener("click", function (e) {
      if (e.target && e.target.id) {
        const curr = e.target.id;
        const content = document.getElementById(curr);
        const audioSrc = content.getAttribute("audiosrc");
        if (isPlaying == 0) {
          loadSound(audioSrc);
          isPlaying = 1;
        } else {
          var player = document.getElementById("player");
          player.pause(); // Pause the audio if it is currently playing
          isPlaying = 0;
        }
      }
    });

    $("#getHintButton").click(function () {
      if ($("#getHintButton").is(":disabled")) return;
      $("#getHintButton").prop("disabled", true);
      setTimeout(function () {
        $("#getHintButton").prop("disabled", false);
      }, 1000);

      playSound("cluePressSound", false);

      if (
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues
          .length > maxCluesAllowedPerQuestion
      ) {
        console.log(
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
            .ClueCount +
            defaultNumberOfCluesToShow +
            " < " +
            dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
              .Clues.length
        );
        $("#popupBackground").show();
        if (
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
            .ClueCount < maxCluesAllowedPerQuestion
        ) {
          if (
            dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
              .ClueCount +
              defaultNumberOfCluesToShow <
            dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
              .Clues.length
          ) {
            $("#clueConsumptionPopup").show();
            animateMe("#clueConsumptionPopup", "zoomIn", 300);
            // $('#clueDeductionView').text("-" + scoreDeductionPerClue);

            $("#clueNoToGetDisplay").text(
              defaultNumberOfCluesToShow +
                (dbBank[selectedGrade].Topics[selectedTopic].Questions[
                  qNoActive
                ].ClueCount +
                  1) +
                ""
            );
          } else {
            $("#noClueLeftPopup").show(
              dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
                .ClueCount + 1
            );

            animateMe("#noClueLeftPopup", "zoomIn", 300);
            _this.showErrorPopup(
              "Sorry, all possible clues of this question are consumed."
            );
          }
        } else {
          $("#noClueLeftPopup").show(
            dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
              .ClueCount + 1
          );
        }
      } else {
        console.log("Oops, full!");
        _this.showErrorPopup(
          "Sorry, all possible clues of this question are consumed."
        );
      }
    });

    $("#yesClueButton").click(function () {
      clearTimeout(clearFocusTimeout);

      if ($("#yesClueButton").is(":disabled")) return;
      $("#yesClueButton").prop("disabled", true);
      $("#getHintButton").prop("disabled", true);
      for (
        var vvvv = 0;
        vvvv < dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length;
        vvvv++
      ) {
        $("#Qlock" + vvvv).prop("disabled", true);
      }
      $("#getHintButton").addClass("disabledDiv");
      setTimeout(function () {
        $("#yesClueButton").prop("disabled", false);
        $("#getHintButton").prop("disabled", false);
        for (
          var vvvv = 0;
          vvvv < dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length;
          vvvv++
        ) {
          $("#Qlock" + vvvv).prop("disabled", false);
        }
        $("#getHintButton").removeClass("disabledDiv");
      }, 1400);

      playSound("clueRevealSound", false);
      animateMe("#clueConsumptionPopup", "zoomOut", 300, function () {
        $("#popupBackground").hide();
        $("#clueConsumptionPopup").hide();
        clearFocusTimeout = setTimeout(function () {
          $("#userEnteredAnswer").focus();
        }, 500);
        $("#answerScoreToDeduceText").text(
          "-" +
            dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
              .Score
        );
      });

      if (
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
          .Status == 0
      )
        dbBank[selectedGrade].Topics[selectedTopic].Questions[
          qNoActive
        ].Status = 1;

      if (
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
          .ClueCount < maxCluesAllowedPerQuestion
      ) {
        dbBank[selectedGrade].Topics[selectedTopic].Questions[
          qNoActive
        ].ClueCount += 1;
        game_page.calculateDeductionScore();
        dbBank[selectedGrade].Topics[selectedTopic].Questions[
          qNoActive
        ].Score -= scoreDeductionPerClue;
        currentScore =
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
            .Score;
        currentNumberOfClues =
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
            .ClueCount;
        $("#cluesDisplay").text(
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues
            .length -
            defaultNumberOfCluesToShow -
            dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
              .ClueCount
        );
        if (
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues
            .length -
            defaultNumberOfCluesToShow -
            dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
              .ClueCount <
          0
        )
          $("#cluesDisplay").text("0");
        //                if(dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].ClueCount > 0 && )
        game_page.showAnimationScoreDeduction(qNoOld);

        _this.revealClue(
          defaultNumberOfCluesToShow +
            (dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
              .ClueCount -
              1)
        );
        game_page.refreshClueButton();
      } else {
        dbBank[selectedGrade].Topics[selectedTopic].Questions[
          qNoActive
        ].ClueCount = 0;
        _this.showErrorPopup(
          "Sorry, all possible clues of this question are consumed."
        );
      }
      // if (dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].ClueCount < maxCluesAllowedPerQuestion) {
      //     if ((dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].ClueCount + defaultNumberOfCluesToShow) < dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues.length) {

      //         if (currentScore > scoreDeductionPerClue)
      //             currentScore -= scoreDeductionPerClue;
      //         else
      //             currentScore = 0;
      //         dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].ClueCount++
      //         _this.revealClue(defaultNumberOfCluesToShow + (dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].ClueCount - 1));
      //         dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Score -= scoreDeductionPerClue;
      //     } else {

      //         _this.showErrorPopup("Sorry, you've consumed maximum number of hints for this question.");

      //     }
      // }
      game_page.updateQUI(qNoOld);

      if (
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
          .ClueCount +
          defaultNumberOfCluesToShow >=
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues
          .length
      ) {
        if (!$("#getHintButton").is(":hidden")) {
          animateMe("#getHintButton", "zoomOut", 300, function () {
            $("#getHintButton").hide();
            animateMe("#noClueLeftBtnOverlay", "zoomIn", 300, function () {
              $("#noClueLeftBtnOverlay").show();
              $("#answerScoreToDeduceText").text(
                "-" +
                  dbBank[selectedGrade].Topics[selectedTopic].Questions[
                    qNoActive
                  ].Score
              );
            });
          });
        }
      } else {
        if (!$("#noClueLeftBtnOverlay").is(":hidden")) {
          animateMe("#noClueLeftBtnOverlay", "zoomOut", 300, function () {
            $("#noClueLeftBtnOverlay").hide();
            animateMe("#getHintButton", "zoomIn", 300, function () {
              $("#getHintButton").show();
            });
          });
        }
      }

      saveJSON();
    });

    $("#noClueButton").click(function () {
      if ($("#yesClueButton").is(":disabled")) return;
      $("#yesClueButton").prop("disabled", true);
      setTimeout(function () {
        $("#yesClueButton").prop("disabled", false);
      }, 500);

      playSound("smallPressSound", false);
      animateMe("#clueConsumptionPopup", "zoomOut", 300, function () {
        $("#popupBackground").hide();
        $("#clueConsumptionPopup").hide();
      });
    });

    $("#slideNext").click(function () {
      // if ($("#slideNext").is(':disabled'))
      //     return;
      // $("#slideNext").prop('disabled', true);
      // setTimeout(function () {
      //     $("#slideNext").prop('disabled', false);
      // }, 500);
      playSound("slideClickSound", false);
      swiper.slideNext(500, false);
    });
    $("#slidePrev").click(function () {
      // if ($("#slidePrev").is(':disabled'))
      //     return;
      // $("#slidePrev").prop('disabled', true);
      // setTimeout(function () {
      //     $("#slidePrev").prop('disabled', false);
      // }, 500);
      playSound("slideClickSound", false);
      swiper.slidePrev(500, false);
    });

    $("#noClueLeftBtnOverlay").click(function () {
      if ($("#noClueLeftBtnOverlay").is(":disabled")) return;
      $("#noClueLeftBtnOverlay").prop("disabled", true);
      setTimeout(function () {
        $("#noClueLeftBtnOverlay").prop("disabled", false);
      }, 1000);

      playSound("errorPopupSound", false);

      if ($("#popupBackground").is(":hidden")) $("#popupBackground").show();

      $("#revealAnsDeductionView").text(
        "-" +
          dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Score
      );
      animateMe("#answerConsumptionPopup", "zoomIn", 300, function () {
        $("#answerConsumptionPopup").show();
      });
    });

    $("#noRevealAnsButton").click(function () {
      if ($("#yesRevealAnsButton").is(":disabled")) return;
      $("#yesRevealAnsButton").prop("disabled", true);
      setTimeout(function () {
        $("#yesRevealAnsButton").prop("disabled", false);
      }, 1000);

      playSound("smallPressSound", false);
      if (!$("#popupBackground").is(":hidden")) $("#popupBackground").hide();
      animateMe("#answerConsumptionPopup", "zoomOut", 300, function () {
        $("#answerConsumptionPopup").hide();
      });
    });

    $("#yesRevealAnsButton").click(function () {
      //alert("Yes:" +$("#userEnteredAnswer").is(':disabled'));
      if ($("#userEnteredAnswer").is(":disabled")) return;
      $("#userEnteredAnswer").prop("disabled", true);
      setTimeout(function () {
        $("#userEnteredAnswer").prop("disabled", false);
      }, 1500);

      if ($("#yesRevealAnsButton").is(":disabled")) return;
      $("#yesRevealAnsButton").prop("disabled", true);
      setTimeout(function () {
        $("#yesRevealAnsButton").prop("disabled", false);
      }, 1000);

      for (
        var poi = 0;
        poi < dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length;
        poi++
      ) {
        if (!$("#Qlock" + poi).hasClass("disabledDiv"))
          $("#Qlock" + poi).addClass("disabledDiv");
      }

      //return;
      setTimeout(function () {
        // if($(".eachLockInTopBar").hasClass('disabledDiv'))
        //     $(".eachLockInTopBar").removeClass('disabledDiv');

        for (
          var poi = 0;
          poi < dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length;
          poi++
        ) {
          if ($("#Qlock" + poi).hasClass("disabledDiv"))
            $("#Qlock" + poi).removeClass("disabledDiv");
        }
      }, 1500);

      playSound("smallPressSound", false);
      if (!$("#popupBackground").is(":hidden"))
        animateMe("#answerConsumptionPopup", "zoomOut", 300, function () {
          $("#answerConsumptionPopup").hide();

          $("#submitGuessButton").prop("disabled", true);
          $("#userEnteredAnswer").prop("disabled", true);
          $("#userEnteredAnswer").val("Not Answered!");
          $("#popupBackground").hide();
          if (!$("#answerTypeSection").hasClass("wrongedtBox"))
            $("#answerTypeSection").addClass("wrongedtBox");
          $("#submitGuessButton").hide();

          playSound("wrongBuzzSound", false);
          animateMe(
            "#userEnteredAnswer",
            "shake",
            500,
            function () {
              enforcedSurrender = true;
              $("#submitGuessButton").show();
              $("#submitGuessButton").prop("disabled", false);
              $("#userEnteredAnswer").prop("disabled", false);
              if ($("#answerTypeSection").hasClass("wrongedtBox"))
                $("#answerTypeSection").removeClass("wrongedtBox");
              $("#submitGuessButton").click();
            },
            100
          );
        });
    });

    $("#popupBackground").click(function (e) {
      console.log("e: " + e.target.id);
      //  $("#popupBackground").hide();
      // $("#"+e.target.id).hide();

      /*
                        if ($('#pausePopup').is(":visible") || !$('#pausePopup').is(":hidden")) {
                            $('#pausePopup').hide();
                        }
                        if ($('#clueConsumptionPopup').is(":visible") || !$('#clueConsumptionPopup').is(":hidden")) {
                            $('#clueConsumptionPopup').hide();
                        }
                        if ($('#singleResultPopup').is(":visible") || !$('#singleResultPopup').is(":hidden")) {
                            $('#singleResultPopup').hide();
                        }
                        if ($('#completeResultPopup').is(":visible") || !$('#completeResultPopup').is(":hidden")) {
                            $('#completeResultPopup').hide();
                        }
            */
    });

    $("#wrongGuessSButton").click(function () {
      if ($("#wrongGuessSButton").is(":disabled")) return;
      $("#wrongGuessSButton").prop("disabled", true);
      $(".eachLockInTopBar ").prop("disabled", true);
      setTimeout(function () {
        $("#wrongGuessSButton").prop("disabled", false);
        $(".eachLockInTopBar ").prop("disabled", false);
      }, 1000);

      playSound("smallPressSound", false);
      //if($('#answerTypeSection').hasClass('wrongedtBox'))
      //   {
      if (!$("#answerTypeSection").hasClass("wrongedtRealAnsBox")) {
        // $('#answerTypeSection').text((dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Word).split('|')[0].trim());
        //  }
        $("#correctAnsLabelBubble").show();
        $("#correctAnsLabelBubble").css("z-index", 200000);
        animateMe("#correctAnsLabelBubble", "zoomIn", 200, function () {
          if (!$("#answerTypeSection").hasClass("wrongedtBox"))
            $("#answerTypeSection").removeClass("wrongedtBox");
          if ($("#answerTypeSection").hasClass("correctTBox"))
            $("#answerTypeSection").removeClass("correctTBox");
          // if (!$('#answerTypeSection').hasClass('wrongedtRealAnsBox'))
          $("#answerTypeSection").addClass("wrongedtRealAnsBox");

          $("#userEnteredAnswer").val(
            dbBank[selectedGrade].Topics[selectedTopic].Questions[
              qNoActive
            ].Word.split("|")[0].trim()
          );

          $("#correctAnsLabelBubble").show();
          //  $('#correctAnsLabelBubble').css('z-index', 200000);
        });
        animateMe("#wrongGuessSButton", "zoomOut", 200, function () {
          $("#wrongGuessSButton").hide();
          $("#showAnswerToggleTextDisplay").text("Your Answer!");
          animateMe("#wrongGuessSButton", "zoomIn", 400, function () {
            $("#wrongGuessSButton").show();
          });
        });
      } else {
        animateMe("#correctAnsLabelBubble", "zoomOut", 200, function () {
          // if (!$('#answerTypeSection').hasClass('wrongedtBox'))
          $("#answerTypeSection").addClass("wrongedtBox");
          if ($("#answerTypeSection").hasClass("correctTBox"))
            $("#answerTypeSection").removeClass("correctTBox");
          if ($("#answerTypeSection").hasClass("wrongedtRealAnsBox"))
            $("#answerTypeSection").removeClass("wrongedtRealAnsBox");

          $("#correctAnsLabelBubble").hide();

          $("#userEnteredAnswer").val(
            dbBank[selectedGrade].Topics[selectedTopic].Questions[
              qNoActive
            ].UserLastEntry.trim()
          );
        });

        animateMe("#wrongGuessSButton", "zoomOut", 200, function () {
          $("#wrongGuessSButton").hide();
          $("#showAnswerToggleTextDisplay").text("Show Answer!");
          animateMe("#wrongGuessSButton", "zoomIn", 400, function () {
            $("#wrongGuessSButton").show();
          });
        });
        // $('#answerTypeSection').text((dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Word).split('|')[0].trim());
        //  }
      }
    });

    $("#returnNoClueButton").click(function (e) {
      playSound("smallPressSound", false);
      _this.closeAllPopups();
    });

    $("#yayVictoryButton").click(function () {
      $("#popupBackground").hide();
      $("#victoryPopup").hide();
      playSound("smallPressSound", false);
      index_page.showPage(AppSet.pages.Entry);
    });

    $(".eachLockInTopBar").click(function (e) {
      if ($("#" + e.target.id).hasClass("disabledDiv")) return;

      if (e.target.id.replace("Qlock", "") == prevQinFoc) return;

      prevQinFoc = e.target.id.replace("Qlock", "");
      // $(".eachLockInTopBar").addClass('disabledDiv');

      for (
        var poi = 0;
        poi < dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length;
        poi++
      ) {
        if (!$("#Qlock" + poi).hasClass("disabledDiv"))
          $("#Qlock" + poi).addClass("disabledDiv");
      }

      //return;
      setTimeout(function () {
        // if($(".eachLockInTopBar").hasClass('disabledDiv'))
        //     $(".eachLockInTopBar").removeClass('disabledDiv');

        for (
          var poi = 0;
          poi < dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length;
          poi++
        ) {
          if ($("#Qlock" + poi).hasClass("disabledDiv"))
            $("#Qlock" + poi).removeClass("disabledDiv");
        }
      }, 1300);

      //     if ($(".eachLockInTopBar")!=null)
      //     return;
      // $(".eachLockInTopBar").prop('disabled', true);
      // $(".eachLockInTopBar").addClass('eachLockInTopBarClickDisabled');
      // $(".eachLockInTopBar").removeClass('eachLockInTopBar');
      // setTimeout(function () {
      //     $(".eachLockInTopBarClickDisabled").addClass('eachLockInTopBar');
      //     $(".eachLockInTopBarClickDisabled").removeClass('eachLockInTopBarClickDisabled');
      // }, 2000);

      //     for(var poi = 0; poi < 10; poi++)
      //     {
      //     if ($("#Qlock"+poi).is(':disabled'))
      //         return;
      //     $("#Qlock"+poi).prop('disabled', true);
      //     setTimeout(function () {
      //         $("#Qlock"+poi).prop('disabled', false);
      //     }, 2000);
      // }
      playSound("click_sound", false);
      console.log("Question Clicked: " + e.target.id.replace("Qlock", ""));
      //if (tempTopicDataForReview == null || tempTopicDataForReview.Status < 2)
      console.log(
        "reviewModeOn is " + reviewModeOn + ", Moving to according page"
      );
      if (reviewModeOn == false)
        _this.loadQuestion(parseInt(e.target.id.replace("Qlock", "")));
      else _this.reviewQuestion(parseInt(e.target.id.replace("Qlock", "")));
    });

    $("#submitGuessButton").click(function (e) {
      if ($("#submitGuessButton").is(":disabled")) return;
      $("#submitGuessButton").prop("disabled", true);
      $("#userEnteredAnswer").prop("disabled", true);
      setTimeout(function () {
        $("#submitGuessButton").prop("disabled", false);
        $("#userEnteredAnswer").prop("disabled", false);
      }, 2000);

      if (
        dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive]
          .Status == 0
      )
        dbBank[selectedGrade].Topics[selectedTopic].Questions[
          qNoActive
        ].Status = 1;
      playSound("smallPressSound", false);
      // if (pressedAlreadyFlag == false) {
      // pressedAlreadyFlag = true;
      _this.evaluateAnswer(userEnteredAnswer.value.trim().toLowerCase());
      saveJSON();
      // }
    });

    if ($("#popupBackground").is(":visible")) {
      console.log("Goneee..");
    } else {
      // $("#popupBackground").keydown(function (event) {
      //     if (event.keyCode === 13 && $('#singleResultPopup').is(":visible") ) {
      //         $("#wordResultOKBtn").click();
      //     }
      // });
      $("#game_page").keydown(function (event) {
        if (event.keyCode === 13) {
          if (!$("#popupBackground").is(":visible") && keyTrigger == false) {
            // $("#submitGuessButton").prop('disabled', true);
            if (pressedAlreadyFlag == false) $("#submitGuessButton").click();
            keyTrigger = true;
          }

          // if ($('#singleResultPopup').is(":visible") && keyTrigger == false) {
          //     $("#wordResultOKBtn").click();
          //     keyTrigger = true;
          // }
        }
        // else if (event.keyCode == 37) {
        //     swiper.slidePrev(500, false);
        // } else if (event.keyCode == 39 ) {
        //     swiper.slideNext(500, false);
        // }
      });

      $("#game_page").keyup(function (event) {
        keyTrigger = false;
      });
    }
  },
};
