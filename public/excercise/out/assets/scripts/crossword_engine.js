var AppSet = {
  minScaleFactor: 0.375,
  gameWidth: 854,
  gameHeight: 480,
};

window.gameIsCompleted = false;

function onWindowResize() {
  requestAnimationFrame(() => {
    let iw = window.innerWidth;
    let ih = window.innerHeight;
    var rootElement = document.getElementById("root");
    if (window.oneOnOneWidth) iw = window.oneOnOneWidth;
    if (window.oneOnOneHeight) ih = window.oneOnOneHeight;
    let margin_left = 0,
      margin_top = 0,
      scaleFactor = Math.min(iw / AppSet.gameWidth, ih / AppSet.gameHeight);
    // OrientationNotice.Analyze();

    if (scaleFactor < AppSet.minScaleFactor)
      scaleFactor = AppSet.minScaleFactor;

    //      for (let i = 0; i < this.rootElement.length; i++) {
    rootElement.style.marginLeft = "0";
    rootElement.style.marginTop = "0";
    if (iw / ih > AppSet.gameWidth / AppSet.gameHeight) {
      var tmpWidth = (ih / AppSet.gameHeight) * AppSet.gameWidth;
      margin_left = Math.floor((iw - tmpWidth) / 2);
    } else {
      var tmpHeight = (iw / AppSet.gameWidth) * AppSet.gameHeight;
      margin_top = Math.floor((ih - tmpHeight) / 2);
    }
    rootElement.style.marginLeft = margin_left + "px";
    rootElement.style.marginTop = margin_top + "px";
    scaleAdjustment(rootElement, scaleFactor);
    //    }
  });
}

function scaleAdjustment(e, s) {
  e.style.webkitTransform = "scale(" + s + ")";
  e.style.MozTransform = "scale(" + s + ")";
  e.style.msTransform = "scale(" + s + ")";
  e.style.OTransform = "scale(" + s + ")";
  e.style.transform = "scale(" + s + ")";
}

var words = [];
var hints = [];

/*
 *
 * hintsUsed contains number of hints used.
 * */

function questionAttempted(cIndex, isCorrect, attempted) {
  //cIndex starts from 0, isCorrect will always be true
  RunPlatformCommand(CHALLENGE_GLOBAL.SUBMIT_QUESTION, {
    index: cIndex,
    correct: isCorrect,
    attempted: attempted,
    mistakes: hintsUsed,
  });
}

function gameComplete() {
  RunPlatformCommand(CHALLENGE_GLOBAL.STOP);
}

function homeBtClicked() {
  if (RunPlatformCommand(CHALLENGE_GLOBAL.RESIGN)) return;
}

function getQueryParams(qs) {
  qs = qs.split("+").join(" ");

  var params = {},
    tokens,
    re = /[?&]?([^=]+)=([^&]*)/g;

  while ((tokens = re.exec(qs))) {
    params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
  }

  return params;
}

//var words = ["Enjoy","Notice", "Terrible", "Kite", "Computer", "Earth", "Increase", "Soon","Sofa"];

var keyboardArray = [
  "A",
  "B",
  "C",
  "D",
  "E",
  "F",
  "G",
  "H",
  "I",
  "J",
  "K",
  "L",
  "M",
  "N",
  "O",
  "P",
  "Q",
  "R",
  "S",
  "T",
  "U",
  "V",
  "W",
  "X",
  "Y",
  "Z",
];

var keyboardArray = [
  "Q",
  "W",
  "E",
  "R",
  "T",
  "Y",
  "U",
  "I",
  "O",
  "A",
  "S",
  "D",
  "F",
  "G",
  "H",
  "J",
  "K",
  "L",
  "Z",
  "X",
  "C",
  "V",
  "B",
  "N",
  "M",
  "P",
];
//hintType text image audio

var isHint = true;
var hintsIds = new Object();
var currentHints = 10;
var isAudio = true;
var gridRows = 0;
var gridCols = 0;
var sizeOfBoard = 10;
var bestGrid;
var selectColumn = true;
var selectedElement;
var selectedElementXY;
var oldSelectedElementXY;
var hintsUsed = 0;

var currentIndex = 0;
var cellState = {
  HIDDEN: 0,
  HIGHLIGHT: 1,
  FILLED: 2,
  CORRECT: 3,
  EMPTY: 4,
  SELECTION: 5,
};

var isImageGrid = true;
var currentAnimation;
var currentAudioHint;
var totalCorrect = 0;
var currentWordIndex = 0;
var _this;
var exposeLetterBt;

function initCrossword(__this) {
  _this = __this;
  currentIndex = 0;
  hintsUsed = 0;

  words = [];
  hints = questionsJSON;

  for (var i in questionsJSON) {
    words.push(questionsJSON[i].word);
  }
  /*************/

  for (var i in words) {
    words[i] = words[i].toLowerCase();
  }

  for (var i in hints) {
    hints[i].word = hints[i].word.toLowerCase();
  }

  if (!IsPlatform) {
    shuffle(words);
  }

  words = checkWords(words);
  /* words.forEach(function (value, i) {
       words[i] = value.toUpperCase();
     })*/
  var wordToInsert = words.slice();

  /*  var keyBoardArr = keyBoardChars(words);
      keyBoardArr.sort();
      printKeyBoard(keyBoardArr);*/
  var Inserted = new Array();
  var longestword = longestWord(wordToInsert);
  var n = 100; // number of boards to be made initially

  //try {
  var InitialboardGridArr = initializeBoards(
    Inserted,
    wordToInsert,
    longestword,
    n
  );

  for (var i = 0; i < InitialboardGridArr.length; i++) {
    var board = InitialboardGridArr[i].grid;
    var inserted = InitialboardGridArr[i].inserted;
    var wordToInsert = InitialboardGridArr[i].wordToInsert;
    insertWords(
      InitialboardGridArr[i].grid,
      InitialboardGridArr[i].inserted,
      InitialboardGridArr[i].wordToInsert
    );
  }

  bestGrid = findBestGrid(InitialboardGridArr);
  currentHints = bestGrid.inserted.length;
  //  bestGrid.grid = shrinkGrid(bestGrid, isImageGrid);
  //console.log(bestGrid);

  drawGrid(bestGrid.grid);
  createKeyboard();
  addKeyboardEvents();
  //} catch (error) {
  //   console.log(error);
  //}

  if (!isHint) {
    window.onresize = resizeEvent;
    resizeEvent();
  }

  setInterval(resizeEvent, 1500);

  // _this.textHint.visible = false;
  //_this.imageHint.visible = false;
  //_this.soundHint.visible = false;
  setTimeout(function () {
    selectNextWord();
  }, 200);
  //_this.textHint.txt1.textBaseline = "alphabetic";
  //_this.textHint.txt1.y = 27;
  //_this.textHint.txt2.textBaseline = "alphabetic";
  // _this.textHint.txt2.y = 83;

  totalCorrect = 0;
  // _this.winNote.visible = false;
  initHandlers();
  initAudioHints();
  RunPlatformCommand(CHALLENGE_GLOBAL.START, bestGrid.inserted.length);
  setTimeout(function () {
    //  _this.splash.visible = false;

    UbService.InitTimer();
  }, 20);

  /*blinking logic*/
  setInterval(function () {
    var elems = document.getElementsByClassName("color-5");
    if (elems.length > 0) {
      if (elems[0].className.indexOf("color-7") > -1) {
        elems[0].classList.remove("color-7");
      } else {
        elems[0].classList.add("color-7");
      }
    }
  }, 280);
}

