function genHash(str) {
    //   console.log("Function call: " + "genHash");
    /*jshint bitwise:false */
    var asString = true;
    var seed = 64;
    var i, l,
        hval = (seed === undefined) ? 0x811c9dc5 : seed;

    for (i = 0, l = str.length; i < l; i++) {
        hval ^= str.charCodeAt(i);
        hval += (hval << 1) + (hval << 4) + (hval << 7) + (hval << 8) + (hval << 24);
    }
    if (asString) {
        // Convert to 8 digit hex string
        return ("0000000" + (hval >>> 0).toString(16)).substr(-8);
    }
    return hval >>> 0;
}

function resetDatabase() {
    //  console.log("Function call: " + "resetDatabase");
    dbBank = [];
    parseJSONBank();
    for (var i = 0; i < dbBank.length; i++) {
        dbBank[i].Topics[0].Status = 1;
    }

    dbFromServer = [];
    // dbFromServer = JSON.parse(JSON.stringify(dbBank));
    // console.log("LOCAL: "+dbBank[0].Topics[2].Questions.length);
    // console.log("SERVER: "+dbFromServer[0].Topics[2].Questions.length);

    // for (var h1 = 0; h1 < dbBank.length; h1++) {
    //     for (var h2 = 0; h2 < dbBank[h1].Topics.length; h2++) {
    //         for (var h3 = 0; h3 < dbBank[h1].Topics[h2].Questions.length; h3++) {
    //             if(dbFromServer[h1].Topics[h2].Questions[h3].Word!=null)
    //             delete dbFromServer[h1].Topics[h2].Questions[h3].Word;
    //             if(dbFromServer[h1].Topics[h2].Questions[h3].ClueType!=null)
    //             delete dbFromServer[h1].Topics[h2].Questions[h3].ClueType;
    //             if(dbFromServer[h1].Topics[h2].Questions[h3].Clues!=null)
    //             delete dbFromServer[h1].Topics[h2].Questions[h3].Clues;
    //         }
    //     }
    // }

    gameService.dbSet('entireDataBank', JSON.stringify(dbBank));
}

function checkLocalTags() {
    // console.log("Function call: " + "checkLocalTags");
    // console.log("VAR: ", dbBank);
    parseJSONBank();
    //  console.log("dbBank-T1: " + dbBank[0].Topics[0].Lives);
    var tempLoc = JSON.parse(gameService.dbGet('entireDataBank', 'false'));
    if (!gameService.dbGet('entireDataBank')) {
        return false;
    }
    if (!tempLoc || tempLoc.length != dbBank.length) {
        // console.log("Different db length or not found");
        // console.log("TempDB: " + tempLoc);
        // console.log("dbBank: " + dbBank);
        return false;
    }

    for (var localCheckPtrG = 0; localCheckPtrG < dbBank.length; localCheckPtrG++) {
        if ((tempLoc[localCheckPtrG].Topics.length != dbBank[localCheckPtrG].Topics.length) || tempLoc[localCheckPtrG].Name != dbBank[localCheckPtrG].Name) {
            //    console.log("Different Topics Name are found at: " + localCheckPtrG);
            return false;
            break;
        }

        for (var lct = 0; lct < dbBank[localCheckPtrG].Topics.length; lct++) {

            if ((tempLoc[localCheckPtrG].Topics[lct].Questions.length != dbBank[localCheckPtrG].Topics[lct].Questions.length) || tempLoc[localCheckPtrG].Topics[lct].Name != dbBank[localCheckPtrG].Topics[lct].Name) {
                //    console.log("Different Topic Content is found at: " + localCheckPtrG + "-" + lct);
                return false;
                break;
            }

            for (var lcqs = 0; lcqs < tempLoc[localCheckPtrG].Topics[lct].Questions.length; lcqs++) {

                if (tempLoc[localCheckPtrG].Topics[lct].Questions[lcqs].qHash != dbBank[localCheckPtrG].Topics[lct].Questions[lcqs].qHash) {
                    console.log("Different qHashes are found at: " + localCheckPtrG + "-" + lct + "-" + lcqs);
                    return false;
                    break;
                }

            }

        }


    }
    //   console.log(dbBank[0].Topics[0]);
    return true;
}


function callIntegrationOfServerDB() {

    //   console.log("Function call: " + "callIntegrationOfServerDB");
    if (Resumeables.dbFromServer) {
        dbBank[selectedGrade].Topics[selectedTopic].ClueCount = Resumeables.dbFromServer.ClueCount;
        dbBank[selectedGrade].Topics[selectedTopic].CurrentQuestionInFocus = Resumeables.dbFromServer.CurrentQuestionInFocus;
        dbBank[selectedGrade].Topics[selectedTopic].ListOrder = Resumeables.dbFromServer.ListOrder;
        dbBank[selectedGrade].Topics[selectedTopic].Lives = Resumeables.dbFromServer.Lives;
        dbBank[selectedGrade].Topics[selectedTopic].Name = Resumeables.dbFromServer.Name;
        dbBank[selectedGrade].Topics[selectedTopic].Score = Resumeables.dbFromServer.Score;
        dbBank[selectedGrade].Topics[selectedTopic].Status = Resumeables.dbFromServer.Status;

        for (var vo = 0; vo < dbBank[selectedGrade].Topics[selectedTopic].Questions.length; vo++) {
            dbBank[selectedGrade].Topics[selectedTopic].Questions[vo].ClueCount = Resumeables.dbFromServer.Questions[vo].ClueCount;
            dbBank[selectedGrade].Topics[selectedTopic].Questions[vo].Lives = Resumeables.dbFromServer.Questions[vo].Lives;
            dbBank[selectedGrade].Topics[selectedTopic].Questions[vo].Score = Resumeables.dbFromServer.Questions[vo].Score;
            dbBank[selectedGrade].Topics[selectedTopic].Questions[vo].Status = Resumeables.dbFromServer.Questions[vo].Status;
            dbBank[selectedGrade].Topics[selectedTopic].Questions[vo].TempScore = Resumeables.dbFromServer.Questions[vo].TempScore;
            dbBank[selectedGrade].Topics[selectedTopic].Questions[vo].UserLastEntry = Resumeables.dbFromServer.Questions[vo].UserLastEntry;
            dbBank[selectedGrade].Topics[selectedTopic].Questions[vo].qHash = Resumeables.dbFromServer.Questions[vo].qHash;
        }

        dbBank[selectedGrade].Topics[selectedTopic].ClueCount = Resumeables.dbFromServer.ClueCount;
        dbBank[selectedGrade].Topics[selectedTopic].Status = dbFromServer.TopicStatus;
        dbBank[selectedGrade].Topics[selectedTopic].Score = dbFromServer.TopicScore;
        dbBank[selectedGrade].Topics[selectedTopic].Lives = dbFromServer.TopicLives;
    } else {
        resetDatabase();
    }
}