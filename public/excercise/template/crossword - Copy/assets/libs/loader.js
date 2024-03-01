function LoaderJS() {
  this.assets = {};

  this.whenReady = undefined;
  this.whileLoading = undefined;

  this.resCount = 0;
  this.loaded = false;
  this.timer = -1;
}

/**
 * @method _increaseCount()
 * @private
 * progression callback
 */
LoaderJS.prototype._loading = function () {
  if (this.whileLoading) {
    clearInterval(this.timer);
    this.timer = window.setInterval(() => {
      if (this.resCount > 0) {
        this.whileLoading();
      } else {
        window.clearInterval(this.timer);
        this.timer = null;
      }
    }, 100);
  }
};

/**
 * @method _increaseCount()
 * @private
 */
LoaderJS.prototype._increaseCount = function () {
  this.resCount++;
};
/**
 * @method _validateResponse()
 * @private
 * @param {Response} res
 * checks for valid response
 */
LoaderJS.prototype._validateResponse = function (res) {
  if (!res.ok) {
    throw Error(res.statusText);
  }
  return res;
};

/**
 * @method _checkReady()
 * @private
 * keeps track of resource count and fire whenReady() callback when
 * all of the resources are loaded
 */
LoaderJS.prototype._checkReady = function () {
  if (this.resCount <= 0) this.loaded = true;
  if (this.resCount <= 0 && this.whenReady) {
    this.whenReady();
  }
};

/**
 * @method _add()
 * @param {String} name
 * @param {JSON|String|Blob} data
 * @private
 * adds the loaded data to the assets Array
 */
LoaderJS.prototype._add = function (name, data) {
  this.assets[name] = data;
  this.resCount--;
};

/**
 * @method loadImage()
 * @param {String} name
 * @param {String} file
 * loads image files as dom elements
 */
LoaderJS.prototype.loadImage = function (name, file) {
  this._increaseCount();
  let img = new Image();
  img.src = file;

  img.onload = () => {
    this._add(name, img);
    this._checkReady();
  };
  img.onerror = (err) => {
    console.error(err, "file - " + name + " , URL " + file);
    this._add(name, file);
    this._checkReady();
  };
};

/**
 * @method loadVideo()
 * @param {String} name
 * @param {String} file
 * @param {Headers} headers
 * loads Video files
 */
LoaderJS.prototype.loadVideo = function (name, file) {
  this._increaseCount();
  let video = document.createElement("video");
  video.autoplay = true;
  video.muted = true;
  video.loop = true;
  video.src = file;
  video.load();

  this._add(name, video);
  this._checkReady();
  video.play();
};

/**
 * @method loadMedia()
 * @param {String} name
 * @param {String} file
 * @param {Headers} headers
 * loads Audio, Video or media blobs
 */
LoaderJS.prototype.loadMedia = function (name, file, headers) {
  if (this.timer == -1) {
    this.whileLoading = true;
    this._loading();
  }
  this._increaseCount();

  if (file.indexOf("data:") > -1) {
    this.assets[name] = file;
    this.resCount--;
    this._checkReady();
    return;
  }
  if (file.indexOf("blob:") > -1) {
    this.assets[name] = file;
    this.resCount--;
    this._checkReady();
    return;
  }

  fetch(file, headers)
    // .then(res => this._validateResponse(res))
    .then((res) => res.blob())
    .then((data) => {
      this.assets[name] = URL.createObjectURL(data);
      this.resCount--;
      this._checkReady();
    })
    .catch((err) => {
      this.assets[name] = file;
      this.resCount--;
      this._checkReady();
      console.error(err, "file - " + name + " , URL " + file);
    });
};

/**
 * @method loadData()
 * @param {String} name
 * @param {String} file
 * @param {Headers} headers
 * loads Audio, Video or media blobs
 */
LoaderJS.prototype.loadData = function (name, file, headers) {
  var fileExt = file.toLowerCase().split(".");
  fileExt = fileExt[fileExt.length - 1];
  if (["mp3", "wav", "ogg"].indexOf(fileExt) > -1) {
    this.loadMedia(name, file, headers);
  } else if (["png", "jpg", "jpeg", "svg"].indexOf(fileExt) > -1) {
    this.loadMedia(name, file);
  } else if((file).indexOf('blob:') > -1){
    this.loadMedia(name, file);
  }
};
