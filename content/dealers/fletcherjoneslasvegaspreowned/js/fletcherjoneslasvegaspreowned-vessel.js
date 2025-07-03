jQuery(document).ready(function ($) {
  // START -> HEADER MENU BUTTON
  $('#desktop-toggle').click(function () {
    $('#menu-overlay, #desktop-toggle').toggleClass('open');
    $('#header').toggleClass('fade-in');
  });
  // END -> HEADER MENU BUTTON

  // *************************************************************************************************
  //  UTILITY
  // *************************************************************************************************
  var windowHeight = window.outerWidth;

  isSmallMobile = {
    any: function () {
      return window.outerWidth < 767;
    },
  };

  isVRP = {
    listview: function () {
      return $('.vehicle.list-view').length ? true : false;
    },
    gridview: function () {
      return $('.vehicle.grid-view').length ? true : false;
    },
    any: function () {
      return $('#results-page').length ? true : false;
    },
  };

  isVDP = {
    wide1400: function () {
      return $('.maincardetails').length ? true : false;
    },
    hotwheels: function () {
      return $('.project-hotwheels').length ? true : false;
    },
    any: function () {
      return $('.vdpModals').length ? true : false;
    },
  };
  // *************************************************************************************************
  //  GLOBAL
  // *************************************************************************************************
  $('[rel=popover]').popover({
    html: true,
    placement: 'bottom',
    content: function () {
      return $('.savingsDetailsList').html();
    },
  });
  // FD#15103
  $('#save-vehicles-custom-toggle').click(function () {
    $('#save-vehicles-expand-btn').trigger('click');
  });
  // END FD#15103

  $('.dealersnav ul.sub-menu').css('max-height', '400px');
  if (windowHeight <= 600) {
    var newHeight = windowHeight - 200;
    $('.dealersnav ul.sub-menu').css('max-height', '200px');
  }
  //  Fix Mix Panel "resume" intention with hrefs using leading "#"
  $('[href="#"]').attr('href', 'javascript:void(0)');

  //HEADER OVERLAY
  $('.menu-top .menu-search a').data('toggle-content', '#algolia-overlay');

  $('body').on('homepage-usp-hidden', function () {
    $('#search-overlay .overlay-content').html('');
  });

  $('a.scroll').click(function () {
    if (
      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') &&
      location.hostname == this.hostname
    ) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        $('html,body').animate(
          {
            scrollTop: target.offset().top,
          },
          1000,
        );
        return false;
      }
    }
  });

  //  Clicking outside of the mobile side menu closes it
  $('#footer, #videobanner, .menu-top').click(function () {
    $.sidr('close', 'mobile-menu');
  });

  //$(".dayOW").appendTo(".dealer-hours span.department");

  //Pink Ribbon - Removed from DITM
  //var pinkRibbon = $(
  //  '<img class="pink-ribbon-oct" src="https://di-uploads-pod3.dealerinspire.com/fletcherjonesmbnewport/uploads/2017/10/pink-ribbon-e1508247273304.png" alt="Breast Cancer Awareness Month">'
  //);
  //pinkRibbon.appendTo(".logo");
  //if ($(window).width() < 768) {
  //  pinkRibbon.appendTo(".mobile-header-top .logo");
  // }

  $(function () {
    var owlSedan = jQuery('#sedanModels').owlCarousel({
      autoPlay: 7000,
      slideSpeed: 1000,
      navigation: true,
      items: 5,
      itemsDesktop: [1024, 3],
      itemsDesktopSmall: [979, 3],
      itemsTablet: [767, 1],
      itemsMobile: [320, 1],
      navigationText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
      beforeMove: function () {
        // lazyload hidden owl carousel items when they come into view
        if (typeof LazyLoad === 'function') {
          var myLazyLoad = new LazyLoad();
        }
      },
    });
    $('#sedanModels .owl-next, #sedanModels .owl-prev').on('click', function (e) {
      e.stopPropagation();
      e.preventDefault();
    });
  });

  $(function () {
    var owlCoupe = jQuery('#coupeModels').owlCarousel({
      autoPlay: 7000,
      slideSpeed: 1000,
      navigation: true,
      items: 5,
      itemsDesktop: [1024, 3],
      itemsDesktopSmall: [979, 3],
      itemsTablet: [767, 1],
      itemsMobile: [320, 1],
      navigationText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
      beforeMove: function () {
        // lazyload hidden owl carousel items when they come into view
        if (typeof LazyLoad === 'function') {
          var myLazyLoad = new LazyLoad();
        }
      },
    });
    $('#coupeModels .owl-next, #coupeModels .owl-prev').on('click', function (e) {
      e.stopPropagation();
      e.preventDefault();
    });
  });

  $(function () {
    var owlSUV = jQuery('#suvModels').owlCarousel({
      autoPlay: 7000,
      slideSpeed: 1000,
      navigation: true,
      items: 5,
      itemsDesktop: [1024, 3],
      itemsDesktopSmall: [979, 3],
      itemsTablet: [767, 1],
      itemsMobile: [320, 1],
      navigationText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
      beforeMove: function () {
        // lazyload hidden owl carousel items when they come into view
        if (typeof LazyLoad === 'function') {
          var myLazyLoad = new LazyLoad();
        }
      },
    });
    $('#suvModels .owl-next, #suvModels .owl-prev').on('click', function (e) {
      e.stopPropagation();
      e.preventDefault();
    });
  });

  $(function () {
    var owlConvert = jQuery('#convertModels').owlCarousel({
      autoPlay: 7000,
      slideSpeed: 1000,
      navigation: true,
      items: 5,
      itemsDesktop: [1024, 3],
      itemsDesktopSmall: [979, 3],
      itemsTablet: [767, 1],
      itemsMobile: [320, 1],
      navigationText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
      beforeMove: function () {
        // lazyload hidden owl carousel items when they come into view
        if (typeof LazyLoad === 'function') {
          var myLazyLoad = new LazyLoad();
        }
      },
    });
    $('#convertModels .owl-next, #convertModels .owl-prev').on('click', function (e) {
      e.stopPropagation();
      e.preventDefault();
    });
  });

  $(function () {
    var owlHybrid = jQuery('#hybridModels').owlCarousel({
      autoPlay: 7000,
      slideSpeed: 1000,
      navigation: true,
      items: 4,
      itemsDesktop: [1024, 3],
      itemsDesktopSmall: [979, 3],
      itemsTablet: [767, 1],
      itemsMobile: [320, 1],
      navigationText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
      beforeMove: function () {
        // lazyload hidden owl carousel items when they come into view
        if (typeof LazyLoad === 'function') {
          var myLazyLoad = new LazyLoad();
        }
      },
    });
    $('#hybridModels .owl-next, #hybridModels .owl-prev').on('click', function (e) {
      e.stopPropagation();
      e.preventDefault();
    });
  });

  $('#menu_modelRow').insertBefore(
    '#header .menu-item:contains("New") .header-dropdown.dropdown-full .header-dropdown-container',
  );

  $('#modelTab button').click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).tab('show');
  });

  $('#menu-top-menu li.menu-item a:contains("New")').click(function () {
    $('#main-navbar ul.nav li.menu-item:contains("New")').addClass('new');
    $('#main-navbar ul.nav li.menu-item:contains("New")').toggleClass('open');
    $('#main-navbar ul.nav').addClass('open');
    $('#menu_modelRow').addClass('open');
  });

  $('#menu-top-menu li.menu-item a:not(:contains("New"))').click(function () {
    $('#menu-top-menu li.menu-item:contains("New")').removeClass('open');
    $('#main-navbar ul.nav').removeClass('open');
  });

  $(document).on('click', function (e) {
    $('#main-navbar ul.nav li.menu-item:contains("New") a').removeClass('open');
    $('#main-navbar ul.nav li.menu-item:contains("New") a').parent().removeClass('open');
  });

  //Custom mobile header icons
  $('#header-heart').click(function (e) {
    $('#save-vehicles-expand-btn').trigger('click');
  });

  if ($('#count-number').html() === 0) {
    $('#vehicle-count-overview-number').hide();
  }
  // *************************************************************************************************
  //  INNER PAGES
  // *************************************************************************************************
  $('li.difo-wallet.difo-wallet-btn-container').addClass('visible-xs');

  // JS for custom service/parts coupon template disclaimer
  $('.specialCoupon .view-disclaimer-link').on('click', function (e) {
    var disclaimer = $(this).parents('.specialCoupon').find('.disclaimer');
    $(disclaimer).addClass('open');
  });
  $('.specialCoupon .disclaimer .fa-close').on('click', function (e) {
    $(this).parents('.disclaimer').removeClass('open');
  });
  $('#c-class-countdown .c-class-countdown-close').click(function () {
    $(this).parent().toggleClass('close');
    $('.c-class-countdown-sm').toggleClass('inactive');
  });
  $('.c-class-countdown-sm').click(function () {
    $(this).toggleClass('inactive');
    $('#c-class-countdown').toggleClass('close');
  });
  //locked pricing
  function getCookie(name) {
    var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    if (match) return match[2];
  }
  if (getCookie('vrp-form') == 'visited') {
    $('body').addClass('locked-pricing-price-unlocked');
  }
  // *************************************************************************************************
  //  VEHICLE RESULTS PAGE
  // *************************************************************************************************

  $('#vrp-custom-filter').click(function () {
    $('.mobile-tabs.mobile-tabs-count-4 .mobile-tab-1').show();
    $('.mobile-tab.filter .mobile-tab-label').trigger('click');
  });

  jQuery('body').on('vrp-ajax-complete vrp-ready', function () {
    $('.vehicle').each(function () {
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

  var l_vrp_inv = setInterval(function () {
    if (typeof window.l_vrp_did_change !== 'undefined') {
      clearInterval(l_vrp_inv);
      if (window.l_vrp_did_change) {
        window.l_vrp_did_change = false;
        //  $("#lightning-vehiclefinder").modal('show');
        //  $("#lightning-vehiclefinder").removeClass('hidden');
      }
    }
  }, 500);

  $(document).on('click', '#lvrp-vehicle-finder-image', function (e) {
    $('#lightning-vehiclefinder').modal('show');
    $('#lightning-vehiclefinder').removeClass('hidden');
  });

  // *************************************************************************************************
  //  VEHICLE DETAILS PAGE
  // *************************************************************************************************
  if (isVDP.hotwheels()) {
    $('body').on('click', '#ctabox-premium-features .features-link', function (e) {
      $('#factory_options .panel-title a').trigger('click');
    });
    $('#mini-header').css('display', 'none');
    $('.details-page-titlewrap .details-page-row').removeClass('no-spacer');

    $('.cta-caption > p:first').insertAfter('.disclaimer-small > p:first');
    $(window).resize();
  }

  //CTABOX PREMIUM OPTIONS
  $('#ctabox-premium-features .features-link').click(function () {
    $(this).parent().toggleClass('open');
  });
  //Move custom CTA for G-Class & GT models
  if ($('body').hasClass('page-vehicle-display-page')) {
    $('div#inquire-button').insertAfter('.maincta-row.ctabox-row');
    $('div#inquire-button a').css('display', 'block');
  }
  // *************************************************************************************************
  //  MOBILE
  // *************************************************************************************************
  if (isSmallMobile.any()) {
    $('.gallery a.large-img').removeClass('fancybox');
    $('#gallerycarousel')
      .find('a')
      .removeClass('fancybox')
      .click(function (e) {
        e.preventDefault();
        $('.gallery').find('a.large-img').attr('href', $(this).attr('href'));
        $('.gallery').find('a.large-img img').attr('src', $(this).attr('href'));
      });

    $('#gallerycarousel').touchwipe({
      wipeLeft: function () {
        $('#gallerycarousel').jcarousel('next');
        jQuery('.carousel').tooltip('close');
      },
      wipeRight: function () {
        $('#gallerycarousel').jcarousel('prev');
        jQuery('.carousel').tooltip('close');
      },
    });

    $('.carousel').tooltip({
      content: 'Swipe Left/Right to Scroll Gallery!',
      position: {
        my: 'center',
        at: 'center',
      },
    });
  }

  if (window.outerWidth < 768) {
    if (isMobile.iOS()) $('.fj-drive .android').hide();
    else $('.fj-drive .iOS').hide();
  }

  // *************************************************************************************************
  //  MOBILE MENUS
  // *************************************************************************************************

  // if ($(window).width() <= 768) {
  //     // Hours modal
  //     $('#menu-mobile-footer-menu .menu-hours a, a.hours-modal').attr({
  //         "data-toggle": "modal",
  //         "data-target": "#DIModal",
  //         "data-modal-content": "#mobileHours",
  //         "data-modal-class": "hours-modal",
  //         "data-modal-title": ""
  //     });
  //
  //     var str = document.getElementById("dealerHours").innerHTML;
  //     var res = str.replace(/Hours:/g, "");
  //     document.getElementById("dealerHours").innerHTML = res;
  //
  // }

  // DIPC CUSTOM SECTIONS
  if ($(window).width() <= 768) {
    // CTA Carousels
    var cta_carousels = new Swiper('.mobile-carousel .mobile-carousel_wrap', {
      speed: 600,
      slidesPerGroup: 1,
      slidesPerView: 1,
      pagination: false,
      lazy: {
        enabled: true,
      },
      watchOverflow: true,
      navigation: false,
    });

    $('.mobile-carousel .mobile-carousel_wrap .swiper-wrapper').each(function () {
      if ($(this).children().length < 2) {
        $(this).parent().addClass('single');
      }
    });
  }
});
