jQuery(document).ready(function ($) {
  // *************************************************************************************************
  //  UTILITIES
  // *************************************************************************************************
  isSmallMobile = {
    any: function () {
      return $(window).width() < 767;
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

  $('.blog .featured-carousel, .category .featured-carousel').owlCarousel({
    loop: true,
    margin: 10,
    navigation: true,
    navigationText: [
      '<i class="fa fa-angle-left" aria-hidden="true"></i>',
      '<i class="fa fa-angle-right" aria-hidden="true"></i>',
    ],
    items: 4,
    itemsDesktop: [1200, 3],
    itemsDesktopSmall: [1024, 2],
    itemsTablet: [767, 1],
  });

  $('[rel=popover]').popover({
    html: true,
    placement: 'bottom',
    content: function () {
      return $('.savingsDetailsList').html();
    },
  });

  var windowHeight = jQuery(window).height();

  $('.dealersnav ul.sub-menu').css('max-height', '400px');

  if (windowHeight <= 600) {
    var newHeight = windowHeight - 200;
    $('.dealersnav ul.sub-menu').css('max-height', '200px');
  }

  //START - CUSTOM CSS ANIMATION ON PAGE LOAD
  setTimeout(function () {
    jQuery('.fall-item').addClass('active');
  }, 200);
  //END - CUSTOM CSS ANIMATION ON PAGE LOAD

  //  Fix Mix Panel "resume" intention with hrefs using leading "#"
  $('[href="#"]').attr('href', 'javascript:void(0)');

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
      position: { my: 'center', at: 'center' },
    });
  }

  //PHONE OVERLAY
  $('.menu-top .menu-phone a').attr('data-toggle-target', '#contact-overlay');

  $('.close-overlay').click(function () {
    closeOverlay();
  });

  $(window).keypress(function (e) {
    if (e.keyCode == 27 && $('#search-overlay.open').length > 0) {
      closeOverlay();
    }
  });

  $('body').on('click', function (e) {
    if ($(e.target).attr('id') == 'search-overlay') {
      closeOverlay();
    }
  });

  function closeOverlay() {
    $('#search-overlay').removeClass('open');
    $('body').css('overflow', 'visible');
    $('body').trigger('homepage-usp-hidden');

    $('#algolia-overlay').addClass('hidden-all');
    $('#algolia-overlay').removeClass('active');
  }

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

  if ($(window).width() < 768) {
    if (isMobile.iOS()) $('.fj-drive .android').hide();
    else $('.fj-drive .iOS').hide();
  }

  // Rotate through Smart and Sprinter logos in header
  var rotatingImgs = $('.rotating-logos img');
  //var rotateMenuImgs = $("#menu-overlay .rotating-logos img");
  var imgI = 0;
  rotateLogos();
  var logoRotation = setInterval(rotateLogos, 3000);

  function rotateLogos() {
    $(rotatingImgs).removeClass('showing');
    //$(rotateMenuImgs).removeClass("showing");
    $(rotatingImgs).eq(imgI).addClass('showing');
    //$(rotateMenuImgs).eq(imgI).addClass("showing");

    if (imgI == rotatingImgs.length - 1) {
      imgI = 0;
    } else {
      imgI++;
    }
  }

  //  Clicking outside of the mobile side menu closes it
  $('#footer, #videobanner, .menu-top').click(function () {
    $.sidr('close', 'mobile-menu');
  });

  //Service menu customizations
  $('.parts-link').wrapAll('<div class="service-menu-right" />');
  $('<h2 class="parts-link">Parts</h2>').insertBefore('li#menu-item-18808');

  // Add day of week to header hours
  $('.dayOW').appendTo('.dealer-hours span.department');

  $('#menu-top-menu li.menu-item a:contains("New")').click(function () {
    $('#main-navbar ul.nav').addClass('open');
    $('#menu_modelRow').addClass('open');
  });

  $(function () {
    var owl = jQuery('#sedanModels').owlCarousel({
      autoPlay: 7000,
      slideSpeed: 1000,
      navigation: true,
      items: 5,
      itemsDesktop: [1024, 3],
      itemsDesktopSmall: [979, 3],
      itemsTablet: [767, 1],
      itemsMobile: [320, 1],
    });
  });

  $(function () {
    var owl = jQuery('#coupeModels').owlCarousel({
      autoPlay: 7000,
      slideSpeed: 1000,
      navigation: true,
      items: 5,
      itemsDesktop: [1024, 3],
      itemsDesktopSmall: [979, 3],
      navigationText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
      itemsTablet: [767, 1],
      itemsMobile: [320, 1],
    });
    $('#coupeModels .owl-next, #coupeModels .owl-prev').on('click', function (e) {
      e.stopPropagation();
      e.preventDefault();
    });
  });

  $(function () {
    var owl = jQuery('#suvModels').owlCarousel({
      autoPlay: 7000,
      slideSpeed: 1000,
      navigation: true,
      items: 5,
      itemsDesktop: [1024, 3],
      itemsDesktopSmall: [979, 3],
      itemsTablet: [767, 1],
      itemsMobile: [320, 1],
    });
  });

  $(function () {
    var owl = jQuery('#convertModels').owlCarousel({
      autoPlay: 7000,
      slideSpeed: 1000,
      navigation: true,
      items: 5,
      itemsDesktop: [1024, 3],
      navigationText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
      itemsDesktopSmall: [979, 3],
      itemsTablet: [767, 1],
      itemsMobile: [320, 1],
    });
    $('#convertModels .owl-next, #convertModels .owl-prev').on('click', function (e) {
      e.stopPropagation();
      e.preventDefault();
    });
  });

  $(function () {
    var owl = jQuery('#hybridModels').owlCarousel({
      autoPlay: 7000,
      slideSpeed: 1000,
      navigation: true,
      items: 3,
      itemsDesktop: [1024, 3],
      itemsDesktopSmall: [979, 3],
      itemsTablet: [767, 1],
      itemsMobile: [320, 1],
    });
  });

  $('#modelTab button').click(function (e) {
    e.stopPropagation();
    $(this).tab('show');
  });

  $('#menu_modelRow').insertBefore(
    '#header .menu-item:contains("New") .header-dropdown.dropdown-full .header-dropdown-container',
  );

  if ($('#count-number').html() == 0) {
    $('#vehicle-count-overview-number').hide();
  }
  // *************************************************************************************************
  //  VEHICLE RESULTS PAGE
  // *************************************************************************************************
  if (isVRP.any()) {
    $('body').on('vrp-ready vrp-ajax-complete', function () {
      $('.vehicle').each(function (i, obj) {
        var cta = $(this).find('.button-bar .cta-button,.button-bar .below-price-cta');
        var location = $(this).find('.vehicle-price');
        $(cta).addClass('block green button button-primary');
        $(this).find('.primary-cta').appendTo($(this).find('.vehicle-price'));
        // $(cta).appendTo(location).removeClass("hidden-all");
        $(this).find($('.dv-videobutton')).appendTo($(this).find('.vehicle-leftcol .vehicle-badges'));
        $(this)
          .find($('a.cta-button.button.roadster-btn.icon.get-eprice.block.green.button-primary'))
          .appendTo($(this).find('.advanced-pricing-stack'));
        $(this)
          .find('.button.primary-button.block.options-button')
          .appendTo($(this).find('.vehicle-leftcol .vehicle-badges'));
      });
      if ($(document).width() < 768 && $('.show-filters-button').length === 0) {
        var sort = $('.sorting-options');
        $(sort)
          .removeClass('hidden-xs hidden-phone')
          .append(
            "<a trid='cdcd2eb870bb40fbb77184' trc class='button primary-button show-filters-button align-left' style='margin:0'>Filter Results</a>",
          )
          .find('select')
          .css({ width: '40%' });
        $('.show-filters-button').click(function (e) {
          $('.mobile-tab-1 .mobile-tab-label').trigger('click');
        });
      }
    });
  }

  // *************************************************************************************************
  //  VEHICLE DETAILS PAGE
  // *************************************************************************************************
  //
  //    Hotwheels Custom Scripts
  //
  if (isVDP.hotwheels()) {
    $('body').on('click', '#ctabox-premium-features .features-link', function (e) {
      $('#factory_options .panel-title a').trigger('click');
    });
    $('#mini-header').css('display', 'none');
    $('.details-page-titlewrap .details-page-row').removeClass('no-spacer');

    $('.cta-caption > p:first').insertAfter('.disclaimer-small > p:first');

    $('.panel-title a')
      .not('.collapsed')
      .addClass('collapsed')
      .parents('.panel')
      .find('.panel-collapse')
      .removeClass('in');
    $(window).resize();
  }
  $('.inStockCTAContainer .cta-button').after($('.third-party-shopping-box .financing-button'));
  jQuery('.lease-offer-now').appendTo('.maincta-row');

  // *************************************************************************************************
  //  INNER PAGES
  // *************************************************************************************************

  // JS for custom service/parts coupon template disclaimer
  $('.specialCoupon .view-disclaimer-link').on('click', function (e) {
    var disclaimer = $(this).parents('.specialCoupon').find('.disclaimer');
    $(disclaimer).addClass('open');
  });
  $('.specialCoupon .disclaimer .fa-close').on('click', function (e) {
    $(this).parents('.disclaimer').removeClass('open');
  });
});
