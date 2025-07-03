jQuery(document).ready(function($) {
// *************************************************************************************************
//  UTILITY
// *************************************************************************************************
  var windowHeight = window.outerWidth;

  isSmallMobile = {
    any: function() {
      return window.outerWidth < 767;
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
// *************************************************************************************************
//  GLOBAL
// *************************************************************************************************
  $('[rel=popover]').popover({
    html: true,
    placement: 'bottom',
    content: function() {
      return $('.savingsDetailsList').html();
    }
  });
  // FD#15103
  $('#save-vehicles-custom-toggle').click(function() {
    $('#save-vehicles-expand-btn').trigger('click');
  });
  // END FD#15103

  $('.dealersnav ul.sub-menu').css('max-height', '400px');
  if (windowHeight <= 600) {
    var newHeight = windowHeight - 200;
    $('.dealersnav ul.sub-menu').css('max-height', '200px');
  }
  //  Fix Mix Panel "resume" intention with hrefs using leading "#"
  $('[href="#"]').attr("href", "javascript:void(0)");


  $("body").on('homepage-usp-hidden', function() {
    $("#search-overlay .overlay-content").html("");
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

  //  Clicking outside of the mobile side menu closes it
  $('#footer, #videobanner, .menu-top').click(function() {
    $.sidr('close', 'mobile-menu');
  });

  $(".dayOW").appendTo(".dealer-hours span.department");

  //Pink Ribbon - Removed from DITM
  //var pinkRibbon = $(
  //  '<img class="pink-ribbon-oct" src="https://di-uploads-pod3.dealerinspire.com/fletcherjonesmbnewport/uploads/2017/10/pink-ribbon-e1508247273304.png" alt="Breast Cancer Awareness Month">'
  //);
  //pinkRibbon.appendTo(".logo");
  //if ($(window).width() < 768) {
  //  pinkRibbon.appendTo(".mobile-header-top .logo");
  // }
  
      // START -> HEADER MENU TOGGLE
      $('#menu-toggle').on('click', function () {
        $('#menu-toggle').toggleClass('active');
        if(jQuery(window).width() <= 1024){
          $('#whitewrap, body.stacks-enabled .di-stacks--top').toggleClass('open-menu');
        }
      });
      // END -> HEADER MENU TOGGLE

// *************************************************************************************************
//  INNER PAGES
// *************************************************************************************************
  $('li.difo-wallet.difo-wallet-btn-container').addClass('visible-xs');

  // JS for custom service/parts coupon template disclaimer
  $('.specialCoupon .view-disclaimer-link').on('click', function(e) {
    var disclaimer = $(this).parents('.specialCoupon').find('.disclaimer');
    $(disclaimer).addClass('open');
  });
  $('.specialCoupon .disclaimer .fa-close').on('click', function(e) {
    $(this).parents('.disclaimer').removeClass("open");
  });
  $("#c-class-countdown .c-class-countdown-close").click(function() {
    $(this).parent().toggleClass("close");
    $(".c-class-countdown-sm").toggleClass("inactive");
  });
  $(".c-class-countdown-sm").click(function() {
    $(this).toggleClass("inactive");
    $("#c-class-countdown").toggleClass("close");
  });
  //locked pricing
  function getCookie(name) {
    var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    if (match) return match[2];
  }
  if( getCookie('vrp-form') == 'visited' ){
    $("body").addClass("locked-pricing-price-unlocked");
  }
// *************************************************************************************************
//  VEHICLE RESULTS PAGE
// *************************************************************************************************

  $('#vrp-custom-filter').click(function(e) {
      e.preventDefault();
    $('.mobile-tabs.mobile-tabs-count-4 .mobile-tab-1').show();
    $('.mobile-tab.filter .mobile-tab-label').trigger('click');
  });

  jQuery('body').on('vrp-ajax-complete vrp-ready', function() {

    $('.vehicle').each(function(){
      var gylon = $(this).find('#lease-for-less-cta');

      var getEpriceCta = $(this).find('#get-eprice-cta');

      var gylonForm = $(this).find('.mock-gylon a');

      var epriceForm = $(this).find('.eprice-mock a');

      $(gylon).click(function (e) {
        $(gylonForm).click();
      });

      $(getEpriceCta).click(function (e) {
        $(epriceForm).click();
      });

    });

  });

  var l_vrp_inv = setInterval(function(){
    if( typeof window.l_vrp_did_change !== 'undefined' ){
      clearInterval(l_vrp_inv);
      if( window.l_vrp_did_change ){
        window.l_vrp_did_change = false;
      //  $("#lightning-vehiclefinder").modal('show');
      //  $("#lightning-vehiclefinder").removeClass('hidden');
      }

    }
  },500);

  $(document).on('click','#lvrp-vehicle-finder-image',function(e){
    $("#lightning-vehiclefinder").modal('show');
    $("#lightning-vehiclefinder").removeClass('hidden');
  });

  if( $(".inventory-owl").length ){
    setTimeout(function(){
      data =  $(".inventory-owl .grid-view-results-wrapper").data("owlCarousel");
      console.log("this is things");
      console.log();
      if( data ){
        $(".inventory-owl .vehicle").matchHeight();
      }
    },3000);
  }

// *************************************************************************************************
//  VEHICLE DETAILS PAGE
// *************************************************************************************************
  if (isVDP.hotwheels()) {
    $('body').on('click', "#ctabox-premium-features .features-link", function(e) {
      $("#factory_options .panel-title a").trigger("click");
    });
    $('#mini-header').css("display", "none");
    $('.details-page-titlewrap .details-page-row').removeClass("no-spacer");

    $('.cta-caption > p:first').insertAfter(".disclaimer-small > p:first");

    $(".panel-title a").not(".collapsed").addClass('collapsed').parents('.panel').find('.panel-collapse').removeClass('in');
    $(window).resize();
    
  }
  if($("body.page-vehicle-display-page").length){
    $('.vdp-third-party-shopping-tools .move-to-ctabox').insertAfter(".ctabox-inner .vehicle-records");
  }
  if($("body.page-vehicle-display-page").length && (window.outerWidth < 768) && $(".maincta-row .cta-button").length > 0){

    var mainCta = $('.maincta-row .cta-button'),
    distance = $(mainCta).offset().top,
    $window = $(window);

    $(window).scroll(function(){
      if ( ( $window.scrollTop() + 115) >= distance ) {
        $(mainCta).addClass('fixed-top');
      }
      else{
        $(mainCta).removeClass('fixed-top');
      }
    });  
  }


  //CTABOX PREMIUM OPTIONS
  $('#ctabox-premium-features .features-link').click(function() {
    $(this).parent().toggleClass('open');
  });
  //Move custom CTA for G-Class & GT models
  if ($('body').hasClass('page-vehicle-display-page')) {
    $('div#inquire-button').insertAfter('.maincta-row.ctabox-row');
    $('div#inquire-button a').css('display', 'block');

    if($('.details-page-gallerywrap .carfax-report').length){
      $('.carfax-report').wrap("<div class='cpo-carfax d-inline-block'></div>");

      var interval   = setInterval( updateOrder, 100 );
      var waitFor    = $(".below-gallery-shopping-tool");
      var wait_count = 0;
      var max_wait   = 5000;

      function updateOrder() {
          if ( $( waitFor ).length > 0 && wait_count < max_wait ) {
              waitFor.appendTo($('.cpo-carfax'));
              clearInterval(interval);
          }

          wait_count += 100;
      }
    }
  }
// *************************************************************************************************
//  MOBILE
// *************************************************************************************************
  if (isSmallMobile.any()) {
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
      position: {
        my: "center",
        at: "center"
      }
    });
  }

  if (window.outerWidth < 768) {
    if (isMobile.iOS())
      $('.fj-drive .android').hide();
    else
      $(".fj-drive .iOS").hide();
  }

  // *************************************************************************************************
  //  MOBILE MENUS
  // *************************************************************************************************

  // if ($(window).width() <= 768) {
  //   // Hours modal
  //   $('#menu-mobile-footer-menu .menu-hours a, a.hours-modal').attr({"data-toggle":"modal", "data-target":"#DIModal", "data-modal-content":"#mobileHours", "data-modal-class":"hours-modal", "data-modal-title":""});

  //   var str = document.getElementById("dealerHours").innerHTML;
  //   var res = str.replace(/Hours:/g, "");
  //   document.getElementById("dealerHours").innerHTML = res;

  // }

    //===================================
    // DESKTOP REDESIGN 06/20
    //===================================
    window.sr = ScrollReveal();

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
        viewFactor: 0.65,
        distance: '150px'
    });

    //grab all elements that have the .ux-loading-item class
    var uxElements = $('.lazy-loading');

    //run through the uxElements object array
    uxElements.each(function(index) {
        //make instances of each one - this
        var uiElement = $(this);

        //run a time out and add class of active and multiply the delay times the position it is in the object
        setTimeout(function() {
            uiElement.addClass('active');
        }, 350 * index);

    });

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

    //New Vehicle Sub-Menu Hybrid
    $('#eqe-suv-hidden').removeClass('hidden');
    $('#eqe-suv-show').addClass('hidden');


});
