function Preloader(_manifest, _onloadingComplete) {
    var _this = this;
    this.sounds = {};
    var preloaderDiv;
    this.onLoaderReady = null;
    var filesLoaded = 0;
    var filesToLoad = 0;
    var manifest = [];

    this.init = function (_manifest, _onloadingComplete) {
        _this.onLoaderReady = _onloadingComplete;
        $("#loader").addClass("main_container");
        $("#loaderBG").show();
        manifest = _manifest;
        filesLoaded = 0;
        filesToLoad = manifest.length;
        this.imagesArr = [];
        this.sounds = {};
        preloaderDiv = $("<div/>", {
            id: "preloader",
            style: "display:none;position:absolute;top:100000px;left:100000px;"
        }).appendTo(document.body);
        this.loadManifest();
    };

    this.loadManifest = function () {
        if (manifest.length == 0) {
            onFileLoaded(true);
        }
        for (var i = 0; i < manifest.length; i++) {
            var file = manifest[i].src.split("/");
            file = file[file.length - 1];
            var id = file.split(".")[0];
            var type = file.split(".")[1];
            var div = "";
            //console.log("i: " + i + " <> id: " + manifest[i].id + " <> file type: " + type);
            switch (type.toLowerCase()) {
                case "svg":
                case "png":
                case "jpg":
                case "jpeg":
                    div = $("<img src='" + manifest[i].src + "' alt=''>");
                    $(div).on("load error", onFileLoaded);
                    $(preloaderDiv).append(div);
                    break;
                case "mp3":
                case "ogg":
                case "wav":
                    _this.sounds[manifest[i].id] = new Howl({
                        src: [manifest[i].src],
                        autoplay: false,
                        preload: true,
                        loop: false,
                        volume: 1,
                        onload: onFileLoaded,
                        onerror: onFileLoaded
                    });
                    break;
            }
        }
    };

    onLoadingComplete = function () {
        setTimeout(function () {
            //console.log("loading complete!");
            $("#loader").hide();
            if (typeof _this.onLoaderReady == "function")
                _this.onLoaderReady();
        }, 50);
    };

    onFileLoaded = function (noFile) {
        if (noFile !== true)
            filesLoaded++;
        var percent = filesToLoad === 0 ? 100 : (filesLoaded / filesToLoad) * 100;
        //console.log("filesLoaded: ", filesLoaded);
        percent = Math.round(percent);
        _this.refreshLoader(percent);
        if (filesLoaded >= filesToLoad)
            onLoadingComplete();
    }

    this.refreshLoader = function (percent) {
        percent = Math.min(100, percent);
        //console.log("loading: " + percent);
        $("#loaderPercent").text(percent);
        $("#loaderBarFG").css("width", percent + "%");
    };

    this.init(_manifest, _onloadingComplete);
}