function initHandlers() {
  window.soundBool = true;
  window.isPlay = false;
  //_this.soundBt.gotoAndStop(0);
  document.getElementById("soundBt").addEventListener("click", function (e) {
    // animateBt(e.currentTarget);
    // _this.soundBt.gotoAndStop(window.soundBool ? 1 : 0);

    window.soundBool = !window.soundBool;
    if (window.soundBool) {
      document.getElementById("soundBt1").style.display = "inline";
      document.getElementById("soundBt2").style.display = "none";
    } else {
      document.getElementById("soundBt1").style.display = "none";
      document.getElementById("soundBt2").style.display = "inline";
    }
  });

  document.getElementById("homeBt").addEventListener("click", function (e) {
    animateBt(e.currentTarget);

    if (IsPlatform) {
      homeBtClicked();
      return;
    }
    if (confirm("Are you sure you want to exit the game?")) {
      window.close();
    }
  });

  document.getElementById("imageHintImg").onload = function () {
    document.getElementById("imageLoader").style.display = "none";
  };

  document
    .getElementById("audioHintBt")
    .addEventListener("click", function (e) {
      animateBt(e.currentTarget);
      if (!window.isPlay) playSound(currentAudioHint);
      else stopAllSounds();
    });
}

var audioHintArray = [];
function initAudioHints() {}

var tmpHintData;
var oldHintData;

function setHint() {
  if (selectedElement) {
    var hintData = searchHint(selectedElement.word);

    //console.log("hint data");
    //console.log(hintData);
    if (oldHintData) {
      if (oldHintData[1] == hintData[1]) {
        return;
      }
    }
    oldHintData = hintData;
    var textHint = document.getElementById("textHint");
    var imageHint = document.getElementById("imageHint");
    var audioHint = document.getElementById("audioHint");

    textHint.style.display = "none";
    imageHint.style.display = "none";
    audioHint.style.display = "none";

    if (currentAudioHint != selectedElement.word) {
      stopAllSounds();
    }
    document.getElementById("hintContainer").classList.remove("complete");

    document.getElementById("fireworks").style.display = "none";

    switch (hintData[0].toLowerCase()) {
      case "text":
        textHint.style.display = "flex";
        textHint.style.flexFlow = "column";
        textHint.innerHTML = hintData[1]
          .split("|")
          .join("<br><br><br>")
          .split("\n")
          .join("<br>");

        break;

      case "image":
        imageHint.style.display = "flex";
        document.getElementById("imageLoader").style.display = "block";

        var imageObject = document.getElementById("imageHintImg");

        imageObject.setAttribute(
          "src",
          LOADER.assets[selectedElement.word.toLowerCase()]
        );

        break;

      case "audio":
        audioHint.style.display = "flex";
        //        _this.soundHint.visible = true;
        currentAudioHint = selectedElement.word;
        break;
    }
  }
}

var nextWord = false;
function selectNextWord() {
  // currentWordIndex
  var tmpXY = [-1, -1];
  var i;
  for (i = 0; i < bestGrid.inserted.length; i++) {
    if (!isLocked(bestGrid.inserted[i])) {
      break;
    }
  }

  if (i >= bestGrid.inserted.length) return;

  var element = bestGrid.inserted[i];

  var xy = [element.start, element.pos];
  if (bestGrid.inserted[i].dir != "down") {
    xy = [element.pos, element.start];
  }

  var eventObj = new Object();

  eventObj.currentTarget = document.getElementById(xy[0] + "_" + xy[1]);

  nextWord = true;
  handleClick(eventObj);
}

function resizeEvent(event) {
  KpQuery.css("#gridContainer", {
    "margin-left":
      window.innerWidth / 2 -
      KpQuery.width(KpQuery.getEl("#gridContainer")) / 2,
  });
}

function searchHint(word) {
  var searchedHint = [];
  for (var i = 0; i < hints.length; i++) {
    if (hints[i].word.toLowerCase() == word.toLowerCase()) {
      searchedHint = [hints[i].hintType, hints[i].hint];
    }
  }
  return searchedHint;
}

function animateBt(bt) {
  bt.classList.add("animate__animated");
  bt.classList.add("animate__pulse");

  setTimeout(
    function () {
      this.classList.remove("animate__animated");
      this.classList.remove("animate__pulse");
    }.bind(bt),
    210
  );
}

function animateCell(cellElement, index, gridLength, isCorrect) {
  setTimeout(animateCellAction, index * 80, cellElement, isCorrect);

  if (isCorrect) {
    stopAllSounds();
    playSound("system-correct");
  }
}

function animateCellAction(cellElement, isCorrect) {
  if (!isStateExists(cellElement, cellState.CORRECT)) {
    animateBt(cellElement);
  }

  if (isCorrect) {
    setState(cellElement, cellState.CORRECT);
  }
}

function handleKeyboard(event) {
  animateBt(event.currentTarget);

  keyEvent(event.currentTarget.dataset.value);
}

function createKeyboard() {
  var c;
  var kButton;
  var row = 0;
  var column = 0;
  //  _this.keyboardContainer.x -= 61;
  // _this.keyboardContainer.y = 362.5;

  exposeLetterBt = document.getElementById("hintBt");
  for (var i = 0; i < keyboardArray.length; i++) {
    // A-65, Z-90
    c = keyboardArray[i];
    //    kButton = new lib.KeyboardButton();
    kButton = document.createElement("div");
    kButton.className = "keyboard-tile";
    document.getElementById("keyboardContainer").append(kButton);

    kButton.dataset.value = c;
    kButton.innerText = c;

    kButton.style.left = row * 48 + "px";

    kButton.style.top = column * 48 + "px";

    //    kButton.scaleX = kButton.scaleY = 0.98;

    kButton.addEventListener("click", handleKeyboard);

    // kButton.bg.cache(-25, -25, 100, 100, 2);

    // _this.keyboardContainer.addChild(kButton);
    row++;
    if (row % 9 == 0) {
      row = 0;
      column++;
    }
  }

  kButton = document.createElement("div");
  kButton.className = "keyboard-tile keyboard-backspace";
  kButton.style.left = row * 48 + "px";
  kButton.dataset.value = "backspace";

  kButton.style.top = column * 48 + "px";

  document.getElementById("keyboardContainer").append(kButton);

  kButton.innerHTML = "";

  kButton.addEventListener("click", handleKeyboard);

  var hintBt = document.getElementById("hintBt");

  hintBt.addEventListener("click", exposeLetter);

  document.getElementById("hintText").innerText = currentHints;

  /*if (IsPlatform) {
    _this.exposeLetterKey.visible = false;
  }*/
}

