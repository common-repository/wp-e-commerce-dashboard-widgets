// debouncing function from John Hann
// http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/

(function($,sr){
 
  var debounce = function (func, threshold, execAsap) {
      var timeout;
 
      return function debounced () {
          var obj = this, args = arguments;
          function delayed () {
              if (!execAsap)
                  func.apply(obj, args);
              timeout = null; 
          };
 
          if (timeout)
              clearTimeout(timeout);
          else if (execAsap)
              func.apply(obj, args);
 
          timeout = setTimeout(delayed, threshold || 75); 
      };
  }
	// smartresize 
	jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };
 
})(jQuery,'smartresize');


// Custom resize function - Lee Willis

function ses_wpscd_resize(element){

	// First get the stored width & height
	var widthheightarray, width, height, newwidth, newheight;

	var currentclass = jQuery(element).attr('class');

	if (currentclass) {
		widthheightarray = currentclass.split('x');
		width = widthheightarray[0];
		height = widthheightarray[1];
	} else {
		width = 0;
		height = 0;
	}
		
	// Get new width & height
			
	newwidth = jQuery(element).width();
	newheight = jQuery(element).height();
	if (newheight < 250) {
		newheight=250;
	}

	if (newwidth != width || newheight != height) {
		jQuery(element).children("img").attr('src','admin-ajax.php?action='+jQuery(element).attr('id')+'&x='+newwidth+'&y='+newheight);
		jQuery(element).attr('class',newwidth+'x'+newheight);
	}
}
