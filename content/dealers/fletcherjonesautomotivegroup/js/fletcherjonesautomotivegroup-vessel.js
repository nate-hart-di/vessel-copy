var modfullOffset = 50;
jQuery(document).ready(function($) {
    $('[rel=popover]').popover({
        html: true,
        placement: 'bottom',
        content: function() {
            return $('.savingsDetailsList').html();
            //return $($(this).data('contentwrapper')).html();
        }
    });

    var windowHeight = jQuery(window).height();

    $('.dealersnav ul.sub-menu').css('max-height', '400px');

    if (windowHeight <= 600) {
        var newHeight = windowHeight - 200;
        $('.dealersnav ul.sub-menu').css('max-height', '200px');
    }

    isSmallMobile = {
        any: function() {
            return $(window).width() < 767;
        }
    };

    //  BASIC PARALAX SCRIPT - for homepage on larger screens
    if ($(window).width() > 1199) {
        var s;
        setTimeout(function() {
            s = skrollr.init({
                forceHeight: false
            });
        }, 500);

        var $paralaxItems = $(this).find('.paralax');
        $window = $(window);
        var scrollTop, animatedImageOffset, distance, windowBottom;

        $(window).scroll(function() {
            $paralaxItems.each(function(i) {
                $bgobj = $(this);
                var yPos = -($window.scrollTop() / $bgobj.data('speed'));
                var paddingTop = 0;
                var marginTop = 0;

                if ($bgobj.data('padding-top'))
                    paddingTop = $bgobj.data('padding-top');
                yPos += paddingTop;
                var paralaxID = $(this).attr('id');
                var coords = '50% ' + yPos + 'px';
                $bgobj.css({
                    backgroundPosition: coords
                });
            });
        });

    } else {
        jQuery('.animateImage').attr('data-900', '0px');
        jQuery('.animateImage').attr('data-1500', '0px');
        jQuery('.cpocontent').attr('data-900', '0px');
        jQuery('.cpocontent').attr('data-1500', '0px');
    }
    //  END BASIC PARALAX SCRIPT

    //var headerwrapHeight = jQuery('.headerwrap').css( 'height' );


	$('a.overlay-toggle').click(function(){
		$('a.overlay-toggle').removeClass('blue');
    	$('a.overlay-toggle').removeClass('active');
        $('.toolbar-overlays, #videooverlay').addClass("open");
        $('#intro-overlay').removeClass("open");
        $('.targetOverlay').hide();
        $(this).addClass('active');
        $('.inside-tabs, .back-button, .close-overlay').fadeIn();
        $('#'+$(this).attr('target')+"-overlay").fadeIn(1000).addClass("showTarget");
    });

	$(".close-overlay").click(function(){
		$('.inside-tabs, .close-overlay, .back-button').hide();
		$('.toolbar-overlays, #videooverlay').removeClass("open");
		$('a.overlay-toggle, a.california').removeClass('active');
		$('a.overlay-toggle').addClass('blue');
		$('#intro-overlay').addClass("open");
	});

	//Choosing an option
	$('.find-button').click(function(){
		$('.button-tabs, .targetDiv').hide();
		$('a.california').addClass('active');
		$(this).addClass('active');
		$('.inside-tabs, .back-button').fadeIn();
		$('#'+$(this).attr('target')+"-tab").fadeIn(1000).addClass("showTarget");
	});

	 //Back button
	 $(".back-button").click(function(){
		 $('.back-button').hide();
		 $('#californialocations-overlay').fadeIn(1000).addClass("showTarget");
		 $('#southcalifornia-overlay, #northcalifornia-overlay').hide();
	 });

	  // Smooth scroll to section anchors
	  $(function() {
		$('a.scroll').click(function() {
			if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
				var target = $(this.hash);
				target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
				if (target.length) {
					$('html,body').animate({
						scrollTop: target.offset().top
					}, 1000);
					return false;
				}
			}
		});
	});

    $('#desktop-menu-toggle').click(function(){
        if($(this).attr("data-gtm-event") == "desktopHeaderMenuOpen"){
            $(this).attr("data-gtm-event", "desktopHeaderMenuClose");
        } else {
            $(this).attr("data-gtm-event", "desktopHeaderMenuOpen");
        }
    });

  $('#desktop-locations-toggle, #mobile-locations-toggle').sidr({
    name: 'sidr-desktop-locations',
    side: 'right'
  });

  //$('#sidr-desktop-locations').off();
});