function exposeLetter(event) {
  if (currentHints <= 0 || exposeLetterBt.style.opacity < 0.9) return;

  try {
    if (
      !(
        document
          .getElementById(selectedElementXY[0] + "_" + selectedElementXY[1])
          .className.indexOf("highlight") > -1
      ) ||
      isStateExists(
        document.getElementById(
          selectedElementXY[0] + "_" + selectedElementXY[1]
        ),
        cellState.CORRECT
      )
    ) {
      return;
    }
  } catch (e) {}

  animateBt(event.currentTarget);

  hintsUsed = hintsUsed + 1;
  currentHints = currentHints - 1;
  document.getElementById("hintText").innerText = currentHints;

  if (currentHints == 0) {
    setTimeout(function () {
      exposeLetterBt.style.opacity = 0.6;
      exposeLetterBt.classList.add("no-cursor");
    }, 100);
  }
  if (selectedElement) {
    var element = selectedElement;
    var j = 0;
    for (var i = 0; i <= element.end - element.start; i++) {
      if (element.dir == "down") {
        tmpXY = [element.start + i, element.pos];
      } else {
        tmpXY = [element.pos, element.start + i];
      }

      if (
        tmpXY[0] == selectedElementXY[0] &&
        tmpXY[1] == selectedElementXY[1]
      ) {
        break;
      }

      j++;
    }

    var elem = document.getElementById(
      selectedElementXY[0] + "_" + selectedElementXY[1]
    );

    keyEvent(selectedElement.word.charAt(j));

    setState(elem, cellState.CORRECT);
    elem.dataset.locked = "true";
  }
}

function isLocked(element) {
  var isCorrect = true;
  for (var i = 0; i <= element.end - element.start; i++) {
    if (element.dir == "down") {
      tmpXY = [element.start + i, element.pos];
    } else {
      tmpXY = [element.pos, element.start + i];
    }
    if (!isStateExists(tmpXY[0] + "_" + tmpXY[1], cellState.CORRECT)) {
      {
        isCorrect = false;
        break;
      }
    }
  }
  return isCorrect;
}

function getObjectUnderPoint(rI, cI) {
  var objArr = [];
  var returnElement;
  bestGrid.inserted.forEach(function (element, index) {
    if (element.dir == "down") {
      if (cI == element.pos && rI >= element.start && rI <= element.end) {
        objArr.push(element);
      }
    } else {
      if (rI == element.pos && cI >= element.start && cI <= element.end) {
        objArr.push(element);
      }
    }
  });

  if (objArr.length > 1) {
    returnElement = objArr[0];
    var availableCount = 0;

    if (isLocked(objArr[0]) && isLocked(objArr[1])) {
      //return false;
    }

    if (isLocked(objArr[0])) {
      returnElement = objArr[1];
    } else if (isLocked(objArr[1])) {
      returnElement = objArr[0];
    } else if (selectedElement == objArr[0]) {
      returnElement = objArr[1];
    } else if (selectedElement == objArr[1]) {
      returnElement = objArr[0];
    } else {
      returnElement = objArr[selectColumn ? 1 : 0];
    }
    selectColumn = !selectColumn;
  } else {
    returnElement = objArr[0];
  }

  if (isLocked(returnElement)) {
    //  return false;
  }

  return returnElement;
}

function setHighlight(element, visible, isCorrect, isNotAnimate) {
  var tmpXY = [-1, -1];
  var tmpElem;
  for (var i = 0; i <= element.end - element.start; i++) {
    if (element.dir == "down") {
      tmpXY = [element.start + i, element.pos];
    } else {
      tmpXY = [element.pos, element.start + i];
    }

    tmpElem = document.getElementById(tmpXY[0] + "_" + tmpXY[1]);
    // tmpElem.highlight.visible = visible;
    if (visible) {
      tmpElem.classList.add("highlight");
    } else {
      tmpElem.classList.remove("highlight");
    }

    if (!visible && isStateExists(tmpElem, cellState.SELECTION)) {
      if (tmpElem.innerText == "") setState(tmpElem, cellState.EMPTY);
      else setState(tmpElem, cellState.FILLED);
    }
    if (isCorrect) {
      tmpElem.dataset.locked = "true";
      // tmpElem.highlight.visible = false;
      tmpElem.classList.remove("highlight");
      animateCell(tmpElem, i, element.end - element.start, true);
    } else if (isStateExists(tmpElem, cellState.CORRECT) && visible) {
      if (!isNotAnimate)
        animateCell(tmpElem, i, element.end - element.start, false);
    }
  }

  if (isCorrect) {
    if (IsPlatform) {
      questionAttempted(currentIndex, true, bestGrid.inserted.length);
    }
    console.log("UbService", UbService);
    if (UbService?.is_ExternalLMS) {
      UbService.submitToExternalCms(
        bestGrid.inserted.length,
        currentIndex,
        UbService.GetTimeDifference(),
        hintsUsed
      );
      //   questionAttempted(currentIndex, true, bestGrid.inserted.length,words);
    } else if (UbService?.initParams?.is_offline_lms || UbService?.initParams.is_postbookmarking) {
      UbService.submitToExternalCms(
        bestGrid.inserted.length,
        currentIndex,
        UbService.GetTimeDifference(),
        hintsUsed
      );
    }

    currentIndex++;
    totalCorrect++;
    if (totalCorrect == bestGrid.inserted.length) {
      if (IsPlatform) {
        gameComplete();
      }

      UbService.SubmitGameScore(
        "100",
        100,
        UbService.COMPLETION_STATUS.COMPLETED,
        UbService.GetTimeDifference(),
        {}
      );

      window.gameIsCompleted = true;
      textHint.style.display = "none";
      imageHint.style.display = "none";
      audioHint.style.display = "none";
      textHint.style.display = "flex";
      textHint.style.flexFlow = "column";
      textHint.innerHTML =
        '<span style="font-size:22px;">Congratulations!!</span>';
      //document.getElementById("hintContainer").classList.add("complete");
      document.getElementById("fireworks").style.display = "block";
      setTimeout(function () {
        stopAllSounds();
        playSound("system-win");
      }, 500);
    }

    setTimeout(function () {
      selectNextWord();
    }, (element.end - element.start + 1) * 80);
  }
}

