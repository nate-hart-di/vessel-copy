jQuery(document).ready(function ($) {
  $('.featured-carousel').owlCarousel({
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
    $('body').on('vrp-ready vrp-ajax-complete', function () {
      $('.vehicle').each(function (i, obj) {
        var btn = $(this).find('.primary-cta');
        var location = $(this).find('.vehicle-price');
        $(btn).appendTo(location).find('.button-form').addClass('block green');
        $(
          "<a trid='7621c8070131477d82dd45' trc href='/apply-for-financing/' class='button primary-button block'>Get Financing</a>",
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

      if ($('.shopping-tool.ctabox-conditional-ctas').length) {
        $('.shopping-tool.ctabox-conditional-ctas').insertAfter('.maincta-row a');
        $('.maincta-row a[data-gtm-event="vdpPrimaryCTA"]').css({ display: 'none' });
        $('.shopping-tool.ctabox-conditional-ctas a').addClass('button primary-button block');
      }
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

    $('body').on('search_filters_rendered', function (e, filters) {
      $('#homepage-advanced-search select').selectpicker('refresh');
    });

    search_filters_object = function (vehicles, container_filters) {
      for (var i = 0; i < vehicles.length; i++) {
        vehicles[i]['type'] = vehicles[i]['type'].replace('Used', 'Pre-Owned');
      }
      return vehicles;
    };
  }

  // Transparent Scroll header
  if ($(window).width() >= 1025) {
    /* 
              Scrolling Header
              Toggling custom .visible-header class to the #header 
              when you've scrolled down the window 50px
          */
    $(window).scroll(function () {
      var scroll = $(window).scrollTop();

      if (scroll >= 50) {
        $('#header').addClass('visible-header');
      } else {
        $('#header').removeClass('visible-header');
      }
    });

    /* 
              Static Header when mobile menu is toggled
              Toggling custom .visible-header class to the #header 
              when you've toggled the hamburger menu
          */
    $('#mobile-menu').on('click', function () {
      $('#header').addClass('visible-header');
    });

    /* 
              Full Overlay Dropdown
              Toggling custom .visible-header-dropdown class to the 
              #header when an overlay button is clicked
          */
    $('#header .icon-toggle-js').on('click', function () {
      $('#header').toggleClass('visible-header-dropdown');
    });

    /* 
              Search Input
              Adding custom .visible-header-search-input class to the #header 
              when the search input is clicked inside of and removing 
              .visible-header-search-input class to the #header when the search 
              input is clicked outside of
          */
    $(document).click(function () {
      $('#header').removeClass('visible-header-search-input');
    });

    $('#header .bottomWrapper__search__input input').click(function (event) {
      $('#header').addClass('visible-header-search-input');
      event.stopPropagation();
    });
  }

  // START -> NEW VEHICLES SUBMENU
  jQuery('ul.nav > li > ul > li.menu-item-has-children > a').click(function (e) {
    if ($(this).next('ul').is(':visible') == false) {
      $(this).next('ul').show();
    } else {
      $(this).next('ul').hide();
    }
    return false;
  });
  // END -> NEW VEHICLES SUBMENU
});
