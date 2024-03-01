/*
appDB.Grade[0].Topic[0].ListOfWords["length"]
2
appDB.Grade[0].Topic[0].ListOfWords[0].Word
"Lahore"

appDB.Grade.length

*/
var appDB = {
    "Grade": [{
            Name: "6th",
            "Topic": [{
                    "Name": "Names of Places",
                    "Questions": [{
                        "Word": "Lahore",
                        "Clues": ["Food City", "With few Gates", "In PK"],
                        "Score": 0,
                        "ClueCount": 4,
                        "Lives": 2,
                        "UserEntered": ["Karachi", "Islamabad"]
                    }, {
                        "Word": "Peshawar",
                        "Clues": ["KPK City", "KPK Captial", "Kebabs"],
                        "Score": 0,
                        "ClueCount": 4,
                        "Lives": 2,
                        "UserEntered": ["Karachi", "Islamabad"]
                    }]
                },
                {
                    "Name": "Names of People",
                    "Questions": [{
                        "Word": "Abdullah",
                        "Clues": ["Banda", "Abdul", "Allah"],
                        "Score": 0,
                        "ClueCount": 4,
                        "Lives": 2,
                        "UserEntered": ["Karachi", "Islamabad"]
                    }]
                }
            ]
        },
        {
            Name: "7th",
            "Topic": {
                "Name": "Names of Places",
                "Questions": {
                    "Word": "Lahore",
                    "Clues": ["Food City", "With few Gates", "In PK"],
                    "Score": 0,
                    "ClueCount": 4,
                    "Lives": 2,
                    "UserEntered": ["Karachi", "Islamabad"]
                }
            }
        },
    ]
};