function getFirstIndex(element) {
  var pos = [-1, -1];
  for (var i = 0; i <= element.end - element.start; i++) {
    if (element.dir == "down") {
      if (
        document.getElementById(element.start + i + "_" + element.pos).innerText
          .length == 0
      ) {
        pos = [element.start + i, element.pos];
        return pos;
      }
    } else {
      if (
        document.getElementById(element.pos + "_" + (element.start + i))
          .innerText.length == 0
      ) {
        pos = [element.pos, element.start + i];
        return pos;
      }
    }
  }
  return pos;
}

function isStateExists(key, state) {
  if (typeof key === "string" || key instanceof String) {
    return (
      document.getElementById(key).className.indexOf("color-" + state) > -1
    );
  }

  return key.className.indexOf("" + state) > -1;
}

function setState(elem, state) {
  for (var i = 1; i < 6; i++) {
    elem.classList.remove("color-" + i);
  }
  elem.classList.add("color-" + state);
}

function getNextIndex(element, rI, cI, reversed) {
  var newPos = [-1, -1];
  if (element.dir == "down") {
    newPos[0] = element.start + (rI - element.start) + (reversed ? -1 : 1);
    newPos[1] = cI;
  } else {
    newPos[0] = rI;
    newPos[1] = element.start + (cI - element.start) + (reversed ? -1 : 1);
  }

  if (
    newPos[0] < 0 ||
    newPos[1] < 0 ||
    newPos[0] > sizeOfBoard - 1 ||
    newPos[1] > sizeOfBoard - 1
  ) {
    return [-1, -1];
  }

  if (isStateExists(newPos[0] + "_" + newPos[1], cellState.HIDDEN)) {
    return [-1, -1];
  }
  if (
    document.getElementById(newPos[0] + "_" + newPos[1]).dataset.locked ===
    "true"
  ) {
    newPos = getNextIndex(element, newPos[0], newPos[1], reversed);
  }

  return newPos;
}

function checkAnswer(element) {
  var tmpString = "";
  for (var i = 0; i <= element.end - element.start; i++) {
    if (element.dir == "down") {
      tmpString += document.getElementById(
        element.start + i + "_" + element.pos
      ).innerText;
    } else {
      tmpString += document.getElementById(
        element.pos + "_" + (element.start + i)
      ).innerText;
    }
  }

  if (element.word.toLowerCase() == tmpString.toLowerCase()) {
    //addGridClass(element, "locked olocked");
    setHighlight(element, false, true);

    return true;
  }

  return false;
}

function keyEvent(key) {
  if (window.gameIsCompleted) return;
  console.log(
    document.getElementById(selectedElementXY[0] + "_" + selectedElementXY[1])
      .className
  );
  try {
    if (
      !(
        document
          .getElementById(selectedElementXY[0] + "_" + selectedElementXY[1])
          .className.indexOf("highlight") > -1
      )
    ) {
      return;
    }
  } catch (e) {}

  playSound("system-click");
  oldSelectedElementXY = selectedElementXY.slice();

  var currentElement = document.getElementById(
    selectedElementXY[0] + "_" + selectedElementXY[1]
  );

  console.log(selectedElementXY[0] + "_" + selectedElementXY[1]);
  var backspace = false;
  if (selectedElement) {
    if (currentElement.dataset.locked === "true") {
      return;
    }

    console.log(currentElement);
    setState(currentElement, cellState.FILLED);
    currentElement.innerText = key.toUpperCase();

    if (key == "backspace") {
      currentElement.innerText = "";
      setState(currentElement, cellState.EMPTY);
      backspace = true;
    }
    selectedElementXY = getNextIndex(
      selectedElement,
      selectedElementXY[0],
      selectedElementXY[1],
      backspace
    );

    //console.log("selectedXY");
    //console.log(selectedElementXY);

    if (backspace) {
      if (selectedElementXY[0] < 0) {
        selectedElementXY = oldSelectedElementXY.slice();
      }
      document.getElementById(
        selectedElementXY[0] + "_" + selectedElementXY[1]
      ).innerText = "";
    }

    if (
      checkAnswer(selectedElement) ||
      (selectedElementXY[0] == -1 && !checkAnswer(selectedElement))
    ) {
      selectedElementXY = oldSelectedElementXY.slice();
    }
    //  else {
    setState(
      document.getElementById(
        selectedElementXY[0] + "_" + selectedElementXY[1]
      ),
      cellState.SELECTION
    );
    // }

    // setHighlighter();
  }
}

function addKeyboardEvents() {
  if (IsPlatform || IsCMSPlatform)
    setInterval(function () {
      window.focus();
    }, 500);
  window.onkeydown = function (event) {
    if (
      ((event.which < 65 || event.which > 90) && event.keyCode != 8) ||
      window.gameIsCompleted
    ) {
      return;
    }

    event.preventDefault();

    if (event.keyCode == 8) {
      keyEvent("backspace");
    } else {
      keyEvent(event.key);
    }
  };
}

function isFirstLetter(rI, cI) {
  var isThere = false;
  bestGrid.inserted.forEach(function (element, index) {
    if (
      (rI == element.start && element.pos == cI && element.dir == "down") ||
      (cI == element.start && element.pos == rI && element.dir == "across")
    ) {
      isThere = true;
    }
  });
  return isThere;
}

function handleClick(event) {
  //  _this.winNote.visible = false;

  playSound("system-selection");
  console.log("selectedElement");
  console.log(selectedElement);
  if (selectedElement) setHighlight(selectedElement, false);

  var curTarget = event.currentTarget;

  //if (curTarget.currentFrame == cellState.CORRECT) return;
  //if (curTarget.locked && !curTarget.isFirst) return;

  var cX = parseInt(curTarget.id.split("_")[0]);
  var cY = parseInt(curTarget.id.split("_")[1]);
  var curElement = getObjectUnderPoint(cX, cY);

  console.log("curElement");
  console.log(curElement);
  //console.log("curElement");
  //console.log(curElement);
  if (curElement == false) return;

  setHighlight(curElement, true, false, curElement == selectedElement);
  selectedElement = curElement;

  var firstElementPos = getFirstIndex(curElement);
  if (nextWord) {
    nextWord = false;
  } else {
    firstElementPos[0] = -1;
  }
  if (firstElementPos[0] != -1) {
    //curElement = getObjectUnderPoint(firstElementPos[0], firstElementPos[1]);
    cX = firstElementPos[0];
    cY = firstElementPos[1];
  }

  var tmpI = [cX, cY];

  if (
    event.currentTarget.dataset.locked === "true" &&
    firstElementPos[0] == -1
  ) {
    // change to && if firstElement
    for (var i = 0; i < sizeOfBoard; i++) {
      tmpI = getNextIndex(curElement, tmpI[0], tmpI[1]);
      if (document.getElementById(tmpI[0] + "_" + tmpI[1]) == null) {
        setHint();
        return;
      }
      if (
        !(
          document.getElementById(tmpI[0] + "_" + tmpI[1]).dataset.locked ===
          "true"
        )
      ) {
        break;
      }
    }
  }

  selectedElementXY = tmpI;

  setState(
    document.getElementById(selectedElementXY[0] + "_" + selectedElementXY[1]),
    cellState.SELECTION
  );
  //console.log("selectedElement2");

  //console.log(selectedElement);
  setHint();
}

