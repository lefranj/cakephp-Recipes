/*
 * jQuery viewportOffset - v0.1 - 2/3/2010
 * http://benalman.com/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */

(function($,window){
  '$:nomunge'; // Used by YUI compressor.
  
  var win;
  
  $.fn.viewportOffset = function() {
    var offset = $(this).offset();
    
    win = win || $(window);
    
    return {
      left: offset.left - win.scrollLeft(),
      top: offset.top - win.scrollTop()
    };
  };
  
})(jQuery,this);