var isFound;
var jsonQuery;
var gradeFound = -1;
var topicFound = -1;
var qFound = -1;
var lastANS = "";
//string uniqueQuestionIdentifierStr;
function parseJSONBank() {
  //dataBank = JSON.parse(JSON.stringify(dataBank));
  console.log("Function call: " + "parseJSONBank");
  console.log("VAR: ", dbBank);

  var labelListQs = [];
  var lastGrade = -1;
  var lastTopic = -1;
  var lastAnswer = -1;
  var lastClueCardNumber = -1;
  for (var i = 0; i < dataBank.length; i++) {
    // console.log("ith value: " + i);
    // console.log("ith value: " + i);
    dataBank[i]["ClueImage"] = dataBank[i]["ClueImage"].trim();
    dataBank[i]["ClueText"] = dataBank[i]["ClueText"].trim();
    dataBank[i]["Answer"] = dataBank[i]["Answer"].trim();
    dataBank[i]["Topic"] = dataBank[i]["Topic"].trim();
    dataBank[i]["ClueType"] = "";
    dataBank[i]["Content"] = "";
    var imageString;
    var audioString;
    if (!(dataBank[i]["ClueImage"].length > 0)) imageString = "";
    // else imageString = "<img src='content/" + dataBank[i]["ClueImage"] + "'>";
    else imageString = "<img src='" + dataBank[i]["ClueImage"] + "'>";

    if (!(dataBank[i]["ClueAudio"].length > 0)) audioString = "";
    // else imageString = "<img src='content/" + dataBank[i]["ClueImage"] + "'>";
    else audioString = dataBank[i]["ClueAudio"];

    if (
      dataBank[i]["ClueImage"].length > 0 &&
      !dataBank[i]["ClueText"].length > 0 &&
      !dataBank[i]["ClueAudio"].length > 0
    ) {
      dataBank[i]["ClueType"] = "Image";
      dataBank[i]["Content"] = imageString;
    } else if (
      !dataBank[i]["ClueImage"].length > 0 &&
      !dataBank[i]["ClueAudio"].length > 0 &&
      dataBank[i]["ClueText"].length > 0
    ) {
      dataBank[i]["ClueType"] = "Text";
      dataBank[i]["Content"] = dataBank[i]["ClueText"];
    } else if (
      dataBank[i]["ClueAudio"].length > 0 &&
      !dataBank[i]["ClueText"].length > 0 &&
      !dataBank[i]["ClueImage"].length > 0
    ) {
      dataBank[i]["ClueType"] = "audio";
      dataBank[i]["Content"] = audioString;
    } else if (
      dataBank[i]["ClueAudio"].length > 0 &&
      dataBank[i]["ClueText"].length > 0 &&
      !(dataBank[i]["ClueImage"].length > 0)
    ) {
      dataBank[i]["ClueType"] = "textandaudio";
      dataBank[i]["Content"] = audioString + dataBank[i]["ClueText"];
    } else if (
      dataBank[i]["ClueAudio"].length > 0 &&
      dataBank[i]["ClueText"].length > 0 &&
      dataBank[i]["ClueImage"].length > 0
    ) {
      dataBank[i]["ClueType"] = "all";
      dataBank[i]["Content"] =
        audioString + imageString + dataBank[i]["ClueText"];
    } else {
      dataBank[i]["ClueType"] = "Both";
      dataBank[i]["Content"] = imageString + dataBank[i]["ClueText"];
    }

    if (!dataBank[i]["ClueType"]) dataBank[i]["ClueType"] = "Text";

    if (dataBank[i]["Grade"].length > 0) {
      console.log("New grade added ", dataBank[i]["Grade"]);
      lastGrade += 1;
      lastTopic = -1;
      lastAnswer = -1;
      lastClueCardNumber = -1;
      dbBank.push({ Name: dataBank[i]["Grade"], Topics: [], Score: 0 });
      // dbBank[lastGrade].Topics.push({ "Name": dataBank[i]["Topic"] , "Lives": totalNumberOfLives ,  "Questions": [],  "ListOrder": [], "Status": 0,  "Score": 0,  "CurrentQuestionInFocus": 0 });
      // dbBank[(dbBank.length - 1)].Topics[(dbBank[(dbBank.length - 1)].Topics.length - 1)].Questions.push({ "Word":  dataBank[i].Answer ,  "ClueType": [ dataBank[i]["ClueType"] ],  "Clues": [ dataBank[i]["Content"] ],  "UserLastEntry":  0 ,  "Score": winningScoreGift ,  "TempScore": 0,  "ClueCount": 0,  "Lives": totalNumberOfLives ,  "Status": 0,  "qHash": ""  });
    }

    if (dataBank[i]["Topic"].length > 0) {
      console.log(
        "Adding new topic " + dataBank[i]["Topic"] + " in grade ",
        lastGrade
      );
      lastTopic += 1;
      lastAnswer = -1;
      lastClueCardNumber = -1;
      dbBank[lastGrade].Topics.push({
        Name: dataBank[i]["Topic"],
        Lives: totalNumberOfLives,
        Questions: [],
        ListOrder: [],
        Status: 0,
        Score: 0,
        CurrentQuestionInFocus: 0,
      });
    }

    if (dataBank[i]["Answer"].length > 0) {
      lastAnswer += 1;
      lastClueCardNumber = -1;
      console.log("lastGrade: ", lastGrade);
      console.log("lastTopic: ", lastTopic);
      console.log("lastAnswer: ", lastAnswer);
      dbBank[lastGrade].Topics[lastTopic].Questions.push({
        Word: dataBank[i].Answer,
        ClueType: [],
        Clues: [],
        UserLastEntry: "0",
        Score: winningScoreGift,
        TempScore: 0,
        ClueCount: 0,
        Lives: totalNumberOfLives,
        Status: 0,
        qHash: "",
      });
    }

    if (
      dataBank[i]["ClueImage"].length > 0 ||
      dataBank[i]["ClueText"].length > 0 ||
      dataBank[i]["ClueAudio"].length > 0
    ) {
      lastClueCardNumber += 1;
      console.log(
        "Adding Clue# " +
          lastAnswer +
          " in grade " +
          lastGrade +
          "and topic " +
          lastTopic
      );
      dbBank[lastGrade].Topics[lastTopic].Questions[lastAnswer].ClueType.push(
        dataBank[i]["ClueType"]
      );

      dbBank[lastGrade].Topics[lastTopic].Questions[lastAnswer].Clues.push(
        dataBank[i]["ClueType"].toLowerCase().trim() == "text"
          ? dataBank[i]["ClueText"]
          : dataBank[i]["ClueType"].toLowerCase().trim() == "both"
          ? imageString + dataBank[i]["ClueText"]
          : dataBank[i]["ClueType"].toLowerCase().trim() == "audio"
          ? audioString
          : dataBank[i]["ClueType"].toLowerCase().trim() == "textandaudio"
          ? audioString + "%$#@!" + dataBank[i]["ClueText"]
          : dataBank[i]["ClueType"].toLowerCase().trim() == "all"
          ? audioString + "%$#@!" + imageString + dataBank[i]["ClueText"]
          : imageString
      );
    }

    /* --- INSERT TEMP CODE HERE --- */
  }

  //     var gradesList = [];
  //     var topicsList = [];
  //     var questionsList = [];
  //     var cluesList = [];

  //     var topicC = [];
  //     var questionC = [];

  //     for (var i = 0; i < dataBank.length; i++) {
  //         dataBank[i]["ClueType"] = "";
  //         dataBank[i]["Content"] = "";
  //         var imageString;
  //         if(dataBank[i]["ClueImage"].length>0)
  //         imageString = "";
  //         else
  //         imageString = "<img src='content/"+dataBank[i]["ClueImage"]+"'>";

  //     }

  //     for (var i = 0; i < dataBank.length; i++) {
  //         if ($.inArray(dataBank[i]["Grade"], gradesList) === -1) {
  //             gradesList.push(dataBank[i]["Grade"]);
  //             dbBank.push(JSON.parse('{ "Name":"' + dataBank[i]["Grade"] + '", "Topics": [], "Score": 0 }'));
  //             topicC[dataBank[i]["Grade"]] = 0;
  //             console.log("New Grade at " + i);
  //         }

  //         if ($.inArray((dataBank[i]["Grade"] + "||" + dataBank[i]["Topic"]), topicsList) === -1) {
  //             console.log("Topic Matched at " + i + " - " + dataBank[i]["Grade"]);
  //             topicsList.push((dataBank[i]["Grade"] + "||" + dataBank[i]["Topic"]));
  //             dbBank[gradesList.indexOf(dataBank[i]["Grade"])].Topics.push(JSON.parse('{ "Name":"' + dataBank[i]["Topic"] + '", "Lives": ' + totalNumberOfLives + ',\n "Questions": [],\n "ListOrder": [], "Status": 0,\n "Score": 0,\n "CurrentQuestionInFocus": 0 }'));
  //             // dbBank.Grade[gradesList.indexOf(dataBank[i]["Grade"]) ].Topic[topicC["Grade"]] = JSON.parse('{ "Name":"'+dataBank[i]["Topic"]+'", "Questions": {} }');
  //             // topicC[dataBank[i]["Grade"]]++;
  //             console.log("New Topic at " + i);
  //         }
  //         //Math.floor(Math.random() * 4) ****for 0 to 3
  //         if ($.inArray((dataBank[i]["Grade"] + "||" + dataBank[i]["Topic"] + "||" + dataBank[i]["Answer"]), questionsList) === -1) {

  //             console.log("Question Matched at " + i + " - " + (dataBank[i]["Grade"] + "||" + dataBank[i]["Topic"]));

  //             questionsList.push((dataBank[i]["Grade"] + "||" + dataBank[i]["Topic"] + "||" + dataBank[i]["Answer"]));

  //             jsonQuery = '{ "Word": "' + dataBank[i].Answer + '",\n "ClueType": ["' + dataBank[i]["ClueType"] + '"],\n "Clues": ["' + dataBank[i]["Content"] + '"],\n "UserLastEntry": "' + 0 + '",\n "Score": ' + winningScoreGift + ',\n "TempScore": 0,\n "ClueCount": 0,\n "Lives": '+totalNumberOfLives+',\n "Status": 0,\n "qHash": ""\n }';
  //             console.log("JSON: " + jsonQuery);
  //             // dbBank[gradesList.indexOf(dataBank[i]["Grade"])].Topics[dbBank[gradesList.indexOf(dataBank[i]["Grade"])].Topics.length-1].Questions = JSON.parse(jsonQuery);
  //             var topicIndex = getTopic(dataBank[i]["Grade"], dataBank[i]["Topic"]);
  //             console.log("topicIndex: ", topicIndex);
  //             if (topicIndex[0] != -1 && topicIndex[1] != -1)
  //                 dbBank[topicIndex[0]].Topics[topicIndex[1]].Questions.push(JSON.parse(jsonQuery));

  //             // dbBank.Grade[gradesList.indexOf(dataBank[i]["Grade"]) ].Topic[topicC["Grade"]] = JSON.parse('{ "Name":"'+dataBank[i]["Topic"]+'", "Questions": {} }');

  //             // questionC[dataBank[i]["Grade"].Topic]++;
  //             console.log("New Question at " + i);

  //         } else {
  //             var topicIndex = getTopic(dataBank[i]["Grade"], dataBank[i]["Topic"]);
  //             console.log("topicIndex: ", topicIndex);
  //             if (topicIndex[0] != -1 && topicIndex[1] != -1) {
  //                 for (var m = 0; m < dbBank[topicIndex[0]].Topics[topicIndex[1]].Questions.length; m++) {
  //                     if (dbBank[topicIndex[0]].Topics[topicIndex[1]].Questions[m].Word == dataBank[i]["Answer"]) {
  //                         dbBank[topicIndex[0]].Topics[topicIndex[1]].Questions[m].ClueType.push(dataBank[i]["ClueType"]);
  //                         dbBank[topicIndex[0]].Topics[topicIndex[1]].Questions[m].Clues.push(dataBank[i]["Content"]);
  //                     }
  //                 }
  //             }
  //         }
  //     }

  //     // for (var i = 0; i < dataBank.length; i++) {
  //     //     if(dbBank["Grade"] == null)
  //     //     {
  //     //         console.log("IF");
  //     //         dbBank["Grade"] = JSON.parse('{ "Name":"'+dataBank[i]["Grade"]+'", "Topic": {} }') ;
  //     //     } else {
  //     //         console.log("ELSE");
  //     //         isFound = false;
  //     //         for(var j = 0; j < dbBank["Grade"].length; j++)
  //     //         {
  //     //             if(dbBank.Grade[j].Name===dataBank[i]["Grade"])
  //     //             {
  //     //                 isFound = true;
  //     //                 break;
  //     //             }
  //     //         }
  //     //         if(isFound == false)
  //     //         {
  //     //             console.log("NO FOUND");
  //     //             dbBank.Grade[dbBank["Grade"].length]== JSON.parse('{ "Name":"'+dataBank[i]["Grade"]+'", "Topic": {} }');
  //     //         }
  //     //     }

  //     //     if(dbBank["Grade.Topic"] == null)
  //     //     {
  //     //         dbBank["Grade"].Topic = dataBank[i]["Topic"];
  //     //     }
  //     // }

  //     //     var grades = {};
  //     // standardsList.forEach( function( item ) {
  //     //     var grade = grades[item.Grade] = grades[item.Grade] || {};
  //     //     grade[item.Domain] = true;
  //     // });

  //     // console.log( JSON.stringify( grades, null, 4 ) );

  //     // var gradesTemp = [];
  //     // var topicsTemp = [];
  //     // var ansTemp = [];
  //     // var statsTemp = [];
  //     // dbBank = "";
  //     // var gradeCount = 0;
  //     // for (var i = 0; i < dataBank.length; i++) {
  //     //     if($.inArray(dataBank[i]["Grade"], gradesTemp) === -1) {
  //     //         gradesTemp.push(dataBank[i]["Grade"]);

  //     //         if(gradeCount==0){
  //     //             gradeCount++;

  //     //             dbBank += '{\n';
  //     //             dbBank += '"Grade":\n';
  //     //             dbBank += '{:\n';
  //     //             dbBank += '\t"Name":'+dataBank[i]["Grade"]+',\n';
  //     //             dbBank += '\t"Topic":'+dataBank[i]["Grade"]+',\n';
  //     //         }
  //     //     }
  //     // }

  //     // var resultG = [];
  //     // var resultT = [];
  //     // var resultA = [];
  //     // var resultCT = [];
  //     // var resultC = [];
  //     // for (var i = 0; i < dataBank.length; i++) {

  //     //     if ($.inArray(dataBank[i]["Grade"], resultG) === -1) {
  //     //         resultG.push(dataBank[i]["Grade"]);
  //     //             appDB.push*()

  //     //     }

  //     //     if (($.inArray(dataBank[i]["Grade"] + "||" + dataBank[i]["Topic"], resultG) === -1)) {
  //     //         resultT.push(dataBank[i]["Grade"] + "||" + dataBank[i]["Topic"]);

  //     //     }

  //     //     if ($.inArray(dataBank[i]["Grade"] + "||" + dataBank[i]["Topic"] + "||" + dataBank[i]["Answer"], resultG) === -1) {
  //     //         resultA.push(dataBank[i]["Grade"] + "||" + dataBank[i]["Topic"] + "||" + dataBank[i]["Answer"]);
  //     //     }

  //     // }
  //     //     if ($.inArray(dataBank[i]["Grade"], result) === -1) {
  //     //         result.push(dataBank[i]["Grade"]);
  //     //     } else {
  //     //         console.log(dataBank[i]["Grade"] + " is not in array");
  //     //     }
  //     // }
  //     // db_parsed = result;

  //     // for (var i = 0; i < dataBank.length; i++) {
  //     //     if ($.inArray(dataBank[i]["T
  //    // opc"], result) === -1) {
  //     //  dbBank[i].Topics[0].Status = 1;       result.push(dataBank[i]["Grade"]);
  //     //     } else {
  //     //         console.log(dataBank[i]["Grade"] + " is not in array");
  //     //     }
  //     // }
  //     // db_parsed = result;

  for (var h1 = 0; h1 < dbBank.length; h1++) {
    for (var h2 = 0; h2 < dbBank[h1].Topics.length; h2++) {
      // var eachFlagSlashF = false;
      for (var h3 = 0; h3 < dbBank[h1].Topics[h2].Questions.length; h3++) {
        dbBank[h1].Topics[h2].Questions[h3].qHash = genHash(
          h1 +
            "-" +
            h2 +
            "" +
            "-" +
            h3 +
            "_" +
            dbBank[h1].Topics[h2].Questions[h3].Word +
            "__" +
            dbBank[h1].Topics[h2].Questions[h3].Clues
        );
        //     if(eachFlagSlashF==false) {
        //     dbBank[h1].Topics[h2].Questions[h3].Clues[0] = dbBank[h1].Topics[h2].Questions[h3].Clues[0].trim();
        //     eachFlagSlashF=true;
        // }

        // for (var h4 = 1; h4 < dbBank[h1].Topics[h2].Questions[h3].Clues.length; h4++) {
        //     dbBank[h1].Topics[h2].Questions[h3].Clues[h4] = dbBank[h1].Topics[h2].Questions[h3].Clues[h4].replace(/\\\\/g, "\\");
        // }
      }
    }
  }

  // for() {

  // }

  console.log(dbBank);
}