var gridBoxSize = 33;

/*
 
function drawGrid(grid)
To draw a grid
 
*/
function drawGrid(grid) {
  var curX = 0;
  var curY = 0;

  grid.forEach(function (gridRow, indexRow) {
    curY = 0;
    gridRow.forEach(function (gridColumn, indexColumn) {
      curState = cellState.EMPTY;

      isFirst = isFirstLetter(indexRow, indexColumn);

      if (gridColumn.length == 0) curState = cellState.HIDDEN;
      if (isFirst) curState = cellState.FILLED;

      var elem = document.createElement("div");
      elem.className = "tile";
      document.getElementById("gridContainer").append(elem);

      elem.style.left = (gridBoxSize + 5) * curX + "px";
      elem.style.top = (gridBoxSize + 5) * curY + "px";

      elem.classList.add("color-" + curState);
      setState(elem, curState);
      //   elem.gotoAndStop(curState);
      //  elem.highlight.visible = false;
      // _this.gridContainer.addChild(elem);

      if (curState == cellState.HIDDEN) {
        //  elem.cache(-25, -25, 50, 50, 2);
      }

      if (isFirst) {
        elem.innerText = gridColumn.toUpperCase();
      }

      elem.dataset.locked = isFirst ? "true" : "false";

      elem.dataset.isFirst = isFirst ? "true" : "false";
      elem.id = indexRow + "_" + indexColumn;
      elem.dataset.state = curState;
      // elem.name = indexRow + "_" + indexColumn;

      // elem.mouseChildren = false;

      // elem.scaleX = elem.scaleY = 0.85;

      //elem.txt.textBaseline = "alphabetic";

      //elem.txt.x -= 2.2;
      //elem.txt.y += 20;

      if (curState != cellState.HIDDEN)
        elem.addEventListener("click", function (event) {
          handleClick(event);
        });

      curY++;
    });
    curX++;
  });
}
/*
  function checkWords(words)
  Description: makes sure no word is bigger than "sizeOfBoard"
  input: words - an array of strings containing words to be inserted
*/
function checkWords(words) {
  var newWords = words.filter(function (word) {
    if (word.length - 1 > sizeOfBoard - 1) {
      return false;
    } else {
      return true;
    }
  });
  return newWords;
}

/* function create_grid(size)
 
  Description: initializes a 2-dimensional grid of size "size". All places are initialized to empty strings
 
  input:        size - size of the array to be initialized
 
  output:       grid - 2-dimensional array of size "size"
 
*/
function create_grid(size) {
  var grid_length = size;
  var grid = new Array(grid_length);
  for (var i = 0; i < grid_length; i++) {
    grid[i] = new Array(grid_length);
  }
  for (var i = 0; i < grid_length; i++) {
    for (var j = 0; j < grid_length; j++) {
      grid[i][j] = "";
    }
  }
  return grid;
}

/*  function initializeBoard(word)
 
    Description: puts the first word in grid vertically in the middle of the board
 
    input:       word - first word to be inserted in grid
 
    output:      grid - grid containing only the first word
 
*/
function initializeBoard(word) {
  var grid = create_grid(sizeOfBoard);
  var start = Math.floor((sizeOfBoard - (word.length - 1)) / 2);
  var middleCol = Math.floor(sizeOfBoard / 2);
  var wordIndex = 0;
  for (var i = start; i <= start + word.length - 1; i++) {
    grid[i][middleCol] = word.charAt(wordIndex);
    wordIndex++;
  }
  return grid;
}

var selectedWord = null;
var selectedCharId = null;

/*
  function wordInGrid(word, dir, start, end, pos)
 
  Description: constructor for object wordInGrid, initializes values according to parameters
  input:       word   - string signifying the word
               dir    - across or down
               start  - start position of word in grid
               end    - end position of word in grid
               pos    - if dir is across, pos signifies row of word. And if dir is down
                        pos signifies column of word
*/

function wordInGrid(word, dir, start, end, pos) {
  //data structure defining a word Inserted in grid telling the start, end and direction (across or down)
  this.word = word;
  this.dir = dir;
  this.start = start;
  this.end = end;
  this.pos = pos; // index in row or column
}
wordInGrid.prototype = {
  word: "",
  dir: "",
  start: -1,
  end: -1,
  pos: -1,
};

/*
  function checkisValidEntry(intersection, wordsInserted, intersectingWord)
 
  Description: checks if the intersection is valid or not by checking if it crosses another word or
               if it goes outside the board
 
  input:       intersection     - of type wordInGrid signifying a potential place a word can be inserted in
               wordsInserted    - an array of type wordInGrid containing words already in grid
               intersectingWord - a word of type wordInGrid signifying the word "intersection" is intersecting with
  output       bool             - true if intersection is valid,
                                  false if intersection is invalid.
*/

function checkisValidEntry(intersection, wordsInserted, intersectingWord) {
  for (var i = 0; i < wordsInserted.length; i++) {
    if (
      intersection.start < 0 ||
      intersection.end > sizeOfBoard - 1 ||
      intersection.pos < 0 ||
      intersection.pos > sizeOfBoard - 1
    ) {
      return false;
    }

    if (
      intersection.dir === wordsInserted[i].dir &&
      (intersection.pos === wordsInserted[i].pos ||
        (intersection.pos - 1 === wordsInserted[i].pos &&
          !(
            (wordsInserted[i].start === intersectingWord.pos &&
              intersection.end === wordsInserted[i].start) ||
            (wordsInserted[i].end === intersectingWord.pos &&
              intersection.start === wordsInserted[i].end)
          )) ||
        (intersection.pos + 1 === wordsInserted[i].pos &&
          !(
            (wordsInserted[i].start === intersectingWord.pos &&
              intersection.end === wordsInserted[i].start) ||
            (wordsInserted[i].end === intersectingWord.pos &&
              intersection.start === wordsInserted[i].end)
          ))) &&
      ((intersection.start >= wordsInserted[i].start - 1 &&
        intersection.start <= wordsInserted[i].end + 1) ||
        (wordsInserted[i].start >= intersection.start - 1 &&
          wordsInserted[i].start <= intersection.end + 1))
    ) {
      return false;
      break;
    } else if (
      wordsInserted[i].word !== intersectingWord.word &&
      intersection.dir !== wordsInserted[i].dir &&
      intersection.end + 1 >= wordsInserted[i].pos &&
      intersection.start - 1 <= wordsInserted[i].pos &&
      intersection.pos <= wordsInserted[i].end + 1 &&
      intersection.pos >= wordsInserted[i].start - 1
    ) {
      if (
        !(
          intersection.word.charAt(
            wordsInserted[i].pos - intersection.start
          ) ===
          wordsInserted[i].word.charAt(
            intersection.pos - wordsInserted[i].start
          )
        )
      ) {
        return false;
        break;
      }
    }
  }
  return true;
}

