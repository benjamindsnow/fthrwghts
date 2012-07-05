$(document).ready(function() {
  var userAgent = navigator.userAgent.toLowerCase();
  var browser = {
    version: (userAgent.match( /.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/ ) || [])[1],
    chrome: /chrome/.test( userAgent ),
    safari: /webkit/.test( userAgent ) && !/chrome/.test( userAgent ),
    opera: /opera/.test( userAgent ),
    msie: /msie/.test( userAgent ) && !/opera/.test( userAgent ),
    mozilla: /mozilla/.test(userAgent)&&!/(compatible|webkit)/.test(userAgent)
  };
  if(browser.msie || browser.opera)
     $('#stream').replaceWith("\<applet code='com.charliemouse.cambozola.Viewer' archive='cambozola.jar' name='Video Stream' id='stream'\>\<param name='url' value='http://dome.fthrwghts.com/mjpg/video.mjpg'/\>\</applet\>");
});