function getTopic(grade, topicName) {
  console.log("Function call: " + "getTopic");
  console.log(grade, topicName);
  console.log(dbBank);
  for (var i = 0; i < dbBank.length; i++) {
    for (var j = 0; j < dbBank[i].Topics.length; j++) {
      if (dbBank[i].Name == grade && dbBank[i].Topics[j].Name == topicName)
        return [i, j];
    }
  }
  return [-1, -1];
}
// function getTopicQuestions(grade, topicName) {
//     console.log(grade, topicName);
//     console.log(dbBank);
//     for(var i=0;i<dbBank.length;i++){
//         for(var j=0;j<dbBank[i].Topics.length;j++){
//             if(dbBank[i].Name == grade && dbBank[i].Topics[j].Name == topicName)
//             return [i, j];
//         }
//     }
//     return [-1, -1];
// }

function resetDatabase() {
  console.log("Function call: " + "resetDatabase");
  dbBank = [];
  parseJSONBank();
  for (var i = 0; i < dbBank.length; i++) {
    dbBank[i].Topics[0].Status = 1;
  }

  dbFromServer = JSON.parse(JSON.stringify(dbBank));

  for (var h1 = 0; h1 < dbBank.length; h1++) {
    for (var h2 = 0; h2 < dbBank[h1].Topics.length; h2++) {
      for (var h3 = 0; h3 < dbBank[h1].Topics[h2].Questions.length; h3++) {
        if (dbFromServer[h1].Topics[h2].Questions[h3].Word != null)
          delete dbFromServer[h1].Topics[h2].Questions[h3].Word;
        if (dbFromServer[h1].Topics[h2].Questions[h3].ClueType != null)
          delete dbFromServer[h1].Topics[h2].Questions[h3].ClueType;
        if (dbFromServer[h1].Topics[h2].Questions[h3].Clues != null)
          delete dbFromServer[h1].Topics[h2].Questions[h3].Clues;
      }
    }
  }

  gameService.dbSet("entireDataBank", JSON.stringify(dbBank));
}