/*   function wordIntersections(word, wordsInserted)
 
    Description: finds and returns all valid intersection of "word" with words inserted in grid
 
    input:       word          - string to be checked for intersections in board
                 wordsInserted - array of words, of type wordInGrid, present in board
 
    output:      intersections - an array of type wordInGrid containing all possible intersection positions of "word"
 
*/
function wordIntersections(word, wordsInserted) {
  var intersections = new Array();
  var dir, toInsertValstart, toInsertValend;
  try {
    wordsInserted.forEach(function (valInGrid, index) {
      for (var i = 0; i < word.length; i++) {
        for (var j = 0; j < valInGrid.word.length; j++) {
          if (word.charAt(i) === valInGrid.word.charAt(j)) {
            if (valInGrid.dir === "down") {
              dir = "across";
            } else if (valInGrid.dir === "across") {
              dir = "down";
            } else {
              throw error("inBoardValCoords not defined");
            }
            var intersection = new wordInGrid(
              word,
              dir,
              valInGrid.pos - i,
              valInGrid.pos - i + (word.length - 1),
              j + valInGrid.start
            );
            var isValid = checkisValidEntry(
              intersection,
              wordsInserted,
              valInGrid
            );
            if (isValid === true) {
              intersections.push(intersection);
            }
          }
        }
      }
    });
    return intersections;
  } catch (error) {
    console.log(error);
  }
}

/*
  function insertIngrid(grid, intersections, Inserted, wordToInsert)
 
  Description: inserts "intersection" in grid
 
  input:       grid         - the grid in which word is to be inserted
               intersection - the word to be inserted in grid
               Inserted     - an array of type wordInGrid containing words present in the grid.
                              "intersection" is pushed into this array
               wordToInsert - an array of strings containing words left to insert
*/
function insertIngrid(grid, intersection, Inserted, wordToInsert) {
  if (intersection !== null) {
    var word = intersection.word;
    var wordIndex = 0;
    var start = intersection.start;
    if (intersection.start >= 0 && intersection.end < sizeOfBoard) {
      if (intersection.dir === "across") {
        for (var i = start; i < start + word.length; i++) {
          grid[intersection.pos][i] = word.charAt(wordIndex);
          wordIndex++;
        }
      } else {
        for (var i = start; i < start + word.length; i++) {
          grid[i][intersection.pos] = word.charAt(wordIndex);
          wordIndex++;
        }
      }
      removeString(wordToInsert, word);
      Inserted.push(intersection);
    }
  } else {
    throw error("Null exception");
  }
}

/*
  function removeString(array, string)
  Description: function removes a string from a string of arrays
 
  input:       array  - an array of strings, from which a string needs to be deleted
               string - the string that needs to be deleted from the array
*/
function removeString(array, string) {
  for (var i = 0; i < array.length; i++) {
    if (array[i] === string) {
      array.splice(i, 1);
    }
  }
}

/*
  function findBestIntersection(intersections, Inserted, wordToInsert)
  Description: forward checks an intersection to determine which intersection reduces
               the number of intersections for the next state the least.
 
  input:       intersections - an array of arrays of type wordInGrid containing possible intersections
               Inserted      - an array of type wordInGrid containing words inserted in grid.
               wordToInsert  - an array of strings containing words that remain to be inserted in the grid
 
  output:      bestVal       - of type wordInGrid signifying the best value to be inserted out of all the intersections.
*/
function findBestIntersection(intersections, Inserted, wordToInsert) {
  var possibleIntersections = new Array();
  var maxIntersections = 0;
  var zeroes = 0;
  var minZeroes = 99999;
  var bestVal = intersections[0][0];
  intersections.forEach(function (intersection, i) {
    intersection.forEach(function (val, j) {
      Inserted.push(val);

      wordToInsert.forEach(function (word, index) {
        var intersection = wordIntersections(word, Inserted);
        if (intersection !== null) {
          possibleIntersections.push(intersection);
        }
      });
      possibleIntersections.forEach(function (intersection, val) {
        if (intersection.length === 0) {
          zeroes++;
        }
      });
      if (zeroes < minZeroes) {
        minZeroes = zeroes;
        bestVal = val;
      }
      Inserted.pop();
    });
  });
  if (bestVal !== null) {
    return bestVal;
  } else {
    return null;
  }
}

/*
  function findMin(possibleIntersectionsArr)
  Description: Helper function to firstofSize. Given an array of possible intersections returns the one with the
               least number of zero intersections of a word in the next state
 
  input:       possibleIntersectionsArr - an array of type {intersections: possibleIntersections, nextStateZeroes: zeroes, intersect: val}
                                          where "intersections" is an array of intersections that result from inserting "intersect" in the grid,
                                          and nextStateZeroes are the number of arrays having zero intersections for a given word.
  output:      minI                     - the value that has the least value for "nextStateZeroes"
*/
function findMin(possibleIntersectionsArr) {
  var min = possibleIntersectionsArr[0].nextStateZeroes;
  var minIndex = 0;
  var minI = possibleIntersectionsArr[0].intersect;
  for (var i = 0; i < possibleIntersectionsArr.length; i++) {
    if (possibleIntersectionsArr[i].nextStateZeroes < min) {
      min = possibleIntersectionsArr[i].nextStateZeroes;
      minI = possibleIntersectionsArr[i].intersect;
      minIndex = i;
    }
  }
  possibleIntersectionsArr.splice(minIndex, 1);
  return minI;
}

/*
  function firstofSize()
  Description: returns best intersections of size "size", if possibleIntersectionsArr.length
               is grater than size, or of size possibleIntersectionsArr.length if length of array is less than size
               by calculating min zeroes
 
  input:       possibleIntersectionsArr - an array containing intersections, number of next state zeroes,
                                          and the word that resulted in those intersections
              size                      - the size of array to be returned
 
  output:     sortedArr                 - array of type wordInGrid containing min "size" values.
*/

