jQuery(document).ready(function($) {

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

  // *************************************************************************************************
  //  UTILITY
  // *************************************************************************************************
  var windowHeight = jQuery(window).height();

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

  isSmallMobile = {
    any: function() {
      return window.outerWidth < 767;
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

  $('.dealersnav ul.sub-menu').css('max-height', '400px');

  if (windowHeight <= 600) {
    var newHeight = windowHeight - 200;
    $('.dealersnav ul.sub-menu').css('max-height', '200px');
  }

  //  Fix Mix Panel "resume" intention with hrefs using leading "#"
  $('[href="#"]').attr("href", "javascript:void(0)");

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

  // JS for custom service/parts coupon template disclaimer
  $('.specialCoupon .view-disclaimer-link').on('click', function(e) {
    var disclaimer = $(this).parents('.specialCoupon').find('.disclaimer');
    $(disclaimer).addClass('open');
  });
  $('.specialCoupon .disclaimer .fa-close').on('click', function(e){
    $(this).parents('.disclaimer').removeClass("open");
  });

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

  if($(window).width() < 768) {
    if(isMobile.iOS())
      $('.fj-drive .android').hide();
    else
      $(".fj-drive .iOS").hide();
  }

  //  Clicking outside of the mobile side menu closes it
  $('#footer, #videobanner, .menu-top').click(function () {
    $.sidr('close', 'mobile-menu');
  });

  // *************************************************************************************************
  //  HEADER
  // *************************************************************************************************
  if($(window).width() > 1024) {
    // Rotate through Smart and Sprinter logos in header
    var rotatingImgs = $(".rotating-logos .showhim .main-nav img");
    //var rotateMenuImgs = $("#menu-overlay .rotating-logos img");
    var imgI = 0;
    rotateLogos();
    var logoRotation = setInterval(rotateLogos, 3000);

    function rotateLogos() {
      $(rotatingImgs).removeClass("showing");
      //$(rotateMenuImgs).removeClass("showing");
      $(rotatingImgs).eq(imgI).addClass("showing");
      //$(rotateMenuImgs).eq(imgI).addClass("showing");

      if(imgI == (rotatingImgs.length - 1)) {
        imgI = 0;
      } else {
        imgI++;
      }
    }
  }

  if($(window).width() < 1024) {
    // Rotate through Smart and Sprinter logos in header for tablet
    var rotatingImgsTablet = $(".rotating-logos-tablet img");
    //var rotateMenuImgs = $("#menu-overlay .rotating-logos img");
    var imgIt = 0;
    rotateLogosTablet();
    var logoRotationTablet = setInterval(rotateLogosTablet, 3000);

    function rotateLogosTablet() {
      $(rotatingImgsTablet).removeClass("showing");
      //$(rotateMenuImgs).removeClass("showing");
      $(rotatingImgsTablet).eq(imgIt).addClass("showing");
      //$(rotateMenuImgs).eq(imgI).addClass("showing");

      if(imgIt == (rotatingImgsTablet.length - 1)) {
        imgIt = 0;
      } else {
        imgIt++;
      }
    }
  }

  // Add day of week to header hours
  $(".dayOW").appendTo(".dealer-hours span.department");

  if ($('#count-number').html() == 0) {
    $('#vehicle-count-overview-number').hide();
  }
  // *************************************************************************************************
  //  VRP
  // *************************************************************************************************
  if(isVRP.any()) {
    $('body').on('vrp-ready vrp-ajax-complete', function() {
      if($(document).width() < 768 && $('.show-filters-button').length == 0) {
        var sort = $('.sorting-options');
        $(sort).removeClass("hidden-xs hidden-phone").append("<a trid='f8b3b4a04ac845fca3c8ad' trc class='button primary-button show-filters-button align-left' style='margin:0'>Filter Results</a>").find('select').css({width:"40%"});
        $('.show-filters-button').click(function(e) {
          $('.mobile-tab-1 .mobile-tab-label').trigger('click');
        });
      }
    });
  }

  // *************************************************************************************************
  //  VDP
  // *************************************************************************************************
  if(isVDP.hotwheels()) {
    $('body').on('click', "#ctabox-premium-features .features-link", function(e) {
      $("#factory_options .panel-title a").trigger("click");
    });
    $('#mini-header').css("display", "none");
    $('.details-page-titlewrap .details-page-row').removeClass("no-spacer");

    $('.cta-caption > p:first').insertAfter(".disclaimer-small > p:first");

    $(".panel-title a").not(".collapsed").addClass('collapsed').parents('.panel').find('.panel-collapse').removeClass('in');
    $(window).resize();

    var newHome = $('.details-page-gallerywrap .details-page-row')[0];
    $('.shopping-tool.carfax-report').appendTo(newHome);
    $('.shopping-tool.cpo-brochure').appendTo(newHome);
    $('.history_report').appendTo(newHome);
  }

  //CTABOX PREMIUM OPTIONS
  $('#ctabox-premium-features .features-link').click(function() {
    $(this).parent().toggleClass('open');
  });

  // Moved lease button from shopping tools to details-page-ctabox
  $('.shopping-tools-wrapper .lease-box').insertAfter('#details-page-ctabox .maincta-row');
  $('#details-page-ctabox .lease-box a').addClass('button');

  // VRP MOBILE FILTERS
  $('#vrp-custom-filter').click(function(e) {
      e.preventDefault();
      $('.filter .mobile-tab-label').trigger('click');
  });


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
      viewFactor: .65,
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

});
