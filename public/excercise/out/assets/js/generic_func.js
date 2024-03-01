function updateGeneralScore(val, updateInsteadOfOverwrite) {
  totalScore = parseInt(gameService.dbGet("totalScore"));
  if (updateInsteadOfOverwrite != null) {
    totalScore += parseInt(val);
  } else {
    totalScore = parseInt(val);
  }

  $("#scoreDisplay").text(totalScore);
  gameService.dbGet("totalScore", parseInt(totalScore));
}

function updateLevelScore(val, updateInsteadOfOverwrite) {
  currentScore = parseInt(
    gameService.dbGet("currentScore_" + selectedGrade + "|||" + selectedTopic)
  );
  totalScore = parseInt(gameService.dbGet("totalScore"));
  if (updateInsteadOfOverwrite != null) {
    currentScore += parseInt(val);
    totalScore += parseInt(val);
  } else {
    currentScore = parseInt(val);
    totalScore = parseInt(val);
  }

  $("#scoreDisplay").text(parseInt(totalScore));
  gameService.dbSet("totalScore", parseInt(totalScore));
  gameService.dbSet(
    "currentScore_" + selectedGrade + "|||" + selectedTopic,
    currentScore
  );
}

function getGradeIndex(gradeName) {
  for (var xxmb = 0; xxmb < dbBank.length; xxmb++) {
    if (dbBank[xxmb].Name == gradeName) return xxmb;
  }

  return -1;
}
function getParams() {
  // This function is anonymous, is executed immediately and
  // the return value is assigned to QueryString!
  const query_string = {};
  const query = window.location.search.substring(1);
  // console.log(query.length);
  if (query.length == 0) {
    query_string.type = "";
    return query_string;
  }
  const vars = query.split("&");
  for (let i = 0; i < vars.length; i++) {
    const pair = vars[i].split("=");
    // If first entry with this name
    if (typeof query_string[pair[0]] === "undefined") {
      query_string[pair[0]] = decodeURIComponent(pair[1]);
      // If second entry with this name
    } else if (typeof query_string[pair[0]] === "string") {
      const arr = [query_string[pair[0]], decodeURIComponent(pair[1])];
      query_string[pair[0]] = arr;
      // If third or later entry with this name
    } else {
      query_string[pair[0]].push(decodeURIComponent(pair[1]));
    }
  }
  // console.log("initParams: " + JSON.stringify(query_string));
  if (!query_string.type) query_string.type = "";
  return query_string;
}
function getTopicIndex(gradeIndex, topicName) {
  for (var i = 0; i < dbBank[gradeIndex].Topics.length; i++) {
    if (dbBank[gradeIndex].Topics[i].Name == topicName) return i;
  }
  return -1;
}

function getQuestionsListString(a, b) {
  strX = "";
  for (var i = 0; i < dbBank[a].Topics[b].Questions.length; i++) {
    strX = strX + "" + dbBank[a].Topics[b].Questions[i].Status + "";
  }
  return strX;
}

