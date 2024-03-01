function unique(list) {
    var result = [];
    $.each(list, function (i, e) {
        if ($.inArray(e, result) == -1) result.push(e);
    });
    return result;
}

function unique(dataBank, col) {
    var result = [];
    $.each(dataBank, function (i, e) {
        if ($.inArray(e[col], result) === -1) result.push(e[col]);
    });
    return result;
}

// function unique(list, col, col2) {
//     var result = [];
//     for(var bto = 0; bto < list.length; bto++)
//     {
//         if(e[bto][col]==)
//     }
//     return result;
// }

function valueExistsInJSON(val, databank, col) {
    for (var k = 1; k < databank.length; k++) {
        if (databank[k][col] === val)
            return true;
    }
    return false;
}

function getRowsByValueJSON(val, col, databank) {
    var resultArray = [];
    for (var k = 1; k < databank.length; k++) {
        if (databank[k][col] === val)
            resultArray.push(databank[k]);
    }
    return resultArray;
}

function getUniqueArray(databank, colData) {
    var data = databank;
    var lookup = {};
    var result = [];

    for (var k = 1; k < dataBank.length; k++) {
        if ($.inArray(data[k][colData], result) === -1)
            result.push(data[k][colData]);
    }
    return result;

}

function getUniqueArray2(databank, colData1, colData2, colData3, output) {
    var data = databank;
    var lookup = {};
    var result = [];

    for (var k = 1; k < dataBank.length; k++) {
        if (($.inArray(data[k][colData1], result) === -1) && ($.inArray(data[k][colData2], result) === -1) && ($.inArray(data[k][colData3], result) === -1))
            result.push(data[k][output]);
    }
    return result;

}

function nFormatter(num, digits) {
    var si = [
      { value: 1, symbol: "" },
      { value: 1E3, symbol: "k" },
      { value: 1E6, symbol: "M" },
      { value: 1E9, symbol: "G" },
      { value: 1E12, symbol: "T" },
      { value: 1E15, symbol: "P" },
      { value: 1E18, symbol: "E" }
    ];
    var rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
    var i;
    for (i = si.length - 1; i > 0; i--) {
      if (num >= si[i].value) {
        break;
      }
    }
    return (num / si[i].value).toFixed(digits).replace(rx, "$1") + si[i].symbol;
  }


  
// function getUniqueArray(databank, colData1, colData2, colData3, output, output2, output3) {
//     var data = databank;
//     var lookup = {};
//     var result = [];

//     for (var k = 1; k < dataBank.length; k++) {
//         if (($.inArray(data[k][colData1], result) === -1) && ($.inArray(data[k][colData2], result) === -1) && ($.inArray(data[k][colData3], result) === -1))
//         result.push(data[k][output]);
//     }
//     return result;

// }

// function getWordsandClues(databank, colData1, colData2, qNo) {
//     var data = databank;
//     var lookup = {};
//     var result = [];
//     var resultToPush = {};
//     var uniqueCount = 0;
//     var previousAns = "";
//     var uniqueCountFlag = false;
//     var kStore;
//     for (var k = 1; k < dataBank.length; k++) {
//         if (($.inArray(data[k][colData1], result) === -1) && ($.inArray(data[k][colData2], result) === -1))
//         {
//             if(previousAns!=data[k].Ans)
//             {
//                 uniqueCount++;
//                 uniqueCountFlag = true;

//             }
//             if(uniqueCountFlag == true && uniqueCount == qNo) {
//                 resultToPush.ClueType = data[k].ClueType;
//                 resultToPush.Content = data[k].Content;
//                 uniqueCountFlag = false;
//                 result.push(resultToPush);
//                 resultToPush = {};
//             }
//         }
//     }
//     return result;

// }


function getQuestionsOfTopic() {
    console.log('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', dbBank);
    var results = [];
    for (var k = 1; k < dataBank.length; k++) {
        if ((dataBank[k].Topic==selectedTopic) && (dataBank[k].Grade==selectedGrade) && ($.inArray(dataBank[k].Ans, results) === -1))
            results.push(dataBank[k].Ans);
            // console.log(dataBank[k].Topic + "==" + selectedTopic);
            // console.log(dataBank[k].Grade + "==" + selectedGrade);
            // console.log((dataBank[k].Topic==selectedTopic) && (dataBank[k].Grade==selectedGrade));
    }
    return results;
}


