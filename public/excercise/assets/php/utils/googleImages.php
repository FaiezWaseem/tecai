<?php

//   echo json_encode(getGoogleImages($_GET['q'])) ;
  echo json_encode(getGoogleImagesLarge($_GET['q'])) ;
//   echo json_encode(getBingImages($_GET['q'])) ;
//   echo json_encode(getWallpaper($_GET['q'])) ;



 function getGoogleImages($______CREATOR______FAIEZ___){
    $url = 'http://images.google.com/images?q='.urlencode($______CREATOR______FAIEZ___);
    $html = file_get_contents($url);
    $pattern = '/<img[^>]+src\s*=\s*["\']([^"\']+)["\'][^>]*>/i';
    preg_match_all($pattern, $html, $matches);
    return ($matches[1]);
 }
 function getGoogleImagesLarge($______CREATOR______FAIEZ___){
    $url = 'https://www.google.com/search?q=kids+background&sca_esv=585026838&tbm=isch&sxsrf=AM9HkKkXWLs3Rxxt-laDrO9be5Nhw-KTig:1700824045179&source=lnms&sa=X&ved=2ahUKEwj67aaov9yCAxUXSfEDHSVPCCIQ_AUoAXoECAMQAw&biw=1280&bih=613&dpr=1.5';
    $html = file_get_contents($url);
    $pattern = '/<img[^>]+src\s*=\s*["\']([^"\']+)["\'][^>]*>/i';
    preg_match_all($pattern, $html, $matches);
    return ($matches[1]);
 }
 function getBingImages($______CREATOR______FAIEZ___){
    $url = 'https://www.bing.com/images/search?q='.urlencode($______CREATOR______FAIEZ___).'&scope=images';
    $html = file_get_contents($url);
    $pattern = '/<img[^>]+src\s*=\s*["\']([^"\']+)["\'][^>]*>/i';
    preg_match_all($pattern, $html, $matches);
    
    $validUrls = array_filter($matches[1], function($url) {
      return filter_var($url, FILTER_VALIDATE_URL) !== false;
    });
    return ($validUrls);
 }
 function getWallpaper($______CREATOR______FAIEZ___){
    $url = 'https://wallpapercave.com/childrens-wallpapers';
    $html = file_get_contents($url);
    $pattern = '/<img[^>]+src\s*=\s*["\']([^"\']+)["\'][^>]*>/i';
    preg_match_all($pattern, $html, $matches);
    return ($matches[1]);
 }
