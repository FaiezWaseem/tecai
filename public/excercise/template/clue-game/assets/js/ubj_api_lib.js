/* eslint-disable no-undef */
/* eslint-disable block-scoped-var */
/* eslint-disable no-unused-expressions */
/* eslint-disable no-shadow */
/* eslint-disable radix */
/* eslint-disable guard-for-in */
/* eslint-disable prefer-destructuring */
/* eslint-disable no-param-reassign */
/* eslint-disable vars-on-top */
/* eslint-disable no-redeclare */
/* eslint-disable no-prototype-builtins */
/* eslint-disable no-unused-vars */
/* eslint-disable eqeqeq */
/* eslint-disable no-multi-assign */
/* eslint-disable func-names */
/* eslint-disable no-underscore-dangle */
/* eslint-disable no-restricted-syntax */
/* eslint-disable consistent-return */
/* eslint-disable camelcase */
/* eslint-disable no-var */
let Resumeables = {
  timeSpentMilliSeconds: 0,
  curQ: -1,
  allQ: [],
  CurrentScore: 0,
};

var APP_TYPES = {
  Store: "",
  Classroom: "classroom",
  DirectLevel: "directLevel",
  Classroom_DirectLevel: "classroomdirectlevel",
};

var UBJ_API = {
  appID: "",
  version: "2.0.0",
  timeSpentMilliSeconds: 0,
  initParams: {},
  COMPLETION_STATUS: {
    NONE: 0,
    NOT_ATTEMPTED: 1,
    INCOMPLETE: 2,
    COMPLETED: 3,
  },
  /* data from URL params */
  /* SetParams updates these properties */
  ApplicationURL: "",
  finalApiCall: false,
  moduleid: 0,
  userid: 0,
  ispreview: 1,
  ispublic: 1,
  fromCMS: "0",
  cmsInternalLaunch: "0",
  /* Tracking enabled or not boolean */
  TrackingEnabled: false,

  /* GetGameScore update these properties */
  /* Game logic update these properties as well but do not use them outside of this lib */
  /* API Params */
  Score: 0,
  CompletionPercentage: 0,
  CompletionStatus: 0,
  TimeSpentSeconds: 0,

  /* For offline app support */
  isOffline: false,
  requestTimeout: 6100,
  curReq: [],
  loaderStr:
    '<div id="apiLoader" class="_loader" style="display: none;"><div class="_dot _bounce1"></div> <div class="_dot _bounce2"></div> <div class="_dot _bounce3"></div></div><div id="apiRetryPopup" class="_retryPopup" style="display:none;"><img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNi4wLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkNhcGFfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHdpZHRoPSI1NnB4IiBoZWlnaHQ9IjU2cHgiIHZpZXdCb3g9IjAgMCA1NiA1NiIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgNTYgNTYiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPGc+DQoJPHBhdGggZmlsbD0iIzRGNjE2QiIgZD0iTTMzLjg4Miw0Ni4zMjRjMCwzLjIxNy0yLjYwNiw1LjgyMy01LjgyMyw1LjgyM2MtMy4yMTcsMC01LjgyMi0yLjYwNi01LjgyMi01LjgyM3MyLjYwNS01LjgyMiw1LjgyMi01LjgyMg0KCQlDMzEuMjc1LDQwLjUwMiwzMy44ODIsNDMuMTA3LDMzLjg4Miw0Ni4zMjR6IE0zNy4yMDUsMjUuODc3Yy0xLjgzNC0wLjc3My0zLjczNC0xLjMwOS01LjY4Ni0xLjU5Nmw5Ljg5Myw5Ljg4N2wzLjI2MS0zLjI2DQoJCUM0Mi41MTYsMjguNzUxLDQwLjAwNCwyNy4wNTYsMzcuMjA1LDI1Ljg3N3ogTTE4LjA3MiwyNi4yNDVjLTIuNTg3LDEuMjE2LTQuOTEzLDIuODc0LTYuOTA3LDQuOTQzbDcuMTY5LDYuOTMzDQoJCWMyLjA4Mi0yLjE1Nyw0Ljc0NC0zLjUyMiw3LjY0My0zLjk3MUwxOC4wNzIsMjYuMjQ1eiBNNi4yMDksMTQuMzc1QzMuOTgzLDE1Ljg0NywxLjkwOCwxNy41MzYsMCwxOS40NWw3LjA1MSw3LjA1DQoJCWMxLjkyLTEuOTIsNC4wNzEtMy41NTMsNi40MDgtNC44NjlMNi4yMDksMTQuMzc1eiBNNDMuNDI2LDEwLjkxYy00Ljg2OS0yLjA0NS0xMC4wNDMtMy4wODYtMTUuMzY3LTMuMDg2DQoJCWMtMy44ODQsMC03LjY4LDAuNTU1LTExLjMzOSwxLjY0Nmw4LjQ2NSw4LjQ2NmMwLjk0OC0wLjA5MywxLjkwOC0wLjEzNywyLjg3NC0wLjEzN2M3Ljg4NiwwLDE1LjMxLDMuMDU1LDIwLjkxNiw4LjYwM0w1NiwxOS4zMTkNCgkJQzUyLjM1OSwxNS43MTYsNDguMTMzLDEyLjg4Niw0My40MjYsMTAuOTF6IE0zLjM5MSw3LjkxMUw0Mi4zNTksNDYuODhsNC4wNTktNC4wNTlMNy40NSwzLjg1M0wzLjM5MSw3LjkxMXoiLz4NCjwvZz4NCjwvc3ZnPg0K" class="_retryIcon" /><div class="_loaderText">Slow or no internet connection.<br>Check your internet connection or try again.</div><div id="retryRequestButton" class="_loaderButton">Retry</div></div>',
  loaderStyle:
    '._retryIcon { width: 60px; margin: auto; } ._loaderButton { cursor: pointer; padding: 15px 20px; border-radius: 6px; background-color: #117BFA; color: #FFF; font-size: 16px; width: 150px; -webkit-box-shadow: 2px 2px 5px rgba(0,0,0,0.3); box-shadow: 2px 2px 5px rgba(0,0,0,0.3); margin: auto; -moz-transition: all 0.3s ease; -o-transition: all 0.3s ease; -webkit-transition: all 0.3s ease; transition: all 0.3s ease; } ._loaderButton:hover { -webkit-box-shadow: 1px 1px 3px rgba(0,0,0,0.3); box-shadow: 1px 1px 3px rgba(0,0,0,0.3); } ._retryPopup { display: -webkit-flex; display: flex; -webkit-flex-direction: column; flex-direction: column; width: 80%; max-width: 390px; padding: 20px 15px; background: #FFF; border-radius: 10px; -webkit-box-shadow: 0px 0px 10px rgba(0,0,0,1); box-shadow: 0px 0px 10px rgba(0,0,0,1); } ._loaderText { color: #333; font-size: 18px; margin: auto; margin-top: 15px; margin-bottom: 30px; font-family: "museo_sans500", sans-serif, Arial, Helvetica; font-weight: 500; } ._loader { font-family: museo_sans700, sans-serif, Arial, Helvetica; display: -webkit-flex; display: flex; } ._apiLoader { background: rgba(0,0,0,0.7); text-align: center; display: -webkit-flex; display: flex; display: none; -webkit-justify-content: center; justify-content: center; align-items: center; width: 100%; height: 100%; position: absolute; left: 0; top: 0; z-index: 9999; } ._apiLoader ._dot { margin: 2px; width: 18px; height: 18px; background-color: #FFF; border-radius: 100%; display: inline-block; -webkit-animation: sk-bouncedelay 1.4s infinite ease-in-out both; animation: sk-bouncedelay 1.4s infinite ease-in-out both; } ._apiLoader ._bounce1 { -webkit-animation-delay: -0.32s; animation-delay: -0.32s; } ._apiLoader ._bounce2 { -webkit-animation-delay: -0.16s; animation-delay: -0.16s; } @-webkit-keyframes sk-bouncedelay { 0%, 80%, 100% { -webkit-transform: scale(0) } 40% { -webkit-transform: scale(1.0) } } @keyframes sk-bouncedelay { 0%, 80%, 100% { -webkit-transform: scale(0); transform: scale(0); } 40% { -webkit-transform: scale(1.0); transform: scale(1.0); } }',

  // updates properties according to URL params
  // Use this function atleast one time before GET/SET methods
  // Sets onunload event to refresh parent
  Init(appID, callBackFunction) {
    this.appID = `${appID}offline.`;
    // this.onReqFailure.bind(this);
    // this.onReqSuccess.bind(this);
    this.initLoader();
    this.SetParams();

    window.onunload = this.onbeforeunloadFunc;
    console.log("this.fromCMS", this.fromCMS, this.cmsInternalLaunch);
    if (this.initParams.is_offline_lms) {
      // Resumeables.dbFromServer = questionsJSON;
      // console.log(Resumeables);
      //  questionsJSON = UBJ_API.GetCmsQuestionData(_data.data[0]);
      UBJ_API.GetGameScore(callBackFunction);
      // UBJ_API.onReqSuccess();
    }
    {
      if (this.fromCMS === "1") {
        IsCMSPlatform = true;
        this.CmsLoginCredentials(callBackFunction, this.cmsInternalLaunch);
      } else if (typeof callBackFunction === "function")
        this.GetGameScore(callBackFunction);
      else this.GetGameScore(null);
    }
  },

  dbSet(key, value) {
    if (typeof value === "object") value = JSON.stringify(value);
    localStorage[this.appID + key] = value;
  },
  dbGet(key, defaultValue) {
    if (typeof localStorage[this.appID + key] === "undefined")
      return defaultValue;
    return localStorage[this.appID + key];
  },
  dbDel(key) {
    localStorage.removeItem(this.appID + key);
  },

  // Retrive params from URL
  getParams() {
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
  },

  initLoader() {
    const css = this.loaderStyle;
    const head = document.head || document.getElementsByTagName("head")[0];
    const style = document.createElement("style");

    style.type = "text/css";
    if (style.styleSheet) {
      // This is required for IE8 and below.
      style.styleSheet.cssText = css;
    } else {
      style.appendChild(document.createTextNode(css));
    }

    head.appendChild(style);
    let loader = document.createElement("div");
    loader.innerHTML = this.loaderStr;
    loader.id = "apiLoaderContainer";
    loader = this.addClass([loader], "_apiLoader")[0];
    loader
      .querySelector("#retryRequestButton")
      .addEventListener("click", this.onRetry.bind(this));
    document.body.appendChild(loader);
  },

  addClass(s, c) {
    if (typeof s === "undefined" || s == null) return;
    let e = s;
    if (typeof s === "string") e = this.getEl(s);
    for (let i = 0; i < e.length; i++) {
      if (e[i].classList) e[i].classList.add(c);
      else if (!this.hasClass(e[i], c)) e[i].c += ` ${c}`;
    }
    return e;
  },

  hasClass(el, className) {
    return el.classList
      ? el.classList.contains(className)
      : new RegExp(`\\b${className}\\b`).test(el.className);
  },

  removeClass(s, c) {
    if (typeof s === "undefined" || s == null) return;
    let e = s;
    if (typeof s === "string") e = this.getEl(s);
    for (let i = 0; i < e.length; i++) {
      if (e[i].classList) e[i].classList.remove(c);
      else
        e[i].className = e[i].className.replace(
          new RegExp(`\\b${c}\\b`, "g"),
          ""
        );
    }
    return e;
  },

  getEl(s) {
    if (typeof s === "undefined" || s == null) return;
    if (window === s) return s;
    return document.querySelectorAll(s);
  },

  css(s, styles) {
    if (typeof s === "undefined" || s == null) return;
    let e = s;
    if (typeof s === "string") e = this.getEl(s);

    for (let i = 0; i < e.length; i++) {
      for (const p in styles) {
        e[i].style[p] = styles[p];
      }
    }
    return s;
  },

  // * Retrieve params from URL
  // * sets initParams of this
  parseURL: function (str) {
    var query_string = {};
    var query =
      typeof str === "string" ? str : window.location.search.substring(1);

    const params = new URL(window.location.href).searchParams;
    const sessionid = params.get("sessionid");
    const callback_data = params.get("callback_data");

    query = query.toLocaleLowerCase();

    if (query.length === 0) {
      query_string.type = APP_TYPES.Store;
      this.initParams = query_string;
    }

    var vars = query.split("&");
    for (var i = 0; i < vars.length; i++) {
      var pair = vars[i].split("=");
      // If first entry with this name
      if (typeof query_string[pair[0]] === "undefined") {
        query_string[pair[0]] = decodeURIComponent(pair[1]);
        // If second entry with this name
      } else if (typeof query_string[pair[0]] === "string") {
        var arr = [query_string[pair[0]], decodeURIComponent(pair[1])];
        query_string[pair[0]] = arr;
        // If third or later entry with this name
      } else {
        query_string[pair[0]].push(decodeURIComponent(pair[1]));
      }
    }

    if (!query_string.type) query_string.type = APP_TYPES.Store;

    if (sessionid) {
      // sessionid is exempt from toLocaleLowerCase() function because JWT is passed in sessionid and JWT is case-sensitive
      query_string["sessionid"] = sessionid;
    }

    if (callback_data) {
      // callback_data is exempt from toLocaleLowerCase() function because it is case-sensitive
      query_string["callback_data"] = callback_data;
    }

    this.initParams = query_string;
  },

  SetParams() {
    this.parseURL();
    const initParams = this.getParams();
    this.ApplicationURL = `${window.location.origin}/API/Game/`;

    // const windowOrigin = window.location.origin;
    // console.log ('windowOrigin',windowOrigin);
    // const checkOrigin = windowOrigin.search('localhost') || windowOrigin.search('cmsdev');
    //   console.log("checkOrigin", checkOrigin);
    // this.CmsApplicationURL = checkOrigin !== -1 ? 'https://cmsdev.knowledgeplatform.com' : 'https://cmsapi.knowledgeplatform.com';
    const hostname = window.location.hostname;
    console.log("hostname", hostname);
    if (hostname === "localhost" || hostname.includes("cmsdev")) {
      this.CmsApplicationURL = "https://cmsdev.knowledgeplatform.com";
    } else {
      this.CmsApplicationURL = "https://cmsapi.knowledgeplatform.com";
    }
    this.userid = initParams.userid;
    this.moduleid = initParams.moduleid;
    if (typeof initParams.ispublic !== "undefined")
      this.ispublic = initParams.ispublic;

    if (typeof initParams.ispreview !== "undefined")
      this.ispreview = initParams.ispreview;

    if (typeof initParams.cfCms !== "undefined" && initParams.cfCms === "1")
      this.fromCMS = initParams.cfCms;

    if (typeof initParams.cil !== "undefined" && initParams.cil === "1")
      this.cmsInternalLaunch = initParams.cil;

    if (
      typeof initParams.ins !== "undefined" ||
      typeof initParams.institution_id !== "undefined"
    )
      this.institution_id = initParams.ins || initParams.institution_id;

    if (
      typeof initParams.ct !== "undefined" ||
      typeof initParams.content_id !== "undefined"
    )
      this.content_id = initParams.ct || initParams.content_id;

    if (
      typeof initParams.con !== "undefined" ||
      typeof initParams.container_id !== "undefined"
    )
      this.container_id = initParams.con || initParams.container_id;

    if (typeof initParams.user_id !== "undefined")
      this.user_id = initParams.user_id;

    if (typeof initParams.qn !== "undefined") this.question_id = initParams.qn;

    console.log("this.initParams", this.initParams);

    if (
      this.ispreview != 1 &&
      (this.ispublic != 1 || typeof initParams.ispublic === "undefined")
    ) {
      this.TrackingEnabled = true;
    }

    if (typeof initParams.isOffline !== "undefined")
      this.isOffline = initParams.isOffline == "true";
  },

  // Retrive data from server
  // single callBackFunction is called in both succes or error case
  // Success returns server data
  // failure returns {}
  // Resumeables are set to default in case of any error
  // Normal Use: only once after Setparams in onload function
  GetGameScore(callBackFunction) {
    if (this.TrackingEnabled) {
      Resumeables.timeSpentMilliSeconds = Resumeables.CurrentScore = 0;
      Resumeables.curQ = -1;
      Resumeables.allQ = [];
      if (this.isOffline) {
        this.onGetGameScoreSuccess(
          this.dbGet("gameData", "{}"),
          callBackFunction
        );
      } else {
        this.AjaxReq(
          `${this.ApplicationURL}GetGameScore`,
          "GET",
          { userid: this.userid, moduleid: this.moduleid },
          function (data) {
            UBJ_API.onGetGameScoreSuccess(data, callBackFunction);
          },
          function (error) {
            console.log(error);
            // alert("Please note that the API is not available therefore the game related tracking will not happen.");
            if (typeof callBackFunction === "function") callBackFunction({});
          }
        );
      }
    } else if (typeof callBackFunction === "function") callBackFunction({});
  },

  CmsLoginCredentials(callBackFunction, cmsInternalLaunch) {
    this.AjaxReq(
      `${this.CmsApplicationURL}/api/users/apikey`,
      "POST",
      { institution_id: this.institution_id },
      function (data) {
        const _data = JSON.parse(data);
        console.log("_data", _data.data[0]);
        UBJ_API.onReqSuccess();
        UBJ_API.CmsLogin(_data.data[0], callBackFunction, cmsInternalLaunch);
      },
      function () {
        UBJ_API.onReqFailure();
      }
    );
  },

  CmsLogin(LoginCredentials, callBackFunction, cmsInternalLaunch) {
    // const LoginCredentials = this.CmsGetIncognitoLoginCredentials(this.institution_id);
    const { content_id } = this;
    this.AjaxReq(
      `${this.CmsApplicationURL}/api/login`,
      "POST",
      { username: LoginCredentials.uname, pwd: LoginCredentials.key },
      function (data) {
        const _data = JSON.parse(data);
        const { user_id } = _data?.data;
        UBJ_API.onReqSuccess();
        if (UBJ_API.initParams.islmsplayer == 1) {
          if (content_id !== "undefined") {
            UBJ_API.GetCmsJsonByContentID(user_id, callBackFunction);
          } else {
            UBJ_API.GetCmsJsonByContainerID(user_id, callBackFunction);
          }
        } else if (cmsInternalLaunch === "1") {
          if (content_id) {
            UBJ_API.GetCmsJsonByContentID(user_id, callBackFunction);
          } else {
            UBJ_API.GetCmsJsonByContainerID(user_id, callBackFunction);
          }
        } else {
          UBJ_API.GetCmsJsonByContentID(user_id, callBackFunction);
        }
      },
      function () {
        UBJ_API.onReqFailure();
      }
    );
  },

  GetCmsJsonByContentID(user_id, callBackFunction) {
    this.AjaxReq(
      `${this.CmsApplicationURL}/api/generic/launch`,
      "POST",
      {
        user_id,
        content_id: parseInt(this.content_id),
        institution_id: parseInt(this.institution_id),
      },
      function (data) {
        const _data = JSON.parse(data);
        console.log("_data", _data);
        //  questionsJSON = UBJ_API.GetCmsQuestionData(_data.data.content);

        const x = UBJ_API.GetCmsQuestionData(_data.data.content);
        console.log("x", x);
        const pJsonData = _data.data.content.json_data;

        const Sdata = JSON.parse(pJsonData);

        Resumeables.dbFromServer = Sdata.dataBank;
        UBJ_API.GetGameScore(callBackFunction);
        UBJ_API.onReqSuccess();
      },
      function () {
        UBJ_API.onReqFailure();
      }
    );
  },

  GetCmsJsonByContainerID(user_id, callBackFunction) {
    this.AjaxReq(
      `${this.CmsApplicationURL}/api/editor/generic/open`,
      "POST",
      {
        user_id,
        container_id: this.container_id,
        institution_id: parseInt(this.institution_id),
      },
      function (data) {
        const _data = JSON.parse(data);
        const x = UBJ_API.GetCmsQuestionData(_data.data[0]);
        console.log("x", x);
        const pJsonData = _data.data[0].json_data;

        const Sdata = JSON.parse(pJsonData);
        Resumeables.dbFromServer = Sdata.dataBank;
        //  questionsJSON = UBJ_API.GetCmsQuestionData(_data.data[0]);
        UBJ_API.GetGameScore(callBackFunction);
        UBJ_API.onReqSuccess();
      },
      function () {
        UBJ_API.onReqFailure();
      }
    );
  },

  GetCmsQuestionData: function (data) {
    if (this.question_id) {
      let Temp = data;
      let Qdata = JSON.parse(Temp?.json_data);
      const filteredQuestion = Qdata.questionData.filter((v) => {
        return v.questionId === parseInt(this.question_id);
      });
      const filteredDataBank = Qdata.dataBank.filter((v) => {
        return v.questionId === parseInt(this.question_id);
      });
      filteredDataBank[0].Grade = Qdata.grade;
      filteredDataBank[0].Topic = Qdata.topic;
      Qdata.questionData = [...filteredQuestion];
      Qdata.dataBank = [...filteredDataBank];
      Temp.json_data = JSON.stringify(Qdata);
      FinalQuestionStr = JSON.stringify(Temp);
      return FinalQuestionStr;
    } else {
      FinalQuestionStr = data;
      return FinalQuestionStr;
    }
  },

  onGetGameScoreSuccess(data, callBackFunction) {
    try {
      data = JSON.parse(data);
      if (typeof data === "string") data = JSON.parse(data);
      // set these or in case of any error use default
      if (typeof data.Score !== "undefined" && data.Score != null)
        UBJ_API.Score = data.Score;
      if (
        typeof data.CompletionPercentage !== "undefined" &&
        data.CompletionPercentage != null
      )
        UBJ_API.CompletionPercentage = data.CompletionPercentage;
      if (
        typeof data.CompletionStatus !== "undefined" &&
        data.CompletionStatus != null
      )
        UBJ_API.CompletionStatus = data.CompletionStatus;
      if (
        typeof data.TimeSpentSeconds !== "undefined" &&
        data.TimeSpentSeconds != null
      )
        UBJ_API.TimeSpentSeconds = data.TimeSpentSeconds;
    } catch (e) {
      alert("data parsing issue");
      data = {};
    }
    console.log(data);
    try {
      Resumeables = JSON.parse(data.GameData);
    } catch (e) {
      console.log(e);
    }

    console.log(Resumeables, "Resumeables");

    if (
      typeof Resumeables.timeSpentMilliSeconds === "undefined" ||
      Resumeables.timeSpentMilliSeconds == null
    )
      Resumeables.timeSpentMilliSeconds = 0;
    if (typeof Resumeables.curQ === "undefined" || Resumeables.curQ == null)
      Resumeables.curQ = -1;
    if (typeof Resumeables.allQ === "undefined" || Resumeables.allQ == null)
      Resumeables.allQ = [];
    if (
      typeof Resumeables.CurrentScore === "undefined" ||
      Resumeables.CurrentScore == null
    )
      Resumeables.CurrentScore = 0;

    if (data.errorCode == 0) {
      if (data.CompletionStatus != UBJ_API.COMPLETION_STATUS.COMPLETED) {
        data.CompletionStatus = UBJ_API.COMPLETION_STATUS.INCOMPLETE;
        UBJ_API.SubmitGameScore(
          data.Score,
          data.CompletionPercentage,
          data.CompletionStatus,
          data.TimeSpentSeconds,
          Resumeables
        );
      }
    }

    if (typeof callBackFunction === "function") callBackFunction(data);
  },

  ExternalLMSCallback: function (_dto, auth_token) {
    let urlParams = this.initParams;

    const configHeader = {
      header: "authorization",
      value: `Bearer ${auth_token}`,
    };

    const nDto = { ..._dto, auth_token };
    if (urlParams.is_postbookmarking && _dto?.is_bookmarking == 0) {
      UBJ_API.finalApiCall = true;
    }

    // if endpoint_url is 1, dont call endpoint_url API, instead postMessage
    if (urlParams.endpoint_url == 1) {
      try {
        window.parent.postMessage(
          JSON.stringify({ message: "module-completed", data: nDto }),
          "*"
        );
      } catch (err) {
        console.log(err);
      }

      if (urlParams.redirect_url) {
        if (urlParams?.redirect_url == 1) {
          try {
            window.parent.postMessage(
              JSON.stringify({ message: "close", data: {} }),
              "*"
            );
          } catch (err) {
            console.log(err);
          }
        } else {
          window.location.href = `${urlParams.redirect_url}`;
        }
      } else if (urlParams.is_popup) {
        try {
          window.self.close();
        } catch {}

        try {
          window.close();
        } catch {}

        try {
          window.top.close();
        } catch {}
      }
      return;
    }

    this.AjaxReq(
      urlParams.endpoint_url,
      "POST",
      {
        ..._dto,
      },
      function (data) {
        try {
          window.parent.postMessage(
            JSON.stringify({ message: "module-completed", data: nDto }),
            "*"
          );
        } catch (err) {
          console.log(err);
        }

        if (urlParams.is_postbookmarking && _dto.is_bookmarking == 1) {
          return;
        }
        const _data = JSON.parse(data);
        console.log("data", _data);

        if (urlParams.redirect_url) {
          if (urlParams?.redirect_url == 1) {
            try {
              window.parent.postMessage(
                JSON.stringify({ message: "close", data: {} }),
                "*"
              );
            } catch (err) {
              console.log(err);
            }
          } else {
            window.location.href = `${urlParams.redirect_url}`;
          }
        } else if (urlParams.is_popup) {
          try {
            window.self.close();
          } catch {}

          try {
            window.close();
          } catch {}

          try {
            window.top.close();
          } catch {}
        }

        UBJ_API.onReqSuccess();
      },
      function () {
        if (urlParams.is_postbookmarking) {
          return;
        }
        UBJ_API.onReqFailure();
      },
      configHeader
    );
  },

  // Submits score to Server
  // USe this function to update properties
  // Score update logic
  // Score: simple rightAns/totalQ percent
  // CompletionPercentage: attempted question percentage
  // CompletionStatus: is game completed or not 100% question attempted
  // TimeSpentSeconds: in milli seconds
  // Data to use for bookmarking
  SubmitGameScore(
    Score,
    CompletionPercentage,
    CompletionStatus,
    TimeSpentSeconds,
    Resumeables,
    dbBank,
    Questions
  ) {
    if (UBJ_API.finalApiCall && this.initParams.is_postbookmarking) {
      return;
    }
    if (
      this.TrackingEnabled ||
      this.initParams.islmsplayer ||
      this.initParams.is_postbookmarking
    ) {
      let dto = {};
      dto.UserId = this.userid;
      dto.ModuleId = this.moduleid;
      // when received status is completed and game status is incomplete send old data back except gamedata
      if (
        this.CompletionStatus == this.COMPLETION_STATUS.COMPLETED &&
        CompletionStatus == this.COMPLETION_STATUS.INCOMPLETE
      ) {
        dto.Score = this.Score;
        dto.CompletionPercentage = this.CompletionPercentage;
        dto.TimeSpentSeconds = this.TimeSpentSeconds;
      }
      // when received status is not completed and game status is completed or incomplete
      else {
        dto.Score = Score;
        dto.CompletionPercentage = CompletionPercentage;
        dto.TimeSpentSeconds = TimeSpentSeconds;
        /** **************** */
        UBJ_API.Score = dto.Score;
        UBJ_API.CompletionPercentage = dto.CompletionPercentage;
        UBJ_API.CompletionStatus = CompletionStatus;
        UBJ_API.TimeSpentSeconds = dto.TimeSpentSeconds;
      }
      dto.CompletionStatus = CompletionStatus;
      dto.GameData = JSON.stringify(Resumeables);

      if (this.initParams.islmsplayer && !this.initParams.is_postbookmarking) {
        const total_correct_questions = Questions.filter(
          (item) => item.Status == 3
        );
        let lmsDto = {
          ContentId: this.content_id,
          ContainerId: this.container_id,
          TotalQuestions: Questions?.length,
          CorrectQuestions: total_correct_questions?.length,
          TimeSpentInSeconds: TimeSpentSeconds,
          QuestionsData: dbBank,
        };
        if (this.initParams?.callback_data) {
          lmsDto = { ...lmsDto, ...JSON.parse(this.initParams?.callback_data) };
        }
        const encrypt = LZString.compressToBase64(JSON.stringify(lmsDto));
        const RemoveEqualSigns = encrypt.split("=");
        lmsDto = { enc_data: RemoveEqualSigns[0] };

        if (CompletionStatus == this.COMPLETION_STATUS.COMPLETED)
          this.ExternalLMSCallback(lmsDto, this.initParams?.sessionid);
      }
      if (this.initParams.is_postbookmarking) {
        const total_correct_questions = Questions.filter(
          (item) => item.Status == 3
        );
        dto = {
          ...dto,
          ContentId: this.content_id,
          ContainerId: this.container_id,
          TotalQuestions: Questions?.length,
          CorrectQuestions: total_correct_questions?.length,
          TimeSpentInSeconds: TimeSpentSeconds,
          GameData: dbBank,
          is_bookmarking: this.initParams.is_postbookmarking
            ? CompletionStatus == this.COMPLETION_STATUS.COMPLETED
              ? 0
              : 1
            : undefined,
        };
        if (this.initParams?.callback_data) {
          dto = { ...dto, ...JSON.parse(this.initParams?.callback_data) };
        }
        this.ExternalLMSCallback(dto);
      }

      // set these or in case of any error use default

      if (this.isOffline) {
        this.dbSet("gameData", dto);
      } else if (
        !this.initParams.islmsplayer &&
        !this.initParams.is_postbookmarking
      ) {
        this.AjaxReq(
          `${this.ApplicationURL}SubmitGameScore`,
          "POST",
          dto,
          function (data) {
            // console.log("Success: ", data);
            /* if (typeof callback == "function")
                        callback(data); */
          },
          function (error) {
            // console.log("Failure: ", error);
            /* if (typeof callback == "function")
                            callback(data); */
          }
        );
      }
    } else if (
      this.initParams.is_offline_lms &&
      CompletionStatus == this.COMPLETION_STATUS.COMPLETED
    ) {
      const total_correct_questions = Questions.filter(
        (item) => item.Status == 3
      );
      let lmsDto = {
        ContentId: this.content_id,
        ContainerId: this.container_id,
        TotalQuestions: Questions?.length,
        CorrectQuestions: total_correct_questions?.length,
        TimeSpentInSeconds: TimeSpentSeconds,
        QuestionsData: dbBank,
      };
      // if (this.initParams?.callback_data) {
      //   lmsDto = { ...lmsDto, ...JSON.parse(this.initParams?.callback_data) };
      // }
      // const encrypt = LZString.compressToBase64(JSON.stringify(lmsDto));
      // const RemoveEqualSigns = encrypt.split("=");
      // lmsDto = { enc_data: RemoveEqualSigns[0] };
      window.parent.postMessage(
        JSON.stringify({ message: "offline-game-submitted", data: lmsDto }),
        "*"
      );
    }
  },
  // function to unload parent page
  onbeforeunloadFunc() {
    window.opener.location.reload(true);
  },
  // Resets the milli second timer
  InitTimer() {
    this.timeSpentMilliSeconds = new Date().getTime();
  },

  // returns the difference between last time called InitTimer and this
  GetTimeDifference() {
    const currentTimestamp = new Date().getTime();
    const timeSpentTillNow =
      new Date(currentTimestamp).getTime() - this.timeSpentMilliSeconds;
    return timeSpentTillNow;
  },

  AjaxReq(call, reqtype, data, success, error, configHeader) {
    this.curReq = [call, reqtype, data, success, error];
    if (reqtype === "GET") {
      const pairs = [];
      for (const prop in data) {
        if (data.hasOwnProperty(prop)) {
          const k = encodeURIComponent(prop);
          const v = encodeURIComponent(data[prop]);
          pairs.push(`${k}=${v}`);
        }
      }
      call += `?${pairs.join("&")}`;
    }
    var x = null;
    const _this = this;
    try {
      var x = new XMLHttpRequest();
      x.open(reqtype, call);
      if (configHeader)
        x.setRequestHeader(configHeader.header, configHeader.value);
      x.setRequestHeader("X-Requested-With", "XMLHttpRequest");
      x.setRequestHeader("Content-type", "application/json; charset=utf-8");
      x.timeout = this.requestTimeout;
      x.onreadystatechange = function () {
        if (x.readyState == 4) {
          if (x.status == 200) {
            _this.onReqSuccess(x);
            if (typeof success === "function") success(x.responseText);
          } else {
            if (UBJ_API.initParams.is_postbookmarking) {
              return;
            }
            _this.onReqFailure(x);
            if (typeof error === "function") error(x);
          }
        }
      };

      if (reqtype == "GET") x.send();
      else x.send(JSON.stringify(data));
    } catch (e) {
      window.console && console.log(e);
      _this.onReqFailure(e);
    }
    return x;
  },
  onReqSuccess(data) {
    console.log("Request successfull!");
    try {
      console.log(JSON.parse(data.responseText));
    } catch (e) {
      console.error(data);
    }
    this.hideLoader();
  },
  onReqFailure(data) {
    try {
      console.error(JSON.parse(data.responseText));
    } catch (e) {
      // console.error(data);
    }
    this.showLoader(true);
  },
  onRetry() {
    this.showLoader();
    this.AjaxReq(
      this.curReq[0],
      this.curReq[1],
      this.curReq[2],
      this.curReq[3],
      this.curReq[4]
    );
  },
  hideLoader() {
    this.css("#apiLoaderContainer", { display: "none" });
    this.css("#apiLoader", { display: "flex" });
    this.css("#apiRetryPopup", { display: "none" });
  },
  showLoader(isRetry) {
    this.css("#apiLoaderContainer", { display: "flex" });
    if (!isRetry) {
      this.css("#apiLoader", { display: "flex" });
      this.css("#apiRetryPopup", { display: "none" });
    } else {
      this.css("#apiLoader", { display: "none" });
      this.css("#apiRetryPopup", { display: "flex" });
    }
  },
};
