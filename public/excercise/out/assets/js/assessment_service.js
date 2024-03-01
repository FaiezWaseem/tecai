var AssessmentService = {
    allQ: [],
    totalQuestions: 0,
    gameMode: 0,
    GAME_MODES: {
        Assessment: 0,
        Review: 1
    },
    QuestionStatus:{
        Attempted: 0,
        NotAttempted: 1,
        Submitted: 2
    },
    isBookMarked: false,
    questionTimeMS: 0,
    questionNumber: -1,
    curQ: {},
    correctAns: [],
    previousTemplate: "",
    curTemplate: null,
    TotalTimeInMs: 0,
    onTemplateLoad: null,
    start: function (templateLoadCb, questionNumberToResumeFrom) {
        this.onTemplateLoad = templateLoadCb;
        this.questionNumber = -1;
        this.curTemplate = null;
        this.totalQuestions = this.allQ.length;
        this.gameMode = 0;
        this.isBookMarked = false;
        if(questionNumberToResumeFrom != -1){
            this.questionNumberToResumeFrom = questionNumberToResumeFrom;
            this.isBookMarked = true;
        }

        if (this.isBookMarked) {
            console.log("resumed from already bookmarked");
            this.questionNumber = --this.questionNumberToResumeFrom;
            this.nextQuestion();
        }
        else { // new game
            // adding game bits to allQ
            for (var i = 0; i < this.allQ.length; i++) {
                this.allQ[i].Status = this.QuestionStatus.NotAttempted;
                this.allQ[i].isCorrect = false;
                this.allQ[i].TimeInMilliSec = 0;
                this.allQ[i].Answer = [];
                this.allQ[i].isAlreadyRendered = false;
            }
            this.nextQuestion();
        }
        this.TotalTimeInMs = new Date().getTime();
    },

    // call it before new question... 
    // calls setQuestion
    // load ui here etc
    preSetQuestion: function () {
        this.onTemplateLoad(this.curQ.MetaData4);
    },

    // sets question on screen
    // process accroding to question status
    setQuestion: function () {
        this.correctAns = [];
        this.curTemplate.setQuestion(this.curQ);
        this.postSetQuestion();
    },

    // sets screen and timer according to status of question
    postSetQuestion: function () {
        this.curTemplate.UpdateUiOnCheckAnswer(this.curQ.Answer, this.curQ.isCorrect, this.curQ.Status);
        // start timer etc
        if (this.curQ.Status === this.QuestionStatus.NotAttempted) {
            this.startQuestionTimer(this.curQ.TimeInMilliSec);
        }
        // resume timer etc
        // update UI according to attempted answers
        else if (this.curQ.Status === this.QuestionStatus.Attempted) {
            this.startQuestionTimer(this.curQ.TimeInMilliSec);
        }

    },

    // check on screen questions
    // t = isSubmit
    checkOnScreenQuestion: function (t) {
        if (this.curTemplate !== null) {
            this.storeAnswer(this.curTemplate.checkAnswer(t));
            this.stopQuestionTimer();
        }
    },

    // sets Question Timer
    startQuestionTimer: function (oldT) {
        //var t = new Date();
        //t.setSeconds(t.getSeconds() - oldT);
        this.questionTimeMS = new Date().getTime() - oldT; // in milli seconds
    },

    // sets Question Timer
    stopQuestionTimer: function () {
        this.curQ.TimeInMilliSec = new Date().getTime() - this.questionTimeMS;
        this.storeAnswer(this.curQ);
    },

    // calculate answers and stores it back
    finish: function (curLevel) {
        var rightAnswers = 0;
        var i = 0;

        for (i = 0; i < this.allQ.length; i++) {
            if (this.allQ[i].Status === this.QuestionStatus.NotAttempted)
                this.allQ[i].isCorrect = false;

            this.allQ[i].Status = this.QuestionStatus.Submitted;

            if (this.allQ[i].isCorrect)
                rightAnswers++;
        }
        this.isBookMarked = false;
        return rightAnswers;
    },

    startReview: function () {
        this.questionNumber = 0;
        this.curQ = this.allQ[this.questionNumber];
        this.preSetQuestion();
    },

    // just stores curQ object to its actual place
    storeAnswer: function (newCurQ) {
        this.allQ[this.questionNumber] = newCurQ;
    },

    // Sends false in check Question because its not submit button
    nextQuestion: function () {
        this.checkOnScreenQuestion(false);
        if (this.questionNumber === this.totalQuestions - 1) return false;
        this.questionNumber++;
        this.curQ = this.allQ[this.questionNumber];
        this.preSetQuestion();
        return true;
    },

    // Sends false in check Question because its not submit button
    previousQuestion: function () {
        this.checkOnScreenQuestion(false);
        if (this.questionNumber === 0) return false;

        this.questionNumber--;
        this.curQ = this.allQ[this.questionNumber];
        this.preSetQuestion();

        return true;
    },

    gotoQuestion: function (qNum) {
        if (qNum < 0 || qNum > this.allQ.length - 1 || qNum === this.questionNumber)
            return;
        this.checkOnScreenQuestion(false);

        this.questionNumber = qNum;
        this.curQ = this.allQ[this.questionNumber];
        this.preSetQuestion();

        return true;
    },
};

var AssessmentUtility = {

    restorFromBookMark: function () { },

    processAnswers: function () { },

    mjax_conv: function (ele) {
        try {
            MathJax.Hub.Queue(["Typeset", MathJax.Hub, ele]);
        } catch (e) { console.log(e); }
    }
};