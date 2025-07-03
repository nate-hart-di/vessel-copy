jQuery(document).ready(function ($) {
  var modfullOffset = 50;
  $('[rel=popover]').popover({
    html: true,
    placement: 'bottom',
    content: function () {
      return $('.savingsDetailsList').html();
      //return $($(this).data('contentwrapper')).html();
    },
  });

  var windowHeight = jQuery(window).height();

  $('.dealersnav ul.sub-menu').css('max-height', '400px');

  if (windowHeight <= 600) {
    var newHeight = windowHeight - 200;
    $('.dealersnav ul.sub-menu').css('max-height', '200px');
  }

  isSmallMobile = {
    any: function () {
      return $(window).width() < 767;
    },
  };

  //  BASIC PARALAX SCRIPT - for homepage on larger screens
  if ($(window).width() > 1199) {
    var s;
    setTimeout(function () {
      s = skrollr.init({
        forceHeight: false,
      });
    }, 500);

    var $paralaxItems = $(this).find('.paralax');
    $window = $(window);
    var scrollTop, animatedImageOffset, distance, windowBottom;

    $(window).scroll(function () {
      $paralaxItems.each(function (i) {
        $bgobj = $(this);
        var yPos = -($window.scrollTop() / $bgobj.data('speed'));
        var paddingTop = 0;
        var marginTop = 0;

        if ($bgobj.data('padding-top')) paddingTop = $bgobj.data('padding-top');
        yPos += paddingTop;
        var paralaxID = $(this).attr('id');
        var coords = '50% ' + yPos + 'px';
        $bgobj.css({
          backgroundPosition: coords,
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

  /*
  $('#menu-top-menu li.menu-item a:contains("New")').click(function() {
    $('#main-navbar ul.nav li.menu-item:contains("New")').addClass('new');
    $('#main-navbar ul.nav li.menu-item:contains("New")').toggleClass('open');
    $('#main-navbar ul.nav').addClass('open');
    $('#menu_modelRow').addClass('open');
  });

  $('#menu-top-menu li.menu-item a:not(:contains("New"))').click(function() {
    $('#menu-top-menu li.menu-item:contains("New")').removeClass('open');
    $('#main-navbar ul.nav').removeClass('open');
  });

  $('#menu-top-menu li.menu-item').on("click",function(e){
    $(this).toggleClass("open");
    $(this).find(".header-dropdown.dropdown-full").
  })
/*
  $("#menu-top-menu > li.menu-item").on("click",function(e){
    if(e.target.hasClass("hide-submenu")){

    }
    else{
      e.preventDefault();
      e.stopPropagation();
    }
  });
  $(document).on('click', function (e) {
    $('#main-navbar ul.nav li.menu-item:contains("New") a').removeClass('open');
    $('#main-navbar ul.nav li.menu-item:contains("New") a').parent().removeClass('open');
  });
  */

  $('a.overlay-toggle').click(function () {
    $('.toolbar-overlays, #videooverlay').addClass('open');
    $('#intro-overlay').removeClass('open');
    $('.targetOverlay').hide();
    // $('#intro-overlay').hide();
    $('.inside-tabs, .back-button, .close-overlay').fadeIn();
    $('#' + $(this).attr('target') + '-overlay')
      .fadeIn(1000)
      .addClass('showTarget');
  });

  $('.close-overlay').click(function () {
    $('.inside-tabs, .close-overlay, .back-button').hide();
    $('.toolbar-overlays, #videooverlay').removeClass('open');
    // $('.toolbar-overlays').hide();
    $('#intro-overlay').addClass('open');
    // $('#intro-overlay').fadeIn();
  });

  //Choosing an option
  $('.find-button').click(function () {
    $('.button-tabs, .targetDiv').hide();
    $('.inside-tabs, .back-button').fadeIn();
    $('#' + $(this).attr('target') + '-tab')
      .fadeIn(1000)
      .addClass('showTarget');
  });

  //Back button
  $('.back-button').click(function () {
    $('.inside-tabs, .back-button').hide();
    $('.inside-tabs .targetDiv').hide().removeClass('showTarget');
    $('.button-tabs').fadeIn(1000);
  });
  // Smooth scroll to section anchors
  $(function () {
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
  });

  $('#desktop-menu-toggle').click(function () {
    if ($(this).attr('data-gtm-event') == 'desktopHeaderMenuOpen') {
      $(this).attr('data-gtm-event', 'desktopHeaderMenuClose');
    } else {
      $(this).attr('data-gtm-event', 'desktopHeaderMenuOpen');
    }
  });

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

  //
  //  Custom landing page JS
  //
  if ($('.inventory-owl #results-page').length > 0) {
    $('body').live('vrp-ready vrp-ajax-complete', function () {
      $('.vehicle').each(function (i, obj) {
        var btn = $(this).find('.primary-cta');
        var location = $(this).find('.vehicle-price');
        $(btn).appendTo(location).find('.button-form').addClass('block green');
        $(
          "<a trid='0d8e195a7d3945cf9c8dac' trc href='/apply-for-financing/' class='button primary-button block'>Get Financing</a>",
        ).appendTo(location);
      });
    });
  }

  //
  //  Hotwheels Custom Scripts
  //
  if (isVDP.hotwheels()) {
    $(document).ready(function ($) {
      $('#mini-header').css('display', 'none');

      $('.cta-caption > p:first').insertAfter('.disclaimer-small > p:first');
      $('.shopping-tool.test-drive-cta .shopping-label .button-form')
        .addClass('button primary-button block')
        .appendTo('#details-page-ctabox div.test-drive-cta');

      $('body').on('click', '#ctabox-premium-features .features-link', function (e) {
        $('#factory_options .panel-title a').trigger('click');
      });

      $('#ctabox-premium-features .features-link').wrapInner("<span class='open-toggle'></span>");
      $("<span class='close-toggle'>Close <i class='fa fa-times'></i></span>").appendTo(
        '#ctabox-premium-features .features-link',
      );
    });

    //CTABOX PREMIUM OPTIONS
    $(document).ready(function ($) {
      var $alink = $('#ctabox-premium-features a');
      $alink.replaceWith(function () {
        return $('<div/>', {
          class: 'features-link',
          html: this.innerHTML,
        });
      });

      $('#ctabox-premium-features .features-link').click(function () {
        $(this).parent().toggleClass('open');
      });
    });
  }

  $('#desktop-locations-toggle').click(function (e) {
    $(this).toggleClass('active');
    $('#header').toggleClass('locations-active');
  });

  //
  //  Main Navigation Pop-up
  //

  $('.menu-overlay-toggle').click(function (e) {
    e.preventDefault();
    var content = $(this).data('toggle-target');
    $('#menu-overlay').toggleClass('open');
    $('#menu-overlay .overlay-content').html($(content).clone().css('display', 'block'));
    $('body').css('overflow', 'hidden');
  });

  $('.menu-close-overlay').click(function () {
    closeMenuOverlay();
  });

  $(window).keypress(function (e) {
    if (e.keyCode == 27 && $('#menu-overlay.open').length > 0) {
      closeMenuOverlay();
    }
  });

  $('body').on('click', function (e) {
    if ($(this).attr('id') == 'menu-overlay') {
      closeMenuOverlay();
    }
  });

  function closeMenuOverlay() {
    $('#menu-overlay').removeClass('open');
    $('#menu-overlay .overlay-content').html('');
    $('body').css('overflow', 'visible');
  }

  $('#desktop-locations-toggle').sidr({
    name: 'sidr-desktop-locations',
    side: 'right',
  });
  $('#desktop-phone-toggle').sidr({
    name: 'sidr-desktop-phone',
    side: 'right',
  });

  //Move custom CTA for G-Class & GT models
  if ($('body').hasClass('page-vehicle-display-page')) {
    $('div#inquire-button').insertAfter('.maincta-row.ctabox-row');
    $('div#inquire-button a').css('display', 'block');
  }
  jQuery('body').on('vrp-ajax-complete vrp-ready', function () {
    var moveTo;
    var move;
    $('.vehicle').each(function () {
      moveTo = $(this).find('.button-bar-item.primary-cta');
      move = $(this).find('a.button.inquire');
      $(this).find(move).appendTo(moveTo);
    });
  });

  if ($('#homepage-advanced-search select').length) {
    $('#homepage-advanced-search select').selectpicker({
      dropupAuto: false,
    });

    $('body').live('search_filters_rendered', function (e, filters) {
      $('#homepage-advanced-search select').selectpicker('refresh');
    });
  }

  search_filters_object = function (filters) {
    try {
      $.each(filters, function (i, v) {
        if (v.type == 'New') delete filters[i];
      });
    } catch (e) {
      if (typeof console !== 'undefined') console.log(e);
    }
    return filters;
  };
});