function saveJSON() {
  console.log("Function call: saveJSON");

  if (UBJ_API.TrackingEnabled && Resumeables.dbFromServer.length == 0) {
    Resumeables.dbFromServer = JSON.parse(JSON.stringify(dbFromServer));
  }

  gameService.dbSet("entireDataBank", JSON.stringify(dbBank));

  console.log("dbBank pre PARAM set:" + dbBank);
  if (
    typeof gameService.initParams.grade !== "undefined" &&
    UBJ_API.TrackingEnabled
  )
    gameService.initParams.grade = dbBank[selectedGrade].Name;
  console.log("TEMP GRADE NAME PARAM:" + gameService.initParams.grade);
  if (
    typeof gameService.initParams.level !== "undefined" &&
    UBJ_API.TrackingEnabled
  )
    gameService.initParams.level = selectedTopic + 1;

  if (
    JSON.stringify(Resumeables.dbFromServer) != "{}" &&
    UBJ_API.TrackingEnabled &&
    dbBank[selectedGrade].Name == gameService.initParams.grade &&
    selectedTopic == gameService.initParams.level - 1
  ) {
    Resumeables.dbFromServer.TopicLives =
      dbBank[selectedGrade].Topics[selectedTopic].Lives;
    Resumeables.dbFromServer.TopicStatus =
      dbBank[selectedGrade].Topics[selectedTopic].Status;
    dbFromServer.TopicLives = Resumeables.dbFromServer.TopicLives;
    dbFromServer.TopicStatus = Resumeables.dbFromServer.TopicStatus;

    if (
      parseInt(selectedTopic) + 1 == gameService.initParams.level &&
      gameService.initParams.grade == dbBank[selectedGrade].Name &&
      UBJ_API.TrackingEnabled
    ) {
      dbFromServer = JSON.parse(
        JSON.stringify(dbBank[selectedGrade].Topics[selectedTopic])
      );
      var h1 = selectedGrade;
      var h2 = selectedTopic;
      //  for (var h1 = 0; h1 < dbBank.length; h1++) {
      //dbFromServer[h1].Name = dbBank[h1].Name;
      // dbFromServer[h1].Score = dbBank[h1].Score;
      //    for (var h2 = 0; h2 < dbBank[h1].Topics.length; h2++) {
      //  dbFromServer[h1].ClueCount = dbBank[h1].Topics[h2].ClueCount;
      //  dbFromServer[h1].Lives = dbBank[h1].Topics[h2].Lives;
      //  dbFromServer[h1].Name = dbBank[h1].Topics[h2].Name;
      //  dbFromServer[h1].ListOrder = dbBank[h1].Topics[h2].ListOrder;
      //  dbFromServer[h1].Score = dbBank[h1].Topics[h2].Score;
      //  dbFromServer[h1].Status = dbBank[h1].Topics[h2].Status;
      for (var h3 = 0; h3 < dbBank[h1].Topics[h2].Questions.length; h3++) {
        //  dbFromServer[h1].Questions[h3].ClueCount = dbBank[h1].Topics[h2].Questions[h3].ClueCount;
        //  dbFromServer[h1].Questions[h3].Lives = dbBank[h1].Topics[h2].Questions[h3].Lives;
        //  dbFromServer[h1].Questions[h3].Score = dbBank[h1].Topics[h2].Questions[h3].Score;
        //  dbFromServer[h1].Questions[h3].Status = dbBank[h1].Topics[h2].Questions[h3].Status;
        //  dbFromServer[h1].Questions[h3].TempScore = dbBank[h1].Topics[h2].Questions[h3].TempScore;
        //  dbFromServer[h1].Questions[h3].UserLastEntry = dbBank[h1].Topics[h2].Questions[h3].UserLastEntry;
        //  dbFromServer[h1].Questions[h3].qHash = dbBank[h1].Topics[h2].Questions[h3].qHash;
        if (dbFromServer.Questions[h3].Word != null)
          delete dbFromServer.Questions[h3].Word;
        if (dbFromServer.Questions[h3].ClueType != null)
          delete dbFromServer.Questions[h3].ClueType;
        if (dbFromServer.Questions[h3].Clues != null)
          delete dbFromServer.Questions[h3].Clues;
        //  }

        //}
      }
      Resumeables.dbFromServer = JSON.parse(JSON.stringify(dbFromServer));
      Resumeables.dbFromServer.TopicScore =
        dbBank[selectedGrade].Topics[selectedTopic].Score;
      Resumeables.dbFromServer.TopicStatus =
        dbBank[selectedGrade].Topics[selectedTopic].Status;
      Resumeables.dbFromServer.TopicLives =
        dbBank[selectedGrade].Topics[selectedTopic].Lives;
      // alert("Lives from Resumables"+Resumeables.dbFromServer.Lives);

      var countVarr = 0;
      var correctVarr = 0;
      for (
        var counterToCountCompletedQs = 0;
        counterToCountCompletedQs <
        dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length;
        counterToCountCompletedQs++
      ) {
        if (
          dbBank[selectedGrade].Topics[selectedTopic].Questions[
            dbBank[selectedGrade].Topics[selectedTopic].ListOrder[
              counterToCountCompletedQs
            ]
          ].Status > 1
        ) {
          countVarr++;
          if (
            dbBank[selectedGrade].Topics[selectedTopic].Questions[
              dbBank[selectedGrade].Topics[selectedTopic].ListOrder[
                counterToCountCompletedQs
              ]
            ].Status == 3
          ) {
            correctVarr++;
          }
        }
      }

      console.log(
        "countVarr & correctVarr: " + countVarr + " & " + correctVarr
      );
      var pUser =
        (correctVarr /
          dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length) *
        100;
      var pTot =
        (countVarr /
          dbBank[selectedGrade].Topics[selectedTopic].ListOrder.length) *
        100;

      console.log("User/Total: " + pUser + " / " + pTot);
      if (dbBank[selectedGrade].Topics[selectedTopic].Status >= 2) {
        Resumeables.timeSpentMilliSeconds += UBJ_API.GetTimeDifference();
        Resumeables.dbFromServer = [];

        UBJ_API.SubmitGameScore(
          pUser,
          pTot,
          UBJ_API.COMPLETION_STATUS.COMPLETED,
          Resumeables.timeSpentMilliSeconds,
          Resumeables
        );
      } else {
        Resumeables.timeSpentMilliSeconds += UBJ_API.GetTimeDifference();

        UBJ_API.SubmitGameScore(
          pUser,
          pTot,
          UBJ_API.COMPLETION_STATUS.INCOMPLETE,
          Resumeables.timeSpentMilliSeconds,
          Resumeables
        );
      }
    }
  }
}

