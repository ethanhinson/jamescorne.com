/**
 * Here goes all the JS Code you need in your child theme buddy!
 */
(function($) {
    //Init stuff and helper functions
    var screenRes = $(window).width();
    var state     = $.cookie('viewingContent');
    //If viewing content, always hide office at first.
    if(state == 1) {
        $('#zoom-wrap').hide();
    }
    //Setup Screen Context variables
    if(screenRes > 1024) {
        $.cookie('deviceContext', 'desktop');
    } else if( screenRes < 1025 && screenRes >480 ) {
        $.cookie('deviceContext', 'tablet');
    } else {
        $.cookie('deviceContext', 'mobile');
    }
    //Helper to calculate the margins around the office image
    function positionOffice() {
      var vh = $(window).height();
      var ih = $('.office-bg').outerHeight();
      var zm = ( vh - ih ) / 2;
      $('#zoom-wrap').css({ 'max-height' : vh });
      $('.office-bg').css({ 'margin-top' : zm, 'margin-bottom' : zm });
    }
    
    //Hide scrolling when the office is arounc
    
    function hideScroll() {
        var office = $('#zoom-wrap');
        if($(office).is(':visible')) {
            $('body').css({'overflow' : 'hidden'});
        } else {
            $('body').css({'overflow' : 'auto'}); 
        }
    }
    
    //Build a Tooltip
    
    function buildToolTip(elem) {
        if( !$(elem).hasClass('zoomNotClickable') ) {
            var t = $(elem).attr('data-tool');
             $(elem).append('<div id="tooltip-element">' + t + '</div>');  
        } else {
             $(elem).children('div#tooltip-element').fadeOut('fast').remove();
        }
    }
    
    /**
     * Position the office elements
     */
    
    $(window).load(function() {
      positionOffice();
      hideScroll();
    });
        
    $(window).resize(function() { 
        positionOffice();
        if($(window).width()  < 1024 ) {
       		$('#zoom-wrap').fadeOut('fast');
       		$('.office-toggle').fadeOut('fast');
       		$.cookie('viewingContent', 1);
        }
        if( $(window).width() > 1023 ) {
        	$('.office-toggle').fadeIn('fast');
        }
        hideScroll();
    });
    
    
    /**
     * Toggle the Office
     */
    
   $('.office-toggle a').click(function(){
      //Is the user closing the office space?
      var c = $(this).parent('li').hasClass('close');
      //If so, set a cookie so that it doesn't reappear on the next page
      if(c) {
          $.cookie('viewingContent', 1);
      } else {
          //Else remove the cookie
          $.removeCookie('viewingContent');
      }
      //Fade office in/out and reposition it
      $('#zoom-wrap').fadeToggle( 'fast', 'swing', positionOffice() );
      hideScroll();
      return false;
   });
   
   /**
    * Mouse handlers for tool tip
    * 
    */
   
        $('.zoomTarget').click(function(){
         //Remove the appended tooltip template
            $(this).children('div#tooltip-element').fadeOut('fast').remove();           
        });
   
        $('.zoomTarget').mouseover(function(e){
            //Creates markup
            buildToolTip(this);
            //Set the X and Y axis of the tooltip
            console.log(e);
            $('#tooltip-element').css('top', e.offsetY + 10 );
            $('#tooltip-element').css('left', e.offsetX + 20 );

            //Show the tooltip with faceIn effect
            $('#tooltip-element').fadeIn('500');
            $('#tooltip-element').fadeTo('10',0.8);
            
            return false;

        }).mousemove(function(e) {

            //Keep changing the X and Y axis for the tooltip, thus, the tooltip move along with the mouse
            $('#tooltip-element').css('top', e.offsetY + 10 );
            $('#tooltip-element').css('left', e.offsetX + 20 );

            return false;

        }).mouseout(function() {

        //Remove the appended tooltip template
            $(this).children('div#tooltip-element').fadeOut('fast').remove();
        });  

}(jQuery));