function firstofSize(possibleIntersectionsArr, size) {
  if (possibleIntersectionsArr.length > size) {
    var sortedArr = new Array(size);
    for (var i = 0; i < size; i++) {
      sortedArr[i] = findMin(possibleIntersectionsArr);
    }
  } else {
    var sortedArr = [];
    var length = possibleIntersectionsArr.length;
    for (var i = 0; i < length; i++) {
      var minVal = findMin(possibleIntersectionsArr);
      if (minVal !== null) {
        sortedArr.push(minVal);
      }
    }
  }
  return sortedArr;
}

/*
  function findBestIntersections
  Description: takes an array of intersections and performs forward checking to determine
               intersections that reduce the next state intersections the least, and returns
               an array of size "size" containing best intersections
  input:       intersections - an array of arrays of type wordInGrid. Each sub array
                               corresponds to a word that needs to be inserted.
               Inserted      - an array of type wordInGrid containing words inserted in board
               wordToInsert  - an array of strings containing words to be inserted in grid
               size          - size of intersections array to return
  output:      firstOfSize   - an array of type wordInGrid containing best intersections of
                               size "size"
 
*/
function findBestIntersections(intersections, Inserted, wordToInsert, size) {
  var possibleIntersections = new Array();
  var possibleIntersectionsArr = new Array();
  var zeroes = 0;
  intersections.forEach(function (intersection, i) {
    intersection.forEach(function (val, j) {
      zeroes = 0;
      Inserted.push(val);

      wordToInsert.forEach(function (word, index) {
        var intersect = wordIntersections(word, Inserted);
        if (intersect !== null) {
          possibleIntersections.push(intersect);
        }
      });
      possibleIntersections.forEach(function (intersect) {
        if (intersect.length === 0) {
          zeroes++;
        }
      });
      possibleIntersectionsArr.push({
        intersections: possibleIntersections,
        nextStateZeroes: zeroes,
        intersect: val,
      });
      Inserted.pop();
    });
  });
  var firstOfSize = firstofSize(possibleIntersectionsArr, size);
  return firstOfSize;
}

function shuffle(a) {
  var j, x, i;
  for (i = a.length; i; i--) {
    j = Math.floor(Math.random() * i);
    x = a[i - 1];
    a[i - 1] = a[j];
    a[j] = x;
  }
}

/* function initializeBoards(Inserted, wordToInsert, word, size)
 
   Description: Initializes n boards after evaluating possible intersections with the longest word
 
   input:       inserted      - an array of type wordInGrid (custom object) containing longest word in grid
                wordToInsert  - an array of type string containing words to be inserted in grid
                word          - a string representing longestWord in grid
                size          - number of boards to be initialized
 
   output:      boardArray   - an array containing a grid, words inserted and words to be inserted.
*/
function initializeBoards(Inserted, wordToInsert, longestWord, n) {
  var start = Math.floor((sizeOfBoard - (longestWord.length - 1)) / 2);
  var middleCol = Math.floor(sizeOfBoard / 2);
  Inserted.push(
    new wordInGrid(
      longestWord,
      "down",
      start,
      start + (longestWord.length - 1),
      middleCol
    )
  );
  var intersections = new Array();
  wordToInsert.forEach(function (word, index) {
    var intersection = wordIntersections(word, Inserted);
    if (intersection !== null) {
      intersections.push(intersection);
    }
  });
  var bestIntersections = findBestIntersections(
    intersections,
    Inserted,
    wordToInsert,
    n
  );
  var boardArray = new Array();
  var insert, wInsert, grid;
  for (var i = 0; i < bestIntersections.length; i++) {
    grid = initializeBoard(longestWord);
    insert = Inserted.slice();
    wInsert = wordToInsert.slice();
    removeString(wInsert, bestIntersections[i].word);
    insertIngrid(grid, bestIntersections[i], insert, wInsert);
    boardArray.push({ grid: grid, inserted: insert, wordToInsert: wInsert });
  }

  return boardArray;
}
/*
  function insertWords(grid, Inserted, wordToInsert)
  Description: given an array of words to insert and an array of words inserted, inserts words
               into grid after finding best intersection
  input:       grid     - the grid in which characters need to be inserted
               Inserted - an array of type wordInGrid containing all words inserted on grid
               wordToInsert - an array of type string containing words to be inserted
*/
function insertWords(grid, Inserted, wordToInsert) {
  try {
    if (wordToInsert.length === 0) {
      return;
    } else {
      var intersections = new Array();
      wordToInsert.forEach(function (word, index) {
        var intersection = wordIntersections(word, Inserted);
        if (intersection !== null) {
          intersections.push(intersection);
        } else {
        }
      });
      var bestIntersection = findBestIntersection(
        intersections,
        Inserted,
        wordToInsert
      );

      if (bestIntersection !== undefined) {
        insertIngrid(grid, bestIntersection, Inserted, wordToInsert);
        insertWords(grid, Inserted, wordToInsert);
      }
    }
  } catch (error) {
    console.log(error);
  }
}

/* Description: Given an array of words returns the word with longest length
  input: words - array of words
  output: max  - longest string
*/
function longestWord(words) {
  var max = words[0];
  var maxIndex = 0;
  words.forEach(function (val, index) {
    if (val.length > max.length) {
      max = val;
      maxIndex = index;
    }
  });
  words.splice(maxIndex, 1);
  return max;
}

/*
Is there any label collision?
*/

function getRC(element) {
  if (element.dir == "across") {
    return [element.pos, element.start - 1];
  } else {
    return [element.start - 1, element.pos];
  }
}

function isLabelCollision(gridArr) {
  var compArr = [];
  var compArr2 = [];
  for (var ii = 0; ii < gridArr.inserted.length; ii++) {
    compArr = getRC(gridArr.inserted[ii]);
    for (var kk = ii + 1; kk < gridArr.inserted.length; kk++) {
      compArr2 = getRC(gridArr.inserted[kk]);
      if (compArr[0] == compArr2[0] && compArr[1] == compArr2[1]) {
        return true;
      }
    }
  }
  return false;
}

/*
  function findBestGrid(gridArr)
  Description: given an object containing a grid, and words to be be inserted in
               the grid, returns the grid with least number of words left to insert.
  input:       gridArr - an array of objects containing a 2-dimensional grid, words inserted,
                         and words to be inserted
  output:      bbestGrid - object with the least size of wordToInsert
*/
function findBestGrid(gridArr) {
  /// isLabelCollision(gridArr[0]);
  var bestGrid = gridArr[0];
  for (var i = 0; i < gridArr.length; i++) {
    if (gridArr[i].wordToInsert.length === 0) {
      return gridArr[i];
    } else if (
      gridArr[i].wordToInsert.length < bestGrid.wordToInsert.length &&
      !isLabelCollision(gridArr[i])
    ) {
      bestGrid = gridArr[i];
    }
  }
  return bestGrid;
}

