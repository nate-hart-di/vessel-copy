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

        console.log("hello world")

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

	function closeMenuOverlay() {
		$("#menu-overlay").removeClass("open");
	}
	
	function closeToolbarOverlays() {
  	$('.toolbar-overlays.open').removeClass("open");
	}

	$(".menu-toggle").click(function(){
    // if(typeof("hj") != "undefined") {
    //   hj('trigger', 'menu');
    // } else {
    //   console.log("No Hotjar found.");
    // }
      
		$("#menu-overlay").toggleClass("open");
	});
	$("#menu-close").click(function(){
		closeMenuOverlay();
	});
	
	$('body').click(function(e) {
    var clicked = e.target;
    if( $(clicked).parents("#menu-overlay").length || $(clicked).parents('.menu-toggle').length )
      return true;
    else
  		closeMenuOverlay();
  		
    if($(clicked).parents(".overlay-container").length || $(clicked).hasClass("overlay-toggle") || $(clicked).parents(".overlay-toggle").length )
      return true;
    else
      closeToolbarOverlays();
  });
	
	$(window).keypress(function(e) {
		if(e.keyCode == 27 && $('#menu-overlay.open').length > 0) {
			closeMenuOverlay();
			closeToolbarOverlays();
		}
	});
	
    // JS for custom service/parts coupon template disclaimer
    $('.specialCoupon .view-disclaimer-link').on('click', function(e) {
    	var disclaimer = $(this).parents('.specialCoupon').find('.disclaimer');
    	$(disclaimer).addClass('open');
    });
    $('.specialCoupon .disclaimer .fa-close').on('click', function(e){
    	$(this).parents('.disclaimer').removeClass("open");
    });

    //close menu when using filters on VRP's
    $("body").live("vrp-ajax-complete", function() {
        if ($("#menu-overlay").hasClass("open"))
          closeMenuOverlay();
    });

    $(window).scroll(function() {
        var scrollTop = $(window).scrollTop();

        //if( !theme.is_vdp ){
        if (scrollTop >= 200) {
            $('#mini-header').addClass('open');
        } else {
            $('#mini-header').removeClass('open');
        }
        //}

    });
    
    var featuredvehicles = jQuery("#featuredCarousel").owlCarousel({
        autoPlay: false,
        navigation: true,
        items: 4,
        itemsDesktop: [1399, 3],
        itemsDesktopSmall: [1199, 2],
        itemsTablet: [1024, 2]
    });

    var reviewcarousel = jQuery("#review-carousel").owlCarousel({
        autoPlay: false,
        navigation: true,
        items: 3,
        itemsDesktop: [1399, 3],
        itemsDesktopSmall: [1199, 2],
        itemsTablet: [1024, 2]
    });

    $('a.scroll').click(function() {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 1000);
                return false;
            }
        }
    });

    /* Added 10-08-2015: Change phone number on mobile */
    if(isSmallMobile.any() || $(document).width() < 768) {
      $('.close-mobile-wrap').prependTo($('.close-mobile-wrap').parent());
      
      $('body').click(function(e) {
        var clicked = e.target;
        if( $(clicked).parents("#sidr").length )
          return true;
        else
      		$('.close-mobile-wrap').trigger("click");
      });
    
      var phone_hypen = "808-664-5151";
      var phone_dot = "808.664.5151";
      var phone_raw = "8086645151";

      var phone_el = ['span.phone-sales','li.phone-sales', '.phone-main', '.call-us', '.mobile-tab-content-inside .phone'];
      $.each(phone_el, function(i, el){
        if( $(el).length && typeof $(el) != 'undefined' ){   
          var dealer_phone = $('body').find(el).html().replace(/((\(\d{3}\) ?)|(\d{3}-))?\d{3}-\d{4}/, phone_hypen); 
          $('body').find(el).html(dealer_phone);   
        }
      });

      $('a[href^="tel:"]').each(function(i, phone){   
        var phone_href = $(phone).attr('href').replace(/(?:\d{3}(?:\d{7}|(\-|\.)\d{3}(\-|\.)\d{4}))|(?:\(\d{3}\)(?:(\-|\.)\d{3}(\-|\.))|(?: \d{3} )\d{4})/, phone_raw); 
        $(phone).attr('href', phone_href);    
      });
    }

  isVRP = {
    listview: function() {
      return $('.vehicle.list-view').length ? true : false;
    },
    gridview: function() {
      return $('.vehicle.grid-view').length ? true : false;
    },
    any: function() {
      return $('#results-page').length ? true : false;
    }
  };
  
  isVDP = {
    wide1400: function() {
      return $('.maincardetails').length ? true : false;
    },
    hotwheels: function() {
      return $('.project-hotwheels').length ? true : false;
    },
    any: function() {
      return $('.vdpModals').length ? true : false;
    }
  };
  

  //
  //  Custom landing page JS
  //
  if($('.inventory-owl #results-page').length > 0) {
    $('body').live('vrp-ready vrp-ajax-complete', function() {
      $('.vehicle').each(function(i, obj) {
        var btn = $(this).find('.primary-cta');
        var location = $(this).find('.vehicle-price');
        $(btn).appendTo(location).find(".button-form").addClass("block green");
        $("<a trid='ef15cb670959458baaa053' trc href='/apply-for-financing/' class='button primary-button block'>Get Financing</a>").appendTo(location);
      });
    });
  }

  //
  //  Hotwheels Custom Scripts
  //
  if(isVDP.hotwheels()) {
    $(document).ready(function($) {
      $('#mini-header').css("display", "none");
      $('.details-page-titlewrap .details-page-row').removeClass("no-spacer");
  
      $('.cta-caption > p:first').insertAfter(".disclaimer-small > p:first");
      $('.shopping-tool.test-drive-cta .shopping-label .button-form').addClass("button primary-button block").appendTo('#details-page-ctabox div.test-drive-cta');
      
      $('#ctabox-premium-features').accordion({
    		collapsible: true,
    		header: "h4",
    		active: false,
    		icons: {
      		"header": "fa fa-angle-double-down",
      		"activeHeader": "fa fa-close"
    		},
    		create: function(e, ui) {
    		  $(window).resize();
    		}
  		});
  		$(".panel-title a").not(".collapsed").addClass('collapsed').parents('.panel').find('.panel-collapse').removeClass('in');
    });
  }

  if ($('body').hasClass('page-id-2313')) {
    $('a[href="/service/schedule-service/"]').text('Order Parts');
    $('a[href="/service/schedule-service/"]').attr('href','/parts/order-parts');
  }

  if($("body.home").length){
    setTimeout(function(){
      $("iframe").each(function(index) {
        if( $(this)[0].hasAttribute('data-src') ){
          $(this).attr('src',$(this).attr('data-src'));
        }
      });
    },2500);
  }

});