function loadJSONLocal() {
  console.log("Function call: " + "loadJSONLocal");
  parseJSONBank();
  var tempDbBank = JSON.parse(gameService.dbGet("entireDataBank"));
  var isLocalDbTempered = false;
  if (tempDbBank) {
    for (var i = 0; i < tempDbBank.length; i++) {
      for (var j = 0; j < tempDbBank[i].Topics.length; j++) {
        for (var k = 0; k < tempDbBank[i].Topics[j].Questions.length; k++) {
          if (
            tempDbBank[i].Topics[j].Questions[k].qHash !=
            dbBank[i].Topics[j].Questions[k].qHash
          ) {
            console.log(
              "Different hashes (local) at (" +
                i +
                ", " +
                j +
                ", " +
                k +
                "): " +
                tempDbBank[i].Topics[j].Questions[k].qHash +
                " == " +
                dbBank[i].Topics[j].Questions[k].qHash
            );
            isLocalDbTempered = true;
            break;
          }
        }

        if (isLocalDbTempered == true) break;
      }
      if (isLocalDbTempered == true) break;
    }
  } else {
    console.log("+++++++++ Local and Bank DB Lengths are not EQUAL ");
    isLocalDbTempered = true;
  }

  if (isLocalDbTempered == true) {
    console.log("**** Resetting DB");
    resetDatabase();
    saveJSON();
  } else {
    console.log("**** Loading Old DB");
    dbBank = JSON.parse(gameService.dbGet("entireDataBank"));
  }
}

function resetJSON() {
  resetDatabase();
  saveJSON();
}

function playSound(filename, loop) {
  if (gameService.dbGet("IsSoundOn", "NO") != "NO") {
    new gameService.playSound(filename, loop);
    return 1;
  } else {
    return 0;
  }
  return -1;
}

