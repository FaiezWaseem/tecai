window.scaleFactor = 1;
window.margin_top = 0;
window.margin_left = 0;

function GameService(_appName, manifest, _onLoadingComplete, _props) {
  var _this = this;
  var props = _props || {};
  this.gameWidth = 854;
  this.gameHeight = 480;
  this.orientation = "";
  this.curOrientation = GameService.ORIENTATION.Landscape;
  this.isResized = false;
  this.appID = "com.knowledgeplatform";
  this.appName = "";
  this.lockUserInput = false;
  this.directLevel = false;
  this.onBackButton = null;
  this.onPause = null;
  this.onResume = null;
  this.onResized =
    typeof props.onResized == "function" ? props.onResized : function () {};
  this.initParams = {};
  this.scaleFactor = 1;
  this.minScaleFactor = 0.375;
  this.margin_top = 0;
  this.margin_left = 0;
  var preloader = null;
  this.isSound = true;
  this.AppTypes = {
    Store: "",
    Classroom: "classroom",
    DirectLevel: "directLevel",
    Classroom_DirectLevel: "classroomdirectlevel",
  };
  this.pageLoadReq = [];
  this.cachedPages = [];
  this.init = function (_appName, manifest, _onLoadingComplete, _props) {
    //
    if (typeof _onLoadingComplete == "function")
      window.addEventListener("message", onMessage, false);
    function onMessage(event) {
      try {
        this.eventData = JSON.parse(event?.data);
      } catch {
        return;
      }
      if (this.eventData.message === "offline-game-data") {
        const data = this.eventData.data.json_data;
        // 1 means its coming from CMS data and 0 mean kp data
        if (this.eventData.data.is_content_type === 1) {
          const _data = JSON.parse(data);
          Resumeables.dbFromServer = _data.dataBank;
          // dataBank=
        } else {
          const _data = JSON.parse(data);
          Resumeables.dbFromServer = _data;
        }
        preloader = new Preloader(manifest, _onLoadingComplete);
      }
      removeMessageEvent();
    }
    function removeMessageEvent() {
      window.removeEventListener("message", onMessage);
    }
    if (!this.initParams.is_offline_lms) {
      preloader = new Preloader(manifest, _onLoadingComplete);
    }
    _props = _props || {};
    _this.appName = _appName;
    _this.orientation = _props.orientation || GameService.ORIENTATION.Landscape;
    if (_this.isMob()) {
      _this.curOrientation = _this.getOrientation();
    }
    _this.initParams = _this.getParams();
    if (!this.isBrowserCompatible()) {
      $("#page_place_holder").addClass("blur");
      $("#compatPopup").show();
      $("#compatPopup .popup-wrapper").addClass("bounceIn");
    }
    if (_this.isIos()) {
      $(document.body).addClass("ios");
    }
    if (_this.initParams.level != null) {
      _this.initParams.level = parseInt(_this.initParams.level);
      _this.directLevel = true;
      if (_this.initParams.type == _this.AppTypes.Classroom)
        _this.initParams.type = _this.AppTypes.Classroom_DirectLevel;
      else _this.initParams.type = _this.AppTypes.DirectLevel;
    } else if (_this.initParams.type == _this.AppTypes.Classroom)
      _this.initParams.type = _this.AppTypes.Classroom;
    else _this.initParams.type = _this.AppTypes.Store;

    _this.setAppID(_this.initParams.type, _appName);
    addOrientationChecks();
    FastClick.attach(document.body);

    addMethods();

    addListeners();

    _this.isSound = _this.dbGet("sound", "1") == "1";
    if (_props.allPages) {
      _this.preloadPages(_props.allPages);
    }
    $(window).resize();
    setTimeout(function () {
      $(window).resize();
    }, 500);
  };

  var addOrientationChecks = function () {
    var close = "images/close.svg";
    var imgSrc =
      'data:image/svg+xml;charset=UTF-8, <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="455.294px" height="394.117px" viewBox="0 0 455.294 394.117" enable-background="new 0 0 455.294 394.117" xml:space="preserve"> <g> <path fill="none" stroke="%23000000" stroke-width="4.8" stroke-miterlimit="10" d="M222.597,33.954 C269.721-2.135,337.175,6.81,373.265,53.934c19.154,25.009,25.623,55.745,20.432,84.482"/> <polygon points="384.38,166.765 413.194,131.64 393.831,136.112 380.354,121.511 "/> </g> <g opacity="0.4"> <path fill="%2314102C" d="M207.157,362.459c0.043,12.881-10.441,23.451-23.326,23.498l-151.911,0.58 c-12.868,0.053-23.446-10.432-23.49-23.313L7.158,33.415C7.106,20.542,17.598,9.968,30.475,9.921l151.91-0.585 c12.877-0.052,23.455,10.441,23.498,23.317L207.157,362.459z"/> <path fill="%2372CFF2" d="M197.612,318.281c0.026,5.148-4.175,9.383-9.305,9.404l-161.284,0.625 c-5.147,0.016-9.374-4.193-9.391-9.326L16.617,56.792c-0.026-5.151,4.174-9.382,9.33-9.403l161.267-0.62 c5.147-0.021,9.373,4.175,9.391,9.331L197.612,318.281z"/> <polygon opacity="0.3" fill="%23DAF1FD" points="90.528,47.139 16.849,117.104 16.893,128.349 102.466,47.096 "/> <path opacity="0.3" fill="%23DAF1FD" d="M196.966,152.557L18.27,322.25c1.352,3.533,4.76,6.072,8.754,6.061l10.38-0.045 l159.666-151.6L196.966,152.557z"/> <path opacity="0.3" fill="%23DAF1FD" d="M93.704,328.051l94.603-0.365c5.13-0.021,9.331-4.256,9.305-9.404l-0.344-88.576 L93.704,328.051z"/> <path fill="%235D6469" d="M134.46,356.912c0.026,7.463-6,13.543-13.479,13.564l-27.552,0.111 c-7.471,0.027-13.548-6.008-13.574-13.475l0,0c-0.034-7.479,5.999-13.543,13.471-13.572l27.561-0.104 C128.349,343.402,134.434,349.432,134.46,356.912L134.46,356.912z"/> <path fill="%235D6469" d="M133.814,30.479c0.017,2.871-2.298,5.203-5.173,5.216l-44.233,0.168c-2.857,0.009-5.19-2.307-5.199-5.186 l0,0c-0.009-2.862,2.298-5.203,5.164-5.22l44.225-0.168C131.473,25.276,133.806,27.604,133.814,30.479L133.814,30.479z"/> </g> <g> <path fill="%2314102C" d="M95.236,186.538c-12.881-0.043-23.451,10.44-23.498,23.325l-0.58,151.912 c-0.053,12.867,10.432,23.445,23.313,23.488l329.81,1.273c12.873,0.053,23.447-10.439,23.494-23.316l0.586-151.91 c0.051-12.877-10.441-23.455-23.318-23.498L95.236,186.538z"/> <path fill="%2372CFF2" d="M139.414,196.084c-5.148-0.026-9.383,4.174-9.404,9.305l-0.625,161.283 c-0.016,5.148,4.193,9.373,9.326,9.391l262.192,1.016c5.151,0.025,9.382-4.174,9.403-9.33l0.62-161.268 c0.021-5.146-4.175-9.373-9.33-9.391L139.414,196.084z"/> <polygon opacity="0.3" fill="%23DAF1FD" points="410.557,303.168 340.592,376.846 329.347,376.803 410.6,291.229 "/> <path opacity="0.3" fill="%23DAF1FD" d="M305.139,196.729L135.445,375.426c-3.533-1.352-6.072-4.76-6.061-8.754l0.045-10.381 l151.6-159.665L305.139,196.729z"/> <path opacity="0.3" fill="%23DAF1FD" d="M129.645,299.992l0.365-94.604c0.021-5.131,4.256-9.331,9.404-9.305l88.576,0.344 L129.645,299.992z"/> <path fill="%235D6469" d="M100.783,259.236c-7.463-0.027-13.543,5.998-13.564,13.479l-0.111,27.553 c-0.027,7.471,6.008,13.547,13.475,13.572l0,0c7.479,0.035,13.543-5.998,13.572-13.471l0.104-27.561 C114.293,265.348,108.264,259.262,100.783,259.236L100.783,259.236z"/> <path fill="%235D6469" d="M427.216,259.881c-2.871-0.018-5.203,2.299-5.216,5.174l-0.168,44.232 c-0.009,2.857,2.307,5.189,5.187,5.199l0,0c2.861,0.008,5.203-2.299,5.22-5.164l0.168-44.225 C432.419,262.223,430.091,259.891,427.216,259.881L427.216,259.881z"/> </g> </svg>';
    if (_this.orientation == GameService.ORIENTATION.Portrait)
      imgSrc =
        'data:image/svg+xml;charset=UTF-8, <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="455.29px" height="394.12px" viewBox="0 0 455.29 394.12" enable-background="new 0 0 455.29 394.12" xml:space="preserve"> <g> <path fill="none" stroke="%23000000" stroke-width="4.8" stroke-miterlimit="10" d="M55.333,172.934 c-22.046-55.11,4.756-117.654,59.867-139.7c29.248-11.701,60.589-9.643,86.862,3.106"/> <polygon fill="%23000000" points="226.847,52.955 200.793,15.737 199.879,35.587 182.185,44.629 "/> </g> <g opacity="0.4"> <path fill="%2314102C" d="M363.305,185.687c12.881-0.043,23.451,10.44,23.498,23.324l0.58,151.912 c0.053,12.867-10.432,23.445-23.313,23.49l-329.81,1.273c-12.873,0.051-23.446-10.441-23.494-23.318l-0.585-151.91 c-0.052-12.876,10.441-23.454,23.317-23.497L363.305,185.687z"/> <path fill="%2372CFF2" d="M319.127,195.233c5.148-0.026,9.383,4.174,9.404,9.305l0.625,161.282c0.016,5.148-4.193,9.375-9.326,9.391 l-262.192,1.016c-5.151,0.027-9.382-4.174-9.403-9.33l-0.62-161.267c-0.021-5.146,4.175-9.373,9.331-9.391L319.127,195.233z"/> <polygon opacity="0.3" fill="%23DAF1FD" points="47.985,302.316 117.95,375.996 129.195,375.951 47.942,290.376 "/> <path opacity="0.3" fill="%23DAF1FD" d="M153.403,195.877l169.693,178.696c3.533-1.352,6.072-4.76,6.061-8.754l-0.045-10.381 L177.513,195.775L153.403,195.877z"/> <path opacity="0.3" fill="%23DAF1FD" d="M328.897,299.14l-0.365-94.603c-0.021-5.131-4.256-9.331-9.404-9.305l-88.576,0.344 L328.897,299.14z"/> <path fill="%235D6469" d="M357.758,258.384c7.463-0.027,13.543,5.998,13.564,13.479l0.111,27.553 c0.027,7.471-6.008,13.547-13.475,13.572l0,0c-7.479,0.035-13.543-5.998-13.572-13.471l-0.104-27.561 C344.249,264.496,350.278,258.41,357.758,258.384L357.758,258.384z"/> <path fill="%235D6469" d="M31.326,259.029c2.871-0.018,5.203,2.299,5.216,5.174l0.168,44.232c0.009,2.857-2.307,5.189-5.186,5.199 l0,0c-2.862,0.008-5.203-2.299-5.22-5.164l-0.168-44.225C26.123,261.371,28.451,259.039,31.326,259.029L31.326,259.029z"/> </g> <g> <path fill="%2314102C" d="M444.997,361.609c0.043,12.881-10.441,23.451-23.326,23.498l-151.91,0.58 c-12.868,0.053-23.446-10.432-23.49-23.313l-1.273-329.811c-0.051-12.873,10.441-23.446,23.318-23.494l151.91-0.585 c12.877-0.052,23.455,10.441,23.498,23.317L444.997,361.609z"/> <path fill="%2372CFF2" d="M435.452,317.431c0.025,5.148-4.176,9.383-9.305,9.404l-161.284,0.625 c-5.147,0.016-9.374-4.193-9.391-9.326l-1.016-262.193c-0.026-5.151,4.175-9.382,9.33-9.403l161.267-0.62 c5.147-0.021,9.373,4.175,9.391,9.331L435.452,317.431z"/> <polygon opacity="0.3" fill="%23DAF1FD" points="328.368,46.288 254.688,116.252 254.732,127.498 340.305,46.245 "/> <path opacity="0.3" fill="%23DAF1FD" d="M434.805,151.706L256.109,321.4c1.352,3.533,4.76,6.072,8.754,6.061l10.38-0.045 l159.666-151.601L434.805,151.706z"/> <path opacity="0.3" fill="%23DAF1FD" d="M331.543,327.201l94.604-0.365c5.129-0.021,9.33-4.256,9.305-9.404l-0.345-88.578 L331.543,327.201z"/> <path fill="%235D6469" d="M372.299,356.062c0.025,7.463-6,13.543-13.479,13.564l-27.553,0.111 c-7.471,0.027-13.548-6.008-13.574-13.475l0,0c-0.033-7.479,6-13.543,13.471-13.572l27.561-0.104 C366.188,342.552,372.274,348.582,372.299,356.062L372.299,356.062z"/> <path fill="%235D6469" d="M371.654,29.628c0.017,2.871-2.298,5.203-5.173,5.216l-44.233,0.168c-2.857,0.009-5.19-2.307-5.198-5.186 l0,0c-0.01-2.862,2.297-5.203,5.164-5.22l44.225-0.168C369.313,24.425,371.645,26.753,371.654,29.628L371.654,29.628z"/> </g> </svg>';
    $(document.body).append(
      "<div id='orientationContainer' style='z-index:88888; text-align: center; position: absolute; width: 101%; height: 101%; top: 0; left: 0; background-color: #FFF; display: -webkit-flex; display: flex; -webkit-flex-direction: column; flex-direction: column; -webkit-justify-content: center; justify-content: center; -webkit-align-items: center; align-items: center; display: none;'><button id=popup-close-btn style='border: none;background: transparent;position:absolute; top:20px; right:20px'><img src='images/close.svg' width='20' height='20' style=width:20px/></button><img src='" +
        imgSrc +
        "' width='160px' style='max-width:160px'/><div style='color: #555; font-size: 22px; padding: 20px; font-family: \"Museo Sans 900\", \"Museo_Sans_900\", \"museo_sans900\";'>Please rotate your device to <span style='text-transform: lowercase;'>" +
        _this.orientation +
        "</span> mode.</div></div>"
    );
  };

  var checkForOrientation = function () {
    //  console.log("check for orientation");
    $("#page_place_holder").show();
    $("#orientationContainer").css({ display: "none" });
    $("#orientationContainer img:eq(1)").css({ width: "200px" });
    $("#orientationContainer div").css({ fontSize: "22px" });
    if (
      _this.curOrientation != _this.orientation &&
      _this.orientation == GameService.ORIENTATION.Landscape
    ) {
      $("#page_place_holder").hide();
      $("#orientationContainer").css({
        display: "-webkit-flex",
        display: "flex",
      });
      $(document.body).scrollTop(-1);
      $(document.body).scrollLeft(-1);
    } else if (
      _this.curOrientation != _this.orientation &&
      _this.orientation == GameService.ORIENTATION.Portrait
    ) {
      $("#page_place_holder").hide();
      $("#orientationContainer").css({
        display: "-webkit-flex",
        display: "flex",
      });
      $(document.body).scrollTop(-1);
      $(document.body).scrollLeft(-1);
    }
  };

  this.isFacebookInApp = function () {
    var ua = navigator.userAgent || navigator.vendor || window.opera;
    return ua.indexOf("FBAN") > -1 || ua.indexOf("FBAV") > -1;
  };

  this.isBrowserCompatible = function () {
    if (this.isIos() && this.isFacebookInApp()) {
      return false;
    }
    return true;
  };

  this.isAndroid = function () {
    return navigator.userAgent.match(/Android/i);
  };
  this.isIos = function () {
    return navigator.userAgent.match(/iPhone/i);
  };
  this.isMob = function () {
    if (
      navigator.userAgent.match(/Android/i) ||
      navigator.userAgent.match(/webOS/i) ||
      navigator.userAgent.match(/iPhone/i) ||
      navigator.userAgent.match(/iPad/i) ||
      navigator.userAgent.match(/iPod/i) ||
      navigator.userAgent.match(/BlackBerry/i) ||
      navigator.userAgent.match(/Windows Phone/i)
    ) {
      return true;
    } else {
      return false;
    }
  };
  this.setAppID = function (appType, appName) {
    if (appType != "") appType = "." + appType;
    _this.appID = "com.knowledgeplatform" + appType + "." + appName + ".";
  };
  this.appendToAppID = function (appendStr) {
    _this.appID += appendStr + ".";
  };
  this.dbSet = function (key, value) {
    localStorage[_this.appID + key] = value;
  };
  this.dbGet = function (key, defaultValue) {
    if (typeof localStorage[_this.appID + key] == "undefined")
      return defaultValue;
    return localStorage[_this.appID + key];
  };
  this.dbDel = function (key) {
    localStorage.removeItem(_this.appID + key);
  };
  var addMethods = function () {
    $.fn._GetData = function (key) {
      return $(this).attr("data-" + key);
    };
    $.fn._SetData = function (key, val) {
      return $(this).attr("data-" + key, val);
    };
  };
  var extractDomain = function (url) {
    var domain;
    //find & remove protocol (http, ftp, etc.) and get domain
    if (url.indexOf("://") > -1) {
      domain = url.split("/")[2];
    } else {
      domain = url.split("/")[0];
    }
    //find & remove port number
    domain = domain.split(":")[0];
    return domain;
  };
  this.gotoBasePage = function () {
    var openPageLocation = extractDomain(window.location.href);
    if (openPageLocation.indexOf("http://") < 0) {
      openPageLocation = "http://" + openPageLocation;
    }
    //console.log("href: " + openPageLocation);
    window.location.href = openPageLocation;
  };
  this.onHomeBt = function () {
    if (!_this.directLevel) {
      // no parameter(s) in url
      return;
    }
    // parameter(s) in url
    try {
      if (window.opener != null) {
        // opener exists
        if (window.opener.location != null) {
          //console.log(window.location);
          if (window.opener.location.href != null) {
            //console.log(window.location.href);
            if (
              extractDomain(window.location.href).toLocaleLowerCase() !=
              extractDomain(window.opener.location.href).toLocaleLowerCase()
            ) {
              // base url different
              _this.gotoBasePage();
              return;
            } else {
              // base url same
              window.close();
              return;
            }
          }
        }
      } else {
        // opener doesnt exists
        _this.gotoBasePage();
        return;
      }
    } catch (e) {
      _this.gotoBasePage();
      return;
    }
    window.close();
  };
  this.getParams = function () {
    // This function is anonymous, is executed immediately and
    // the return value is assigned to QueryString!
    var query_string = {};
    var query = window.location.search.substring(1);
    //console.log(query.length);
    if (query.length == 0) {
      query_string.type = _this.AppTypes.Store;
      return query_string;
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
    //console.log("initParams: " + JSON.stringify(query_string));
    if (!query_string.type) query_string.type = _this.AppTypes.Store;
    return query_string;
  };

  this.onResize = function () {
    _this.onOrientationChange();
    var screenWidth = window.innerWidth;
    var screenHeight = window.innerHeight;
    var scaleToFitX = screenWidth / _this.gameWidth;
    var scaleToFitY = screenHeight / _this.gameHeight;
    _this.scaleFactor = Math.min(scaleToFitX, scaleToFitY);
    $(document.body).addClass("no-scroll");
    if (_this.scaleFactor < _this.minScaleFactor) {
      _this.scaleFactor = _this.minScaleFactor;
      if (_this.curOrientation != GameService.ORIENTATION.Portrait) {
        $(document.body).removeClass("no-scroll");
      }
      return;
    }
    $(window).scrollTop(-1);
    $(window).scrollLeft(-1);
    window.margin_left = 0;
    window.margin_top = 0;
    $(".main_container").css({ "margin-left": "0", "margin-top": "0" });
    if (screenWidth / screenHeight > _this.gameWidth / _this.gameHeight) {
      var tmpHeight = screenHeight;
      var tmpWidth = (tmpHeight / _this.gameHeight) * _this.gameWidth;
      this.margin_left = Math.floor((screenWidth - tmpWidth) / 2);
      window.margin_left = this.margin_left;
      $(".main_container").css({ "margin-left": this.margin_left + "px" });
    } else {
      var tmpWidth = screenWidth;
      var tmpHeight = (tmpWidth / _this.gameWidth) * _this.gameHeight;
      this.margin_top = Math.floor((screenHeight - tmpHeight) / 2);
      window.margin_top = this.margin_top;
      $(".main_container").css({ "margin-top": this.margin_top + "px" });
    }

    window.scaleFactor = _this.scaleFactor;
    $(".main_container").css({
      transform: "scale(" + _this.scaleFactor + "," + _this.scaleFactor + ")",
      "-webkit-transform":
        "scale(" + _this.scaleFactor + "," + _this.scaleFactor + ")",
    });
    _this.resizeCompatPopup();
    if (typeof this.onResized == "function") {
      this.onResized(_this.scaleFactor);
    }
  };

  this.resizeCompatPopup = function () {
    // popup
    $("#compatPopup .popup-fg").css({
      width: _this.mapValue(290, 310) + "px",
      padding: _this.mapValue(14.5, 12) + "px",
    });
    $("#compatPopup .icon").css({ width: _this.mapValue(150, 42) + "px" });
    $("#compatPopup .popup-title").css({
      "font-size": _this.mapValue(14.5, 18) + "px",
      padding: _this.mapValue(16, 12) + "px 0",
    });
    $("#compatPopup .popup-text").css({
      "font-size": _this.mapValue(12, 16) + "px",
    });
    $("#compatPopup .dots-v").css({
      "font-size": _this.mapValue(20, 22) + "px",
      padding: _this.mapValue(10, 10) + "px",
    });
  };

  this.mapValue = function (val, minVal) {
    if (minVal == null) minVal = 0;
    return Math.max(Math.round(_this.scaleFactor * val), minVal);
  };

  this.preloadPages = function (pagesToLoad, callback) {
    var i = 0;
    for (i = 0; i < pagesToLoad.length; i++) {
      this.cacheSinglePage(
        pagesToLoad[i],
        i == pagesToLoad.length - 1 ? callback : null
      );
    }
  };

  this.cacheSinglePage = function (pageName, callback) {
    var tempDiv = $("<div/>", {
      id: "tempContainer",
      style: "display:none;",
    });
    //console.log("LoadingPage: ", pageName);
    $(tempDiv).load(pageName + ".html", function (p) {
      if (p && tempDiv[0].querySelector("#page_content")) {
        _this.cachedPages.push({
          name: pageName,
          data: tempDiv[0].querySelector("#page_content").innerHTML,
        });
      } else {
        console.warn("Unable to preload page: ", pageName + ".html");
      }
      if (typeof callback == "function") callback();
    });
  };

  this.loadPage = function (pageName, callback) {
    this.pageLoadReq = [pageName, callback];
    $("#error_page").hide();
    var tempDiv = $("<div/>", {
      id: "tempContainer",
      style: "display:none;",
    });
    var pageId = this.isPageLoaded(pageName);
    if (pageId == -1) {
      $(tempDiv).load(pageName + ".html", function (p) {
        //console.log("onPageLoad: ", p);
        if (p) {
          _this.cachedPages.push({
            name: pageName,
            data: tempDiv[0].querySelector("#page_content").innerHTML,
          });
          $("#error_page").next().removeClass("blur").show();
        } else {
          console.log("Failed to load the page!");
          tempDiv[0].innerHTML = '<div id="page_content"></div>';
          $("#error_page").show();
          $("#error_page").next().addClass("blur").hide();
        }
        if (
          typeof callback == "function" &&
          tempDiv[0].querySelector("#page_content")
        )
          callback(tempDiv[0].querySelector("#page_content").innerHTML);
        _this.fixInputFocus();
      });
    } else {
      if (typeof callback == "function")
        callback(_this.cachedPages[pageId].data);
      _this.fixInputFocus();
    }
  };

  this.fixInputFocus = function () {
    $("input").on("input", function () {
      // console.log("hello g");
      if ($(document.body).hasClass("no-scroll")) return;
      $(document.body).scrollTop($(this).offset().top);
      $(document.body).scrollLeft($(this).offset().left);
    });
  };

  this.isPageLoaded = function (pageName) {
    var pageId = -1;
    for (var i = 0; i < this.cachedPages.length; i++) {
      if (this.cachedPages[i].name == pageName) {
        pageId = i;
        break;
      }
    }
    return pageId;
  };

  this.retryPageLoad = function () {
    _this.loadPage(_this.pageLoadReq[0], _this.pageLoadReq[1]);
  };

  var resumeService = function () {
    Howler.mute(false);
    Timeouts.resumeAll();
  };
  var pauseService = function () {
    Howler.mute(true);
    Timeouts.pauseAll();
  };
  var windowFocusChangeEvent = function (focusCallback, blurCallback) {
    var hidden = "hidden";
    // Standards:
    if (hidden in document)
      document.addEventListener("visibilitychange", onchange);
    else if ((hidden = "mozHidden") in document)
      document.addEventListener("mozvisibilitychange", onchange);
    else if ((hidden = "webkitHidden") in document)
      document.addEventListener("webkitvisibilitychange", onchange);
    else if ((hidden = "msHidden") in document)
      document.addEventListener("msvisibilitychange", onchange);
    // IE 9 and lower:
    else if ("onfocusin" in document)
      document.onfocusin = document.onfocusout = onchange;
    // All others:
    else
      window.onpageshow =
        window.onpagehide =
        window.onfocus =
        window.onblur =
          onchange;

    function onchange(evt) {
      var v = "visible",
        h = "hidden",
        evtMap = {
          focus: v,
          focusin: v,
          pageshow: v,
          blur: h,
          focusout: h,
          pagehide: h,
        };

      evt = evt || window.event;
      var state = "";
      if (evt.type in evtMap) state = evtMap[evt.type];
      else state = this[hidden] ? "hidden" : "visible";
      if (state == "hidden") {
        //console.log("window hidden");
        if (typeof blurCallback == "function") blurCallback();
      } else {
        //console.log("window visible");
        if (typeof focusCallback == "function") focusCallback();
      }
    }

    // set the initial state (but only if browser supports the Page Visibility API)
    if (document[hidden] !== undefined)
      onchange({
        type: document[hidden] ? "blur" : "focus",
      });
  };

  this.getOrientation = function () {
    var orientation = "";
    if (_this.isMob() && window.orientation) {
      switch (window.orientation) {
        case 0:
        case 180:
          // Portrait
          // Portrait (Upside-down)
          orientation = GameService.ORIENTATION.Portrait;
          break;
        case -90:
        case 90:
          // Landscape (Clockwise)
          // Landscape  (Counterclockwise)
          orientation = GameService.ORIENTATION.Landscape;
          break;
      }
    } else {
      if (window.innerWidth < window.innerHeight) {
        orientation = GameService.ORIENTATION.Portrait;
      } else {
        orientation = GameService.ORIENTATION.Landscape;
      }
    }
    return orientation;
  };

  this.onOrientationChange = function () {
    _this.curOrientation = _this.getOrientation();
    //console.log("orientation", _this.curOrientation);
    checkForOrientation();
  };

  var addListeners = function () {
    document.addEventListener(
      "touchstart",
      function (event) {
        if (event.touches.length > 1) {
          event.preventDefault();
        }
      },
      false
    );
    $("#popup-close-btn").on("click", function () {
      $("#page_place_holder").show();

      $("#orientationContainer").css({ display: "none" });
    });
    document.addEventListener(
      "touchmove",
      function (event) {
        if (event.touches.length > 1) {
          event.preventDefault();
        }
      },
      false
    );

    $(window).on("orientationchange", function (event) {
      _this.onOrientationChange();
    });

    $(window).trigger("orientationchange");

    var resumeAudioContext = function () {
      Howler.ctx.resume();
      document.removeEventListener("click", resumeAudioContext);
    };
    document.addEventListener("click", resumeAudioContext);

    $("#retryPageLoad").on("click", _this.retryPageLoad);
    $(window).on("resize", _this.onResize);
    if (_this.isIos()) {
      setInterval(_this.onResize, 5000);
    }
    if (window.cordova) {
      //console.log("Adding cordova events");
      document.addEventListener(
        "deviceready",
        function () {
          document.addEventListener(
            "backbutton",
            function (e) {
              if (typeof _this.onBackButton == "function") _this.onBackButton();
            },
            false
          );

          document.addEventListener(
            "pause",
            function () {
              //console.log("on pause");
              pauseService();
              if (typeof _this.onPause == "function") _this.onPause();
            },
            false
          );

          document.addEventListener(
            "resume",
            function () {
              //console.log("on resume");
              resumeService();
              if (typeof _this.onResume == "function") _this.onResume();
            },
            false
          );
        },
        false
      );
    } else {
      //console.log("Adding desktop events");
      document.addEventListener("keydown", function (e) {
        var keyCode = e.which || e.keyCode;
        if (keyCode == 27) {
          // escape key
          if (typeof _this.onBackButton == "function") _this.onBackButton(e);
        }
      });
      windowFocusChangeEvent(
        function () {
          //console.log("on resume");
          resumeService();
          if (typeof _this.onResume == "function") _this.onResume();
        },
        function () {
          //console.log("on pause");
          pauseService();
          if (typeof _this.onPause == "function") _this.onPause();
        }
      );
    }

    $("#KP_float_btn").on("click", function () {
      if (_this.IsFullScreenActive()) {
        $(this).removeClass("go-small");
        $(this).attr("title", "Full Screen");
      } else {
        $(this).addClass("go-small");
        $(this).attr("title", "Small Screen");
      }
      _this.ToggleFullScreen(document.body);
    });
  };
  this.loadJS = function (url, onLoaded) {
    //url is URL of external file, implementationCode is the code
    //to be called from the file, location is the location to
    //insert the <script> element
    var scriptTag = document.createElement("script");
    scriptTag.src = url;
    if (typeof onLoaded == "function") scriptTag.onload = onLoaded;
    document.body.appendChild(scriptTag);
  };
  this.loadJSON = function (path, callback) {
    ajax(
      path,
      {
        method: "GET",
      },
      function (err, resp) {
        //console.log(resp);
        if (typeof success == "function")
          callback({ errorCode: 0, data: resp });
      },
      function (xhr) {
        xhr.responseType = "json";
        if (typeof success == "function") callback({ errorCode: 1, data: [] });
      }
    );
  };
  this.playSound = function (soundName, loop, volume, restart) {
    if (typeof preloader.sounds[soundName] == "undefined") {
      //console.error("No sound found with id: " + soundName)
      return;
    }
    if (!volume) volume = 1;
    if (!loop) loop = 0;
    if (restart) {
      preloader.sounds[soundName].play();
    } else if (!preloader.sounds[soundName].playing()) {
      preloader.sounds[soundName].play();
    }
    preloader.sounds[soundName].volume(volume);
    preloader.sounds[soundName].loop(loop);
    preloader.sounds[soundName].mute(!_this.isSound);
    return preloader.sounds[soundName];
  };
  this.stopSound = function (soundName, time) {
    if (!time) {
      preloader.sounds[soundName].stop();
    } else {
      preloader.sounds[soundName].fade(
        preloader.sounds[soundName].volume(),
        0,
        time
      );
      preloader.sounds[soundName].on("fade", function (e) {
        preloader.sounds[soundName].stop();
        preloader.sounds[soundName].off("fade");
      });
    }
  };
  this.setVolume = function (soundName, volume) {
    preloader.sounds[soundName].volume(volume);
  };
  this.setMute = function (soundName, mute) {
    preloader.sounds[soundName].mute(mute);
  };
  this.stopAllSounds = function () {
    for (var key in preloader.sounds) {
      preloader.sounds[key].stop();
    }
  };
  this.muteAllSounds = function () {
    for (var key in preloader.sounds) {
      preloader.sounds[key].mute(true);
    }
  };
  this.unmuteAllSounds = function () {
    console.log(preloader.sounds);
    for (var key in preloader.sounds) {
      preloader.sounds[key].mute(false);
    }
  };
  this.toggleSound = function () {
    _this.isSound = !_this.isSound;
    _this.dbSet("sound", _this.isSound ? "1" : "0");
    if (_this.isSound) _this.unmuteAllSounds();
    else _this.muteAllSounds();
  };
  this.isSoundPlaying = function (soundName) {
    return preloader.sounds[soundName].playing();
  };
  this.init(_appName, manifest, _onLoadingComplete, _props);

  this.IsFullScreenSupported = function () {
    var body = document.body;
    return !!(
      body.webkitRequestFullscreen ||
      (body.mozRequestFullScreen && doc.mozFullScreenEnabled) ||
      (body.msRequestFullscreen && doc.msFullscreenEnabled) ||
      (body.requestFullscreen && doc.fullscreenEnabled)
    );
  };
  this.IsFullScreenActive = function () {
    return !!(
      (document.fullScreenElement && document.fullScreenElement !== null) ||
      document.mozFullScreen ||
      document.webkitIsFullScreen
    );
  };
  this.SetFullScreen = function (el) {
    if (el.webkitRequestFullscreen) {
      el.webkitRequestFullscreen();
    } else if (el.mozRequestFullScreen) {
      el.mozRequestFullScreen();
    } else if (el.msRequestFullscreen) {
      el.msRequestFullscreen();
    } else if (el.requestFullscreen) {
      el.requestFullscreen();
    }
  };
  this.ExitFullScreen = function () {
    if (document.webkitCancelFullScreen) {
      document.webkitCancelFullScreen();
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
    } else if (document.msExitFullscreen) {
      document.msExitFullscreen();
    } else if (document.exitFullscreen) {
      document.exitFullscreen();
    }
  };
  this.ToggleFullScreen = function (el) {
    if (this.IsFullScreenActive()) {
      this.ExitFullScreen();
    } else {
      this.SetFullScreen(el);
    }
  };
}

GameService.ORIENTATION = {
  Landscape: "Landscape",
  Portrait: "Portrait",
  Both: "Both",
};

function Timer(_callback, _delay) {
  var _this = this;
  var delay = _delay;
  var callback = _callback;
  this.remaining = delay;
  this.timerId;
  this.start;
  this.isFinished = false;

  this.callback = function () {
    _this.isFinished = true;
    if (typeof callback == "function") callback();
  };

  this.pause = function () {
    window.clearTimeout(_this.timerId);
    _this.remaining -= new Date() - _this.start;
  };

  this.resume = function () {
    if (_this.isFinished) return;
    _this.start = new Date();
    window.clearTimeout(_this.timerId);
    _this.timerId = window.setTimeout(_this.callback, _this.remaining);
  };

  this.resume();
}

// Object to control the timeouts easily
Timeouts = {
  timeoutArr: [],
  add: function (func, time) {
    //console.warn("add timeout");
    var timeout = new Timer(function () {
      if (typeof func == "function") func();
      Timeouts.clear(timeout.timerId);
    }, time);
    Timeouts.timeoutArr.push(timeout);
    return timeout.timerId;
  },
  clear: function (id) {
    clearTimeout(id);
    Timeouts.timeoutArr.splice(Timeouts.timeoutArr.indexOf(id), 1);
  },
  clearAll: function () {
    for (var i = 0; i < Timeouts.timeoutArr.length; i++) {
      clearTimeout(Timeouts.timeoutArr[i].timerId);
    }
    Timeouts.timeoutArr.length = 0;
    //console.log("Timeouts cleared: " + Timeouts.timeoutArr.length);
  },
  pause: function (id) {
    for (var i = 0; i < Timeouts.timeoutArr.length; i++) {
      if (Timeouts.timeoutArr[i].timerId == id) Timeouts.timeoutArr[i].pause();
    }
  },
  resume: function (id) {
    for (var i = 0; i < Timeouts.timeoutArr.length; i++) {
      if (Timeouts.timeoutArr[i].timerId == id) Timeouts.timeoutArr[i].resume();
    }
  },
  pauseAll: function (id) {
    for (var i = 0; i < Timeouts.timeoutArr.length; i++) {
      Timeouts.timeoutArr[i].pause();
    }
  },
  resumeAll: function (id) {
    for (var i = 0; i < Timeouts.timeoutArr.length; i++) {
      Timeouts.timeoutArr[i].resume();
    }
  },
};

function animateMe(div_name, anim_name, duration, onComplete, delay) {
  if (delay) {
    setTimeout(function () {
      $(div_name)
        .show()
        .addClass("animated " + anim_name);
    }, delay);
  } else {
    $(div_name)
      .show()
      .addClass("animated " + anim_name);
  }
  if (duration == null || duration <= 0) {
    duration = parseFloat($(div_name).css("animation-duration")) * 1000;
  }
  //console.log("animation duration: " + duration);
  $(div_name).css("-webkit-animation-duration", duration / 1000 + "s");
  $(div_name).css("animation-duration", duration / 1000 + "s");
  setTimeout(function () {
    $(div_name).removeClass("animated " + anim_name);
    if (typeof onComplete == "function") {
      onComplete(div_name);
    }
  }, duration);
}

function animateMultiple(divsArr, anim_name, duration, delay, onComplete) {
  for (var i = 1; i <= divsArr.length; i++) {
    if (i == divsArr.length) {
      animateMe(divsArr[i - 1], anim_name, duration, onComplete, delay * i);
    } else {
      animateMe(divsArr[i - 1], anim_name, duration, null, delay * i);
    }
  }
}

var Loader = {
  isLoading: false,
  show: function () {
    $("#Loader").show();
    this.isLoading = true;
  },
  hide: function () {
    $("#Loader").hide();
    this.isLoading = false;
  },
};

var AnimateCss = {
  AnimateWithDelay: function (
    element,
    animationName,
    duration,
    onComplete,
    saveAnimatedState,
    delay
  ) {
    if (delay == null || typeof delay == "undefined" || delay < 0) {
      this.Animate(
        element,
        animationName,
        duration,
        onComplete,
        saveAnimatedState
      );
    } else {
      setTimeout(
        function (_this) {
          _this.Animate(
            element,
            animationName,
            duration,
            onComplete,
            saveAnimatedState
          );
        },
        delay,
        this
      );
    }
  },
  Animate: function (
    element,
    animationName,
    duration,
    onComplete,
    saveAnimatedState
  ) {
    saveAnimatedState = saveAnimatedState === true;
    $(element).addClass("animated " + animationName);
    if (duration == null || duration <= 0)
      duration = parseFloat($(element).css("animation-duration")) * 1000;

    //console.log("animation duration: " + duration);
    $(element).css("-webkit-animation-duration", duration / 1000 + "s");
    $(element).css("animation-duration", duration / 1000 + "s");
    setTimeout(function () {
      //$(element).removeClass("animated");
      if (!saveAnimatedState)
        $(element).removeClass("animated " + animationName);
      if (typeof onComplete == "function") {
        onComplete(element);
      }
    }, duration);
  },
};
