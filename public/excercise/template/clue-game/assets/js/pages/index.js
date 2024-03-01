var gameService;
var isSoundPlaying = true;
var switchScrVar = 0;

var index_page = {

  oldPage: "",
  isPageLoading: true,
  pageAnimationTimer: null,
  init: function (valuePassed) {
    if (typeof getParams().is_offline_lms != "undefined") {
      window.parent.postMessage(
        JSON.stringify({
          message: "offline-game-ready",
        }),
        "*"
      );
    }
    // window.addEventListener("message", onMessage, false);
    // function onMessage(event) {
    //   try {
    //     this.eventData = JSON.parse(event?.data);
    //   } catch {
    //     return;
    //   }
    //   if (this.eventData.message === "offline-game-data") {
    //     const data = this.eventData.data.json_data;
    //     // 1 means its coming from CMS data and 0 mean kp data
    //     if (this.eventData.data.is_content_type === 1) {
    //       const _data = JSON.parse(data);
    //       Resumeables.dbFromServer = _data.dataBank;
    //       // dataBank=
    //     } else {
    //       const _data = JSON.parse(data);
    //       Resumeables.dbFromServer = _data;
    //     }
    //   }
    //   removeMessageEvent();
    // }
    // function removeMessageEvent() {
    //   window.removeEventListener("message", onMessage);
    // }

    gameService = new GameService(
      "ClueOnGame",
      manifest,
      this.onLoadingComplete,
      {
        allPages: index_page.getAllPages(),
      }
    );
  },
  // initialize data etc.
  onLoadingComplete: function () {
    /* API integration */
    UBJ_API.Init(gameService.appID, function (data) {
      // FOr Asim / direct level playing
      // gameService.initParams.grade = 3;
      // gameService.initParams.level = 1;
      // FOr Asim / direct level playing
      if (UBJ_API.fromCMS == "1") {
        gameService.dbDel("entireDataBank");
        dataBank = Resumeables.dbFromServer;
      }
      if (UBJ_API?.initParams?.is_offline_lms == "1") {
        dataBank = Resumeables.dbFromServer;
      }
      // console.log('Resumeables.dbFromServer', Resumeables.dbFromServer);
      // console.log('gameService', gameService);
      console.log("Resumeables.dbFromServer", UBJ_API.TrackingEnabled);
      if (UBJ_API.TrackingEnabled) {
        if (!(typeof gameService.initParams.grade !== "undefined")) {
          if (
            typeof Resumeables !== "undefined" &&
            typeof Resumeables.dbFromServer !== "undefined" &&
            typeof Resumeables.dbFromServer.Name !== "undefined" &&
            Resumeables.dbFromServer.Name.length > 0
          )
            gameService.initParams.grade = Resumeables.dbFromServer.Name.trim();
          else gameService.initParams.grade = dataBank[0].Grade.trim();
        }
        if (!(typeof gameService.initParams.level !== "undefined"))
          gameService.initParams.level = 1;
      }
      if (gameService.initParams.grade != null) {
        ulockAllTopics = true;
        gameService.appendToAppID("grade_" + gameService.initParams.grade);
      }

      if (
        typeof Resumeables !== "undefined" &&
        typeof Resumeables.dbFromServer !== "undefined" &&
        UBJ_API.TrackingEnabled
      ) {
        console.log("Resumeables.dbFromServer", Resumeables.dbFromServer);
        resetDatabase();
        if (Resumeables.dbFromServer.length == 0) {
          dbFromServer = [];
          //alert("RESETTING DATABASE");
        } else {
          dbFromServer = JSON.parse(JSON.stringify(Resumeables.dbFromServer));
          //   alert("dbFromServer Pre Load: " + dbFromServer.TopicStatus);

          //   alert("dbFromServer On Load: " + dbFromServer[0].Topics[1].Lives);
          if (loadJSONFromServer() == false) {
            console.log("Reset Due To Invalid LoadJSONFromServer Return");
            resetDatabase();
          }
          // alert("dbFromServer On Load: " + dbFromServer.TopicStatus);
          // alert("dbBank After LoadingServer: " + dbBank[0].Topics[2].Lives);
          //  alert("dbBank After LoadingServer: " + dbBank[0].Score);
          // alert("NOT RESETTING DATABASE");
          // if(dbFromServer.length) {
          //     alert("Server length is less than 1: " + dbFromServer.length);
          //     localStorage.clear();
          //     resetDatabase();
          // } else {

          //     alert("Server length is more or eq to 1:" + dbFromServer.length);
          // }
        }
      } else {
        // alert("NO DATA FROM SERVER");
        Resumeables.dbFromServer = [];
        if (UBJ_API.TrackingEnabled) {
          // alert("TRACKING ENABLED");
          console.log("Resetting at index due to enabled tracking");
          localStorage.clear();
          resetDatabase();
        } else {
          if (checkLocalTags() == false) {
            console.log("Resetting at index due to checkLocalTags == false");
            //    alert("checkLocalTags came False, db is" + dbBank);
            resetDatabase();
          } else {
            console.log("Loading local DB");
            dbBank = JSON.parse(gameService.dbGet("entireDataBank", false));

            if (dbBank == false) return;
          }
          // if (gameService.dbGet('entireDataBank') == null) {
          //   //  alert("NO LOCAL DATA FOUND - RESETTING DB");
          //     resetDatabase();
          // }
          // if (gameService.dbGet('entireDataBank', false)) {

          //     // alert("DB OVERWRITTEN FROM LOCAL SOURCE");
          //     loadJSONLocal();
          //     Resumeables.dbFromServer = [];//gameService.dbGet('entireDataBank', JSON.stringify(dbBank));

          //     if (dbBank.length <= 0)
          //     return;
          // } else {

          //   //  alert("FRESH COPY");
          //     localStorage.clear();
          //     resetDatabase();
          //     Resumeables.dbFromServer = []//dbBank;
          // }
          // loadJSONLocal();
          // else
        }
      }

      console.log("loading complete");
      $("#page_place_holder").show();

      //gameService.dbSet("IsSoundOn", "YES");

      if (
        window.history.replaceState &&
        window.location.origin != "file://" &&
        AppSet.isDev
      ) {
        AppSet.DynamicURLEnabled = true;
      }
      console.log("Param type: " + gameService.initParams.type);

      if (gameService.initParams.type != gameService.AppTypes.Store) {
        ulockAllTopics = true;
      } else {
        ulockAllTopics = false;
      }

      // if (gameService.dbGet('entireDataBank') == null) {
      //     resetDatabase();
      //     // gameService.dbSet('entireDataBank', JSON.stringify(dbBank));
      // } else {
      //     dbBank = JSON.parse(gameService.dbGet('entireDataBank'));
      //     if (dbBank.length <= 0)
      //         return;
      // }

      var fflagselG = false;

      // if(gameService.initParams.grade == "" && gameService.initParams.grade != undefined)
      // { //dbBank.length==1 ||
      //     selectedGrade = 0;
      //     index_page.showPage(AppSet.pages.Topic);
      //     return;
      // }

      if (
        typeof gameService.initParams.grade != "undefined" &&
        gameService.initParams.grade
      ) {
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
          if (fflagselG == false) selectedGrade = 0;
        }
      }
      var inteGdbs = false;

      if (typeof gameService.initParams.level != "undefined") {
        if (selectedGrade == undefined) selectedGrade = 0;
        if (
          parseInt(gameService.initParams.level) > 0 &&
          dbBank[selectedGrade].Topics[gameService.initParams.level - 1]
        ) {
          selectedTopic = parseInt(gameService.initParams.level) - 1;
        } else {
          selectedTopic = 0;
        }

        if (
          Resumeables.dbFromServer &&
          UBJ_API.TrackingEnabled &&
          Resumeables.dbFromServer.length > 0
        ) {
          console.log("callIntegrationOfServerDB Call1");
          callIntegrationOfServerDB();
        }
        index_page.showPage(AppSet.pages.CoreGame);
      } else {
        if (
          Resumeables.dbFromServer &&
          UBJ_API.TrackingEnabled &&
          Resumeables.dbFromServer.length > 0
        ) {
          console.log("callIntegrationOfServerDB Call2");
          callIntegrationOfServerDB();
        }

        if (typeof gameService.initParams.grade == "undefined")
          index_page.showPage(AppSet.pages.Entry);
        else index_page.showPage(AppSet.pages.Topic);
      }

      if (dbBank.length == 1) {
        selectedGrade = 0;

        gameService.dbSet(
          "KP18-CLUEON-GAME_userSeletedClass",
          dbBank[0].Name.trim()
        );
        $("#levelSelectedText").text(dbBank[0].Name.trim());

        if (dbBank[0].Topics.length == 1) {
          selectedTopic = 0;
          index_page.showPage(AppSet.pages.CoreGame);
        } else {
          index_page.showPage(AppSet.pages.Topic);
        }
      }

      // if(switchScrVar==1)
      // {

      // } else if(switchScrVar==2)
      // {

      // } else if(switchScrVar==3)
      // {

      // }
      // if (typeof gameService.initParams.level != "undefined") {

      //     var strC = gameService.initParams.grade;
      //     if ((typeof strC == undefined))
      //         strC = 0;
      //     var strT = parseInt(gameService.initParams.level) - 1;
      //     console.log("strC" + strC);
      //     console.log("strT" + strT);
      //     if (strC != 0) {
      //         for (var vx = 0; vx < dbBank.length; vx++) {
      //             if (parseInt(strC.trim()) == parseInt(dbBank[vx].Name.trim())) {

      //                 selectedGrade = vx;
      //                 break;
      //             }
      //         }
      //     } else {

      //         selectedGrade = 0;
      //     }

      //     if (str >= 0)
      //         selectedTopic = strT;
      //     else
      //         selectedTopic = 0;

      //     index_page.showPage(AppSet.pages.CoreGame);
      // } else if (gameService.initParams.type == gameService.AppTypes.Classroom) {
      //     var strC = gameService.initParams.grade;
      //     selectedGrade = 0;
      //     for (var vx = 0; vx < dbBank.length; vx++) {
      //         if (parseInt(strC.trim()) == parseInt(dbBank[vx].Name.trim())) {

      //             selectedGrade = vx;
      //             break;
      //         }
      //     }
      //     index_page.showPage(AppSet.pages.Topic);
      // } else if (gameService.initParams.grade != null && gameService.initParams.level == null) {
      //     console.log("Grade Passed Through Parameter:" + gameService.initParams.grade);
      //     var strC = gameService.initParams.grade;
      //     selectedGrade = 0;
      //     for (var vx = 0; vx < dbBank.length; vx++) {
      //         if (parseInt(strC.trim()) == parseInt(dbBank[vx].Name.trim())) {

      //             selectedGrade = vx;
      //             break;
      //         }
      //     }

      //     if (dbBank[selectedGrade].length == 1) {
      //         selectedTopic = 0;
      //         index_page.showPage(AppSet.pages.CoreGame);
      //     } else {
      //         index_page.showPage(AppSet.pages.Topic);
      //     }

      // } else {
      //     index_page.showPage(AppSet.pages.Entry);
      // }

      isGamePlayOn = false;

      console.log(
        "Init Sound: " +
          (gameService.dbGet("IsSoundOn", "NOSOUNDINFO") == "NOSOUNDINFO")
      );
      if (gameService.dbGet("IsSoundOn", "NOSOUNDINFO") == "NOSOUNDINFO") {
        gameService.dbSet("IsSoundOn", "YES");
        // if(!gameService.isSoundPlaying("bg_sound"))
        // gameService.playSound("bg_sound", true);
      }
    });
  },
  getAllPages: function () {
    var allPages = [];
    for (var key in AppSet.pages) {
      allPages.push(AppSet.pages[key]);
    }
    var t;
    for (var key in AppSet.templates) {
      t = "assessment_templates/" + AppSet.templates[key].pageName;
      if (allPages.indexOf(t) == -1) allPages.push(t);
    }
    //console.log("AlLPages: ", allPages);
    return allPages;
  },
  showPage: function (pageName, initParams) {
    console.log("showPage: ", pageName);

    // if (pageName !== AppSet.pages.Assessment) {
    //     gameService.playSound("bg_sound", true, 1);
    // } else {
    //     gameService.stopSound("bg_sound");
    // }

    var _this = this;
    //gameService.previousPageViewed = _this.oldPage;

    Loader.show();
    if (_this.oldPage !== pageName) {
      gameService.loadPage(pageName, function (tempDiv) {
        $("#page_place_holder").append(tempDiv);
        $("#" + pageName).addClass("show-page");

        if (_this.oldPage != "" && _this.oldPage != pageName)
          $("#" + _this.oldPage).remove();
        _this.setNewPage(pageName, initParams);
        _this.oldPage = pageName;
        clearTimeout(_this.pageAnimationTimer);
        _this.pageAnimationTimer = setTimeout(function () {
          $("#" + pageName).removeClass(
            "show-page page-hide-right page-hide-left"
          );
          if (pageName != "assessment_page") Loader.hide();
          _this.isPageLoading = false;
        }, 350);

        tempDiv = null;
      });
    } else {
      _this.setNewPage(pageName, initParams);
      _this.isPageLoading = false;
    }
  },
  launchGame: function () {
    index_page.showPage(AppSet.pages.Assessment, {});
  },

  setNewPage: function (pageName, initParams) {
    switch (pageName) {
      case AppSet.pages.Entry:
        entry_page.init(initParams);
        updateSound(pageName);
        break;
      case AppSet.pages.Topic:
        topic_page.init(initParams);
        updateSound(pageName);
        break;
      case AppSet.pages.CoreGame:
        game_page.init(initParams);
        updateSound(pageName);
        break;
    }
  },

  setBackground: function (e, c, t) {
    var color = [
      "a1ddf7",
      "efc08e",
      "ffeea4",
      "b286f2",
      "88edba",
      "86efd1",
      "eda2d9",
      "7fe5a1",
      "bcef95",
      "9292ef",
      "ffb1a9",
    ];
    var texture = ["texture_1", "texture_2", "texture_3"];
    e.removeClass("texture_1 texture_2 texture_3");
    if (t === -1)
      t = Math.floor(0 + Math.random() * (texture.length - 1 + 1 - 0));
    e.addClass(texture[t]);
    if (typeof c !== "undefined") {
      if (c === -1)
        c = Math.floor(0 + Math.random() * (color.length - 1 + 1 - 0));
      e.css("background-color", "#" + color[c]);
    }
  },

  changeHistoryState: function (params) {
    if (!AppSet.DynamicURLEnabled) return;
    var pairs = [];
    for (var prop in params) {
      if (params.hasOwnProperty(prop)) {
        var k = encodeURIComponent(prop),
          v = encodeURIComponent(params[prop]);
        if (v != "") pairs.push(k + "=" + v);
      }
    }
    var newUrl = window.location.origin + window.location.pathname;
    if (pairs.length != 0) newUrl += "?" + pairs.join("&");

    window.history.replaceState(null, "ClueOn by Knowledge Platform", newUrl);
  },
};