function updateSound(pageName) {
  //        gameService.dbSet("IsSoundOn", "YES");

  if (gameService.dbGet("IsSoundOn", "YES") == "YES") {
    // if(isGamePlayOn == true) {
    if (pageName == AppSet.pages.CoreGame) {
      console.log("Yes, its gameplay page!");
      if (gameService.isSoundPlaying("bg_sound"))
        gameService.stopSound("bg_sound", true);
      if (!gameService.isSoundPlaying("entry_bg_sound"))
        gameService.playSound("entry_bg_sound", true);
    } else {
      console.log("No, its not gameplay page!");
      if (gameService.isSoundPlaying("entry_bg_sound"))
        gameService.stopSound("entry_bg_sound", true);
      if (!gameService.isSoundPlaying("bg_sound"))
        gameService.playSound("bg_sound", true);
    }

    for (var v = 1; v <= 3; v++) {
      if ($("#soundIcon" + v).hasClass("soundOff"))
        $("#soundIcon" + v).removeClass("soundOff");
      if (!$("#soundIcon" + v).hasClass("soundOn"))
        $("#soundIcon" + v).addClass("soundOn");
    }
  } else {
    if (gameService.isSoundPlaying("bg_sound"))
      gameService.stopSound("bg_sound", true);
    if (gameService.isSoundPlaying("entry_bg_sound"))
      gameService.stopSound("entry_bg_sound", true);

    for (var v = 1; v <= 3; v++) {
      if ($("#soundIcon" + v).hasClass("soundOn"))
        $("#soundIcon" + v).removeClass("soundOn");
      if (!$("#soundIcon" + v).hasClass("soundOff"))
        $("#soundIcon" + v).addClass("soundOff");
    }
  }

  /*     switch (pageName) {
             case AppSet.pages.Entry:
                 entry_page.init();
                 break;
             case AppSet.pages.Topic:
                 topic_page.init();
                 break;
         }
     */

  /*     if (gameService.dbGet("IsSoundOn") == "NO") {
             console.log("Sound Turned On");
             gameService.dbSet("IsSoundOn", "YES");
             gameService.playSound("bg_sound", true);
             $('#soundIcon').toggleClass("soundOff");
         } else {
             console.log("Sound Turned Off");
             gameService.dbSet("IsSoundOn", "NO");
             gameService.stopSound("bg_sound");
             $('#soundIcon').toggleClass("soundOff");
         }*/
}

function toggleSound(ContinueMode) {
  //gameService.isSoundPlaying('bg_sound');

  if (gameService.dbGet("IsSoundOn", "NO") == "NO") {
    if (document.getElementById("game_page") != null) {
      console.log("Yes, its gameplay page!");
      if (gameService.isSoundPlaying("bg_sound"))
        gameService.stopSound("bg_sound", true);
      if (!gameService.isSoundPlaying("entry_bg_sound"))
        gameService.playSound("entry_bg_sound", true);
    } else {
      console.log("No, its not gameplay page!");
      if (gameService.isSoundPlaying("entry_bg_sound"))
        gameService.stopSound("entry_bg_sound", true);
      if (!gameService.isSoundPlaying("bg_sound"))
        gameService.playSound("bg_sound", true);
    }

    gameService.dbSet("IsSoundOn", "YES");
    //     playSound("smallPressSound", false);
    //     if(index_page.oldPage=="entry_page" || index_page.oldPage=="topic_page")
    //     {
    //    // gameService.stopSound("bg_sound", true);
    //     //gameService.playSound("entry_bg_sound", true);
    //     }
    //     else
    //     {
    //     gameService.stopSound("entry_bg_sound", true);
    //     gameService.playSound("bg_sound", true);
    //     }
    console.log("Sound On");
    for (var v = 1; v <= 3; v++) {
      if ($("#soundIcon" + v).hasClass("soundOff"))
        $("#soundIcon" + v).removeClass("soundOff");
      if (!$("#soundIcon" + v).hasClass("soundOn"))
        $("#soundIcon" + v).addClass("soundOn");
    }
  } else {
    if (gameService.isSoundPlaying("bg_sound"))
      gameService.stopSound("bg_sound", true);
    if (gameService.isSoundPlaying("entry_bg_sound"))
      gameService.stopSound("entry_bg_sound", true);
    gameService.dbSet("IsSoundOn", "NO");
    console.log("Sound Off");
    for (var v = 1; v <= 3; v++) {
      if ($("#soundIcon" + v).hasClass("soundOn"))
        $("#soundIcon" + v).removeClass("soundOn");
      if (!$("#soundIcon" + v).hasClass("soundOff"))
        $("#soundIcon" + v).addClass("soundOff");
    }
  }
}
