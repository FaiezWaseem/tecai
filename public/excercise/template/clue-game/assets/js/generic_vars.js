var selectedGrade;
var selectedTopic;
var completelyUnblockedTopics = false;
var currentNumberOfLives = 3;
var currentNumberOfClues = 3;
var currentScore = 100;
var totalNumberOfLives = 3;
var totalNumberOfClues = 3;
var totalScore = 100;
var scoreDeductionPerClue = 10;
var scorePerWrongAnswer = 10;
var lifeIncrementAfter = 200;
var clueIncrementAfter = 100;
var winningScore = 10;
var keyTrigger = false;
var gradesList;
var pressedAlreadyFlag = false;

var ulockAllTopics = false;
var topicsList;
var uniqueTopicsList = []; 
var isqHashCorrupted = false;
var cluesList;

var clueCountofQuestions;

var ansList;

var userEnteredResults;

var qStatuses; // 0 null, 1 partial wrong, 2 complete wrong, 3 completed.

var topicsUnlocked = 2;

var gradeAndTopic;

var gradeTopicPair;

var clueCount;

var qNoActive;

var swiper;
var dbBank = [];
var qNoOld;

var defaultNumberOfCluesToShow = 3;
var maxCluesAllowedPerQuestion = 2;

var winningPercentage = 70;
var winningScoreGift = 100;

var classroomMode = false;

var currentBGTrack = "bg_sound";
var dbFromServer;
var resetQuestionsSwitch = false;

var isMenuOpen = false;
var tempTopicDataForReview;

var isGamePlayOn = false;
var prevQinFoc = 0;

var flagEntryMoved = false;
var flagTopicMoved = false;
var isFoundDone = -2;
var isf = -10;
var completionTotalScore = 0;
var completionTotalClues = 0;
var completionQScore = 0;
var lifeReducedFlag = false;

var clearFocusTimeout;
var isAnimPending = false;
var reviewModeOn = false;

var enforcedSurrender = false;