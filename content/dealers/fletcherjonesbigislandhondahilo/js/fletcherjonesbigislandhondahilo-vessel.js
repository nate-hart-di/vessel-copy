jQuery(document).ready(function($) {
	
    $('[rel=popover]').popover({
        html: true,
        placement: 'bottom',
        content: function() {
            return $('.savingsDetailsList').html();
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
  
      function closeMenuOverlay() {
          $("#menu-overlay").removeClass("open");
      }
      
      function closeToolbarOverlays() {
        $('.toolbar-overlays.open').removeClass("open");
      }
  
      $(".menu-toggle").click(function(){
        if(typeof("hj") == "undefined")
          hj('trigger', 'menu');
      else 
        console.log("No Hotjar found.");
      
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
            $("#menu-close").trigger("click");
    });
  
    $(window).scroll(function() {
        var scrollTop = $(window).scrollTop();
  
        if (scrollTop >= 200) {
            $('#mini-header').addClass('open');
        } else {
            $('#mini-header').removeClass('open');
        }
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
  
    if ($('.acf-map').length) {
        var dragFlag = false; 
        var start = 0,
            end = 0;
  
        function thisTouchStart(e) {
            dragFlag = true;
            start = e.touches[0].pageY;
        }
  
        function thisTouchEnd() {
            dragFlag = false;
        }
  
        function thisTouchMove(e) {
            if (!dragFlag) return;
            end = e.touches[0].pageY;
            window.scrollBy(0, (start - end));
        }
  
        document.querySelector(".acf-map").addEventListener("touchstart", thisTouchStart, true);
        document.querySelector(".acf-map").addEventListener("touchend", thisTouchEnd, true);
        document.querySelector(".acf-map").addEventListener("touchmove", thisTouchMove, true);
    }
  
    /* Added 10-08-2015: Change phone number on mobile */
    if(isSmallMobile.any() || $(window).width() < 768) {
      $('.close-mobile-wrap').prependTo($('.close-mobile-wrap').parent());
      
      $('body').click(function(e) {
        var clicked = e.target;
        if( $(clicked).parents("#sidr").length )
          return true;
        else
              $('.close-mobile-wrap').trigger("click");
      }).on("swipe", function(e) {
        $.sidr('close', 'sidr');
      });
  
      $('.phone, .sales-phone, .address').text("Choose a Location");
  
        $('a[href^="tel:"], .phone, .sales-phone').not('#mobile-phone-picker a').click(function(e) {
            e.preventDefault();
            $('#mobile-phone-picker').modal();
      });
        $('a[href*="maps.google"], .address').not('#mobile-directions-picker a').click(function(e) {
            e.preventDefault();
            $('#mobile-directions-picker').modal();
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
          $("<a trid='4e0cbdaac7924307ac2a82' trc href='/apply-for-financing/' class='button primary-button block'>Get Financing</a>").appendTo(location);
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
              }
            });
            $(".panel-title a").not(".collapsed").addClass('collapsed').parents('.panel').find('.panel-collapse').removeClass('in');
      });
    }
  
      if ($(window).width() < 768) {
          $('img#pink-ribbon-oct:eq(1)').appendTo('.menu-top .logo');
          $('img#pink-ribbon-oct').css('display','inline');
      }

      if ($('#count-number').html() == 0) {
        $('#vehicle-count-overview-number').hide();
      }
  
  });
  