function getQuestionsClues(topicWord) {
    console.log('BBBBBBBBBBBBBBBBBBBBBBBBBBBb', dbBank);
    var results = [];
    var eachResultRow = [];
    for (var k = 1; k < dataBank.length; k++) {
        if ((dataBank[k].Topic==selectedTopic) && (dataBank[k].Grade==selectedGrade) && (dataBank[k].Ans==topicWord)) {
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
}





function loadJSONFromServer() {
    // if(gameService.initParams.grade == undefined)
    // gameService.initParams.grade=0;
    // if(gameService.initParams.level == undefined)
    // gameService.initParams.level=1;
    
console.log("Function call: " + "loadJSONFromServer");
    resetDatabase();    
    dbFromServer = JSON.parse(JSON.stringify(Resumeables.dbFromServer));

    //alert("First clue: " + dbBank[0].Topics[1].Questions[0].Clues[0]);
   // alert("First clue pre: " + dbBank[selectedGrade].Topics[selectedTopic].Questions[qNoActive].Clues(0));
    //bFromServer = JSON.parse(JSON.stringify(dbBank));
    isqHashCorrupted = false;
  
    var fflagselG = true;
    if ((typeof gameService.initParams.grade != undefined && gameService.initParams.grade)) {

        if (dbBank.length == 1) {
            console.log("Number of Grades Fetched: " + dbBank.length);
            selectedGrade = 0;
            //index_page.showPage(AppSet.pages.Topic);
        } else {
           

            console.log("Number of Grades Fetched: " + dbBank.length);
            for (var a = 0; a < dbBank.length; a++) {
                if (dbBank[a].Name == gameService.initParams.grade) {
                    selectedGrade = a;
                    fflagselG = true;
                    break;
                }
            }
            if(fflagselG == false)
            selectedGrade = 0;
        }
    }



    if(parseInt(gameService.initParams.level) >0 && dbBank[selectedGrade].Topics[(gameService.initParams.level-1)])
                {
                    selectedTopic = parseInt(gameService.initParams.level)-1;
                }
                
                var h1 = selectedGrade;
                var h2 = selectedTopic;

//(dbFromServer.length != dbBank[selectedGrade].Topics[selectedTopic].length && (dbFromServer.length+3) != dbBank[selectedGrade].Topics[selectedTopic].length ) || 
  
if(!dbBank[selectedGrade].Topics[selectedTopic] || (dbFromServer.length != dbBank[selectedGrade].Topics[selectedTopic].length && (dbFromServer.length+3 != dbBank[selectedGrade].Topics[selectedTopic].length)) || !dbFromServer)
    {
        isqHashCorrupted = true;
        resetDatabase();
     return;

    }


   // for (var h1 = 0; h1 < dbFromServer.length; h1++) {
        // if(dbFromServer.Topics.length != dbBank[h1].Topics.length)
        // {
        //     isqHashCorrupted = true;
        //     break;
        // }

        // for (var h2 = 0; h2 < dbFromServer.Topics.length; h2++) {
        //     isqHashCorrupted = false;
        //     if(dbFromServer.Topics.length != dbBank[h1].Topics.length)
        //     {
        //         isqHashCorrupted = true;
        //         break;
        //     }
            
        //     if(isqHashCorrupted == true)
        //         break;

        var selTempGradeID = 0;
        var selTempTopicID = 0;
            for(var hx = 0; hx < dbBank.length; hx++) {
                if(gameService.initParams.grade==dbBank[hx].Name) {
                    selTempGradeID = hx;
                    break;
                }
            }

            if(gameService.initParams.level)
            {
               if(dbBank[selTempGradeID].Topics[gameService.initParams.level-1] && gameService.initParams.level > 0 && (gameService.initParams.level-1) < dbBank[selTempGradeID].Topics.length)
               {
                    selTempTopicID = gameService.initParams.level-1;
               } 
            }

            for (var h3 = 0; h3 < dbFromServer.Questions.length; h3++) { 
                if(dbFromServer.Questions.length > h3 && dbBank[selTempGradeID].Topics[selTempTopicID].Questions.length > h3) {
                if(dbFromServer.Questions[h3].qHash!= dbBank[selTempGradeID].Topics[selTempTopicID].Questions[h3].qHash)
                {
                    console.log("qHash of " + h1 + "-" + h2 + "-" + h3 + "is different!");

                    isqHashCorrupted = true;
                    break;
                }
            } else {
                
                console.log("qHash of " + h1 + "-" + h2 + "-" + h3 + "is different!");
                isqHashCorrupted = true;
                break;
            }


                if(isqHashCorrupted == true) {

                    dbBank[h1].Topics[h2].ListOrder = [];
                    dbBank[h1].Topics[h2].Lives = currentNumberOfLives;
                    dbBank[h1].Topics[h2].Score = 0;
                    dbBank[h1].Topics[h2].Status = 0;
                    
                    for(var h4=0; h4<dbBank[h1].Topics[h2].Questions.length; h4++) {

                        console.log("H1: "+h1 + " --- H2: " + h2 + " --- H3:" + h3 + "--- H4:" + h4);
                        dbBank[h1].Topics[h2].Questions[h4].Score = winningScoreGift;
                        dbBank[h1].Topics[h2].Questions[h4].Status = 0;
                        dbBank[h1].Topics[h2].Questions[h4].TempScore = 0;
                        dbBank[h1].Topics[h2].Questions[h4].UserLastEntry = "0";
                        dbBank[h1].Topics[h2].Questions[h4].Lives = 0;
                        dbBank[h1].Topics[h2].Questions[h4].ClueCount = 0; 
                    }

                    continue;
                } else {

                    dbBank[h1].Topics[h2].ListOrder = dbFromServer.ListOrder;
                    dbBank[h1].Topics[h2].Lives = dbFromServer.Lives;
                    dbBank[h1].Topics[h2].Score = dbFromServer.Score;
                    dbBank[h1].Topics[h2].Status = dbFromServer.Status;
                    
                    for(var h4=0; h4<dbBank[h1].Topics[h2].Questions.length; h4++) {

                        if(dbFromServer.Questions.length > h4 && dbBank[h1].Topics[h2].Questions.length > h4) {
                            if(dbFromServer.Questions[h4].qHash!= dbBank[h1].Topics[h2].Questions[h4].qHash)
                            {
                                console.log("qHash of " + h1 + "-" + h2 + "-" + h4 + "is different!");
            
                                isqHashCorrupted = true;
                                break;
                            }
                        } else {
                            
                            console.log("qHash of " + h1 + "-" + h2 + "-" + h4 + "is different!");
                            isqHashCorrupted = true;
                            break;
                        }
            

                        dbBank[h1].Topics[h2].Questions[h4].Score = dbFromServer.Questions[h4].Score;
                        dbBank[h1].Topics[h2].Questions[h4].Status = dbFromServer.Questions[h4].Status;
                        dbBank[h1].Topics[h2].Questions[h4].TempScore = dbFromServer.Questions[h4].TempScore;
                        dbBank[h1].Topics[h2].Questions[h4].UserLastEntry = dbFromServer.Questions[h4].UserLastEntry;
                        dbBank[h1].Topics[h2].Questions[h4].Lives = dbFromServer.Questions[h4].Lives;
                        dbBank[h1].Topics[h2].Questions[h4].ClueCount = dbFromServer.Questions[h4].ClueCount; 
                    }
                    continue;
                }
                //  = genHash(h1+"-"+h2+""+"-"+h3+"_"+dbFromServer.Questions[h3].Word+"__"+dbFromServer.Questions[h3].Clues);
             }

        // }

    //}

//alert("First clue: " + dbBank[0].Topics[1].Questions[0].Clues[0]);
    if(isqHashCorrupted==true)
    {
       // alert("Yes, hash is corrupted");
        resetDatabase();
    }
}

// function areSameTopics(objA, objB)
// {

//     if(objA.Questions.length != objB.Questions.length)
//     {
//         return false;
//     }
//     for(var ptrEachObjK = 0; ptrEachObjK)
//     {

//     }
//     return true;
// }