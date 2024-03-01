// Example usage:
const getParameterValue = (parameterName) => {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(parameterName);
};
const mathJaxPath = getParameterValue("mathjaxpath");
const isOfflineLmsPath = getParameterValue("is_offline_lms");

const isOffline = isOfflineLmsPath === "1" ? "1" : 0;
const link =
  isOffline === "1"
    ? mathJaxPath
    : "https://cdn.jsdelivr.net/npm/mathjax@2.7.8/MathJax.js";

const convert = (ele) => {
  try {
    window.MathJax.Hub.Queue(["Typeset", window.MathJax.Hub, ele]);
  } catch (e) {
    // console.log(e);
  }
};

const load = (callback) => {
  try {
    if (!window.MathJax) {
      const [head] = document.getElementsByTagName("head");
      const script = document.createElement("script");
      script.type = "text/javascript";
      script.src = link;
      script.onload = () => {
        if (window.MathJax && callback) callback();
      };
      head.appendChild(script);
    }
  } catch (e) {
    // console.log(e);
  }
};

const mathJax = {
  load,
  convert,
};

// Use the mathJax object and its functions as needed
mathJax.load(() => {
  console.log("MathJax script loaded!");
  // Do something after MathJax script is loaded
});

// Call other functions or work with variables from the file
convert(document.getElementById("myElement"));
