jQuery(document).ready(function($){


  $('.featured-carousel').owlCarousel({
    loop:true,
    margin:10,
    navigation:true,
    navigationText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
    items: 4,
    itemsDesktop: [1200,3],
    itemsDesktopSmall: [1024,2],
    itemsTablet: [767,1],
  });

    //===================================
    // DESKTOP REDESIGN 06/20
    //===================================
    window.sr = ScrollReveal();

    if (document.body.classList.contains('home')) {

        window.sr = ScrollReveal({
            duration: 1000,
            scale: 1,
            origin: 'bottom',
            distance: '150px',
            easing: 'cubic-bezier(0.5, 1.10, 0.4, 1.19)',
            viewFactor: .65,
            mobile: false

        });

        sr.reveal('.fly-in-left', {
            mobile: false,
            origin: 'left',
            duration: 700,
            viewFactor: .65,
            distance: '150px'
        });

        sr.reveal('.fly-in-right', {
            mobile: false,
            origin: 'right',
            duration: 700,
            viewFactor: .65,
            distance: '150px'
        });

        sr.reveal('.fly-in-bottom', {
            mobile: false,
            origin: 'bottom',
            duration: 700,
            viewFactor: .65,
            distance: '150px'
        });
    }


    //grab all elements that have the .ux-loading-item class
      var uxElements = $('.lazy-loading');

      $(window).bind("load", function() {
          //grab all elements that have the .ux-loading-item class
          var uxElements = $('.lazy-loading');

          //run through the uxElements object array
          if (uxElements) { //run through the uxElements object array
              uxElements.each(function(index) {
                  //make instances of each one - this
                  var Element = $(this);
                  //run a time out and add class of active and multiply the delay times the position it is in the object
                  setTimeout(function() {
                      Element.addClass('active');
                  }, 400 * index);
              });
          }
      });


    $('[rel=popover]').popover({
      html:true,
      placement:'bottom',
      content:function(){
        return $('.savingsDetailsList').html();
        //return $($(this).data('contentwrapper')).html();
      }
    });

    var windowHeight = jQuery(window).height();

    $('.dealersnav ul.sub-menu').css('max-height','400px');

    if( windowHeight <= 600 )
    {
      var newHeight = windowHeight - 200;
      $('.dealersnav ul.sub-menu').css('max-height','200px');
    }


    isSmallMobile = {
      any: function() {
        return $(window).width() < 767;
      }
    };

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

    if(isSmallMobile.any()) {
      $('.gallery a.large-img').removeClass('fancybox');
      $('#gallerycarousel').find('a').removeClass('fancybox').click(function(e) {
        e.preventDefault();
        $('.gallery').find('a.large-img').attr('href', $(this).attr('href'));
        $('.gallery').find('a.large-img img').attr('src', $(this).attr('href'));
      });

      $('#gallerycarousel').touchwipe({
        wipeLeft: function() {
          $('#gallerycarousel').jcarousel('next');
          jQuery('.carousel').tooltip('close');
        },
        wipeRight: function() {
          $('#gallerycarousel').jcarousel('prev');
          jQuery('.carousel').tooltip('close');
        }
      });

      $('.carousel').tooltip({
        content: 'Swipe Left/Right to Scroll Gallery!',
        position: { my: "center", at: "center"}
      });
    }


  $("body").on('homepage-usp-hidden', function() {
    $("#search-overlay .overlay-content").html("");
  });

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

  /*
    //  BASIC PARALAX SCRIPT - for homepage on larger screens
    if( $(window).width() > 1199 ) {

      var s;
      setTimeout( function() {
        s = skrollr.init({forceHeight: false});
      }, 500);


      var $paralaxItems = $(this).find('.paralax');
      $window = $(window);
      var scrollTop, animatedImageOffset,distance,windowBottom;

      $(window).scroll(function() {
        $paralaxItems.each( function(i) {
          $bgobj = $(this);
          var yPos = -($window.scrollTop() / $bgobj.data('speed'));
          var paddingTop = 0;
          var marginTop = 0;

          if( $bgobj.data('padding-top') )
          paddingTop = $bgobj.data('padding-top');
          yPos += paddingTop;
          var paralaxID = $(this).attr('id');
          var coords = '50% '+ yPos + 'px';
          $bgobj.css({ backgroundPosition: coords });
        });
      });

    }
    else
    {
      jQuery('.animateImage').attr( 'data-900' , '0px' );
      jQuery('.animateImage').attr( 'data-1500' , '0px' );
      jQuery('.cpocontent').attr( 'data-900' , '0px' );
      jQuery('.cpocontent').attr( 'data-1500' , '0px' );
    }

    */


  //  END BASIC PARALAX SCRIPT

  //var headerwrapHeight = jQuery('.headerwrap').css( 'height' );

      function closeMenuOverlay() {
          $("#menu-overlay").removeClass("open");
      }

      function closeToolbarOverlays() {
        $('.toolbar-overlays.open').removeClass("open");
      }

      $(".menu-toggle").click(function() {
          if(typeof hj === "function") {
              hj('trigger', 'menu');
          } else {
              console.log("No Hotjar found.");
          }

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
    $("body").live("vrp-ajax-complete",function(){
      if($("#menu-overlay").hasClass("open"))
      $("#menu-close").trigger("click");
    });

    /*
    $( window ).scroll(function() {
      var scrollTop = $(window).scrollTop();

      //if( !theme.is_vdp ){
      if( scrollTop >= 200 )
      {
        $('#mini-header').addClass('open');
      }
      else
      {
        $('#mini-header').removeClass('open');
      }
      //}

    });
    */

    setTimeout(function(){
      var featuredvehicles =  jQuery("#featuredCarousel").owlCarousel({
        autoPlay: false,
        navigation: true,
        items : 4,
        itemsDesktop : [1399,3],
        itemsDesktopSmall: [1199,2],
        itemsTablet: [1024,2]
      });
    });

    setTimeout(function(){
      var reviewcarousel =  jQuery("#review-carousel").owlCarousel({
        autoPlay: false,
        navigation: true,
        items : 3,
        itemsDesktop : [1399,3],
        itemsDesktopSmall: [1199,2],
        itemsTablet: [1024,2]
      });
    });

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

      // Rotate through Smart and Sprinter logos in header
      var rotatingImgs = $("#header-top .rotating-logos img");
      var rotateMenuImgs = $("#menu-overlay .rotating-logos img");
      var imgI = 0;
      rotateLogos();
      var logoRotation = setInterval(rotateLogos, 3000);

      function rotateLogos() {
          $(rotatingImgs).removeClass("showing");
          $(rotateMenuImgs).removeClass("showing");
          $(rotatingImgs).eq(imgI).addClass("showing");
          $(rotateMenuImgs).eq(imgI).addClass("showing");

          if(imgI == (rotatingImgs.length - 1)) {
              imgI = 0;
          } else {
              imgI++;
          }
      }

      /*
      $( window ).scroll(function() {
          var scrollTop = $(window).scrollTop();
          if( scrollTop >= 10 )
          {
              $('#header').addClass('darken');
              $('#searchtoggle').addClass('minimized');
          }
          else
          {
              $('#header').removeClass('darken');
              $('#searchtoggle').removeClass('minimized');
          }

      });
      */

      $("#searchtoggle").click(function(){
          $("#searchbox").toggleClass("open");
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

    /* Added 10-08-2015: Change phone number on mobile only */
    if(isSmallMobile.any()) {
      $('.close-mobile-wrap').prependTo($('.close-mobile-wrap').parent());

      $('body').click(function(e) {
        var clicked = e.target;
        if( $(clicked).parents("#sidr").length )
          return true;
        else
              $('.close-mobile-wrap').trigger("click");
      });

    }

    //
    //  Custom landing page JS
    //
    if($('.inventory-owl #results-page').length > 0) {
      $('body').live('vrp-ready vrp-ajax-complete', function() {
        $('.vehicle').each(function(i, obj) {
          var btn = $(this).find('.primary-cta');
          var location = $(this).find('.vehicle-price');
          $(btn).appendTo(location).find(".button-form").addClass("block green");
        });
      });
    }

    //
    //  VRP Custom Scripts
    //
    if(isVRP.any()) {
      jQuery('body').on('vrp-ready vrp-ajax-complete', function() {
        if($(document).width() < 768 && $('.show-filters-button').length == 0) {
          var sort = $('.sorting-options');
          $(sort).removeClass("hidden-xs hidden-phone").append("<a trid='e1eec35a07604955989925' trc class='button primary-button show-filters-button align-left' style='margin:0'>Filter Results</a>").find('select').css({width:"40%"});
          $('.show-filters-button').click(function(e) {
            $('.mobile-tab-1 .mobile-tab-label').trigger('click');
          });
        }
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

      if ($(window).width() < 768) {
          $('img#pink-ribbon-oct:eq(1)').appendTo('.menu-top .logo');
          $('img#pink-ribbon-oct').css('display','inline');
      }

    //Move custom CTA for G-Class & GT models
    if ($('body').hasClass('page-vehicle-display-page')) {
      $('div#inquire-button').insertAfter('.maincta-row.ctabox-row');
      $('div#inquire-button a').css('display', 'block');
    }

});