/*
  function shiftLeft(grid, words)
  Description: shifts the grid to the left and removes empty boxes to the left of the crossword.
  input:       grid  - an object containing 2-dimensional array representing the crossword,
                      inserted words, and words left to insert
               words - word left to be inserted in grid
  output:      an object containing 2-dimensional array representing the shifted crossword,
               inserted words, and words left to insert
*/
function shiftLeft(grid, words) {
  var min = 999999;
  var board;
  for (var i = 0; i < grid.inserted.length; i++) {
    if (grid.inserted[i].dir === "down") {
      if (grid.inserted[i].pos < min) {
        min = grid.inserted[i].pos;
      }
    } else {
      if (grid.inserted[i].start < min) {
        min = grid.inserted[i].start;
      }
    }
  }
  var newGrid = create_grid(sizeOfBoard);
  var wordToInsert = words.slice();
  var Inserted = [];
  for (var i = 0; i < grid.inserted.length; i++) {
    if (grid.inserted[i].dir === "down") {
      grid.inserted[i].pos -= min;
    } else {
      grid.inserted[i].start -= min;
      grid.inserted[i].end -= min;
    }
    insertIngrid(newGrid, grid.inserted[i], Inserted, wordToInsert);
  }
  return { grid: newGrid, inserted: Inserted, wordToInsert: wordToInsert };
}

/*
  function insertImages(grid, inserted, words)
  Description: inserts images' name in the grid at te start of each word
  input:       grid     - a crossword 2-dimensional grid
               inserted - of type wordInGrid containing words inserted in grid
*/
function insertImages(grid, inserted) {
  inserted.forEach(function (word, index) {
    if (word.start !== 0) {
      if (word.dir === "across") {
        grid[word.pos][word.start - 1] = word.word;
      } else {
        grid[word.start - 1][word.pos] = word.word;
      }
    }
  });
}

/*
  function shrinkGrid(grid)
 
  Description:  takes a 2-dimensional grid and finds the start and end columns and
                rows and shrink the grid to have no extra columns and rows.
  input:        grid - 2-dimensional grid with all the value inserted
*/

function shrinkGrid(grid, isImageGrid) {
  var startRow, endRow, startCol, endCol;
  startRow = 999999;
  startCol = 999999;
  endRow = 0;
  endCol = 0;
  grid.inserted.forEach(function (insert, i) {
    if (insert.dir === "across") {
      if (insert.start < startCol) {
        startCol = insert.start;
      }
      if (insert.end > endCol) {
        endCol = insert.end;
      }
      if (insert.pos < startRow) {
        startPos = insert.pos;
      }
      if (insert.pos > endRow) {
        endRow = insert.pos;
      }
    } else {
      if (insert.pos < startCol) {
        startCol = insert.pos;
      }
      if (insert.pos > endCol) {
        endCol = insert.pos;
      }
      if (insert.start < startRow) {
        startRow = insert.start;
      }
      if (insert.end > endRow) {
        endRow = insert.end;
      }
    }
  });
  var cols = endCol - startCol + 1;
  var rows = endRow - startRow + 1;
  var shrinkedGrid = new Array(rows);
  for (var i = 0; i < rows; i++) {
    for (var j = 0; j < cols + 1; j++) {
      shrinkedGrid[i] = new Array(j);
    }
  }
  for (var i = 0; i < rows; i++) {
    for (var j = 0; j < cols; j++) {
      shrinkedGrid[i][j] = grid.grid[i + startRow][j + startCol];
    }
  }
  grid.inserted.forEach(function (insert, index) {
    if (insert.dir === "across") {
      insert.pos -= startRow;
      insert.start -= startCol;
      insert.end -= startCol;
    } else {
      insert.pos -= startCol;
      insert.start -= startRow;
      insert.end -= startRow;
    }
  });
  rows = shrinkedGrid.length;
  cols = shrinkedGrid[0].length;
  if (rows > cols) {
    sizeOfBoard = rows;
    for (var i = 0; i < rows; i++) {
      for (var j = 0; j < rows - cols; j++) {
        shrinkedGrid[i].push("");
      }
    }
  } else if (cols > rows) {
    sizeOfBoard = cols;
    for (var j = 0; j < cols - rows; j++) {
      var arr = [];
      for (var k = 0; k < cols; k++) {
        arr.push("");
      }
      shrinkedGrid.push(arr);
    }
  } else {
    sizeOfBoard = rows;
  }
  return shrinkedGrid;
}
/*
  function clearScreen()
  Description: clears contents on screen so when orientation changes everything is printed again
*/
function clearScreen() {}

/*
  function keyBoardChars(words)
  Description: returns an array of non-repeating letters found in the words in the crossword.
  input:       words - an array of strings
*/
function keyBoardChars(words) {
  var keyBoardArr = [];
  words.forEach(function (word, index) {
    for (var i = 0; i < word.length; i++) {
      if (charInserted(keyBoardArr, word.charAt(i)) === false) {
        keyBoardArr.push(word.charAt(i));
      }
    }
  });

  keyboardArray = [
    "q",
    "w",
    "e",
    "r",
    "t",
    "y",
    "u",
    "i",
    "o",
    "p",
    "a",
    "s",
    "d",
    "f",
    "g",
    "h",
    "j",
    "k",
    "l",
    "z",
    "x",
    "c",
    "v",
    "b",
    "n",
    "m",
  ];
  return keyBoardArr;
}

/*
  function charInserted(keyBoardArr, char)
  Description: helper function for keyBoardChars. Checks if a char has already been inserted
               in array
 
  input:       keyBoardArr - an array of chars, containing letters to be in keyBoard
                             on screen
               char        - the char that needs to be checked if it is present in
                             keyBoardArr
*/
function charInserted(keyBoardArr, char) {
  for (var i = 0; i < keyBoardArr.length; i++) {
    if (keyBoardArr[i] === char) {
      return true;
      break;
    }
  }
  return false;
}

/*
  function resizeGrid(grid, inserted)
  Description: adds two extra row and column to the grid for cases when a word starts or ends at grid
               boundary
  input:       grid     - grid representing crossword
               inserted - words inserted in grid
  output:      newGrid  - resized grid with two more columns and rows
*/
function resizeGrid(grid, inserted) {
  var size = sizeOfBoard + 1;
  var newGrid = create_grid(size);
  for (var i = 0; i < size - 1; i++) {
    for (var j = 0; j < size - 1; j++) {
      newGrid[i + 1][j + 1] = grid[i][j];
    }
  }
  inserted.forEach(function (value, index) {
    value.pos += 1;
    value.start += 1;
    value.end += 1;
    inserted[index] = {
      word: value.word,
      dir: value.dir,
      start: value.start,
      end: value.end,
      pos: value.pos,
    };
  });
  sizeOfBoard += 1;
  return { grid: newGrid, inserted: inserted };
}
