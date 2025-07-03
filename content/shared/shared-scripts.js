jQuery(document).ready(function ($) {
  // ********************* START -> NEW HEADER MENU 03/2024 **************************************

  $('.search-toggle').click(function () {
    $('.search-bar').toggle();
    $('.search-bar').addClass('active');
    $(this).addClass('hidden');
  });
  $('span#close-search').click(function () {
    $('.search-bar').toggle();
    $('.search-bar').removeClass('active');
    $('.search-toggle').removeClass('hidden');
  });

  // Transparent Scroll header
  if ($(window).width() >= 1025) {
    /* 
          Scrolling Header
          Toggling custom .visible-header class to the #header 
          when you've scrolled down the window 50px
              
              $(window).scroll(function() {
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
                  Search Toggle
                  Toggling custom .visible-header-search class to the 
                  #header when the search button is clicked
              */
    $('#header .search-toggle-js').on('click', function () {
      $('#header').toggleClass('visible-header-search');
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

  function adjustMenu() {
    var menuItems = $('ul.nav li ul li.menu-item-has-children > a');

    $.each(menuItems, function (index, element) {
      $(element).on('click tap', function (e) {
        e.preventDefault();
        e.stopPropagation();
        closeMenu(element);
        $(this).next().toggle('open');
        return false;
      });
    });

    var closeMenu = function (element) {
      $(element).parent().siblings().removeClass('active');
      $(element).parent().siblings().find('.dropdown-menu').removeAttr('style');
    };
  }

  adjustMenu();

  $('ul.dropdown-menu li.dropdown a,ul.dropdown-menu li.dropdown ul.dropdown-menu li.dropdown a').append(
    '<span class="caret"></span>',
  );

  // ********************* END -> NEW HEADER MENU 03/24 **************************************

  // *************************************************************************************************
  //
  // *************************************************************************************************

  if ($('#rotating-logos').length) {
    // Rotate through Smart and Sprinter logos in header
    var rotatingImgs = $('.rotating-logos > .menu-item-img img');
    //var rotateMenuImgs = $("#menu-overlay .rotating-logos img");
    var imgI = 0;
    rotateLogos();
    var logoRotation = setInterval(rotateLogos, 2000);

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
  }
  $('#ctabox-premium-features h4.features-title').html('Included Features');

  if ($('.upsells').length) {
    var mySwiper = new Swiper('.swiper-container', {
      // If we need pagination
      pagination: {
        el: '.swiper-pagination',
      },

      // Navigation arrows
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      slidesPerView: 4,
      breakpoints: {
        // when window width is <= 320px
        320: {
          slidesPerView: 1,
        },
        // when window width is <= 480px
        480: {
          slidesPerView: 2,
        },
        // when window width is <= 640px
        640: {
          slidesPerView: 3,
        },
      },
    });
  }

  $('.ask-question-btn').click(function (e) {
    $(this).parent().toggleClass('active');
  });

  var body = document.querySelector('body');
  if (body.classList.contains('single-post')) {
    var homeBtn =
      '<a trid="c80c4279970d4c67bc8b6b" trc href="/blog" class="back-button button primary-button small" id="me">Home</a>';

    jQuery(homeBtn).insertBefore('.post-content:eq(0)');
  }

  var soCta = $('.special-offer');

  function getFormFieldForSite(site) {
    var id;
    switch (site) {
      case 'fjmercedes':
        id = 'input_87_16';
        break;
      case 'mbontario':
        id = 'input_61_16';
        break;
      case 'mbtemecula':
        id = 'input_60_17';
        break;
      case 'mboffremont':
        id = 'input_58_16';
        break;
      case 'porscheoffremont':
        id = 'input_46_16';
        break;
      case 'mbofhenderson':
        id = 'input_67_16';
        break;
      case 'fjimports':
        id = 'input_36_22';
        break;
      case 'mercedesbenzofhonolulu':
        id = 'input_43_18';
        break;
      case 'bigislandhonda':
        id = 'input_50_19';
        break;
      case 'porscheofhawaii':
        id = 'input_46_17';
        break;
      case 'mbofmaui':
        id = 'input_43_18';
        break;

      default:
        break;
    }
    return id;
  }

  $.each(soCta, function (item) {
    var claimOfferCta = $(this).find('a').eq(2);

    $(claimOfferCta).click(function (e) {
      $('#vrp-notifications-modal-container').on('shown.bs.modal', function () {
        var url = window.location.origin.split('.')[1];
        var formFieldId = getFormFieldForSite(url);
        var offerTitle = $(claimOfferCta).parents('.special-offer').find('.offer-content>h2').html();
        $(this).find(formFieldId).val(offerTitle);
      });
    });
  });

  if ($('.page-vehicle-display-page').length) {
    $('.below-gallery-shopping-tool').appendTo('.details-page-gallerywrap .details-page-row:first');
  }
  $(document).ajaxComplete(function () {
    $('.vehicle').each(function () {
      $(this).find('.unlock-offer').insertAfter($(this).find('.price-top'));
    });
  });
  //PAYMENT OVERLAY
  $('.menu-top .menu-search a').data('toggle-content', '#algolia-overlay');
  $('.menu-top .menu-phone a').data('toggle-content', '#contact-overlay');

  $('.overlay-toggle, .menu-top .menu-phone a').click(function (e) {
    e.preventDefault();
    var content = $(this).data('toggle-target');

    $('body').css('overflow', 'hidden');

    $('#search-overlay').addClass('open');

    $('#search-overlay .overlay-content').html('');
    $('#search-overlay .search-section').hide();

    $('#search-overlay .overlay-content').html($(content).clone().css('display', 'block'));
    $('#search-overlay ' + content).removeClass('hidden-all');
    $('#search-overlay ' + content).addClass('active');

    setTimeout(function () {
      if (typeof LazyLoad === 'function') {
        var myLazyLoad = new LazyLoad();
      }
    }, 400);
  });

  $('.menu-top .menu-search a').click(function (e) {
    e.preventDefault();
    $('#search-overlay').addClass('open');

    $('#search-overlay .overlay-content').html('');
    $('#search-overlay .search-section').show();
    setTimeout(function () {
      if (typeof LazyLoad === 'function') {
        var myLazyLoad = new LazyLoad();
      }
    }, 400);
  });

  $('#search-overlay').on('click', '.close-overlay', function () {
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

  // *************************************************************************************************
  //  HEADER HOURS
  // *************************************************************************************************
  // checks if hours are in header top or header bottom and sets the location for the ajax
  var hoursClass = '';
  if ($('.header-top .dealer-hours').length) {
    hoursClass = '.header-top .dealer-hours';
  } else if ($('.header-bottom .dealer-hours').length) {
    hoursClass = '.header-bottom .dealer-hours';
  }

  $.ajax({
    type: 'POST',
    dataType: 'json',
    url: variables.ajaxurl,
    data: { action: 'di_hours' },
    success: function (response) {
      if (response.data.success) {
        if (typeof response.data.data !== 'undefined') {
          var data = response.data.data;
          $(hoursClass).replaceWith(data);
        }
      } else {
        if (typeof response.data.error !== 'undefined') {
          console.log(response.data.error);
        }
      }
    },
    error: function (error) {
      console.log('ERROR: was not able recieve delivery data. ' + error);
      $('.header-top .dealer-hours-container .fa-spinner').addClass('hidden');
    },
  });

  $(document).on('click', '.dealer-hours-container', function (e) {
    $('.dealer-hours-container').toggleClass('open');
    e.preventDefault();
    e.stopPropagation();
  });

  // *************************************************************************************************
  //  VEHICLE DETAILS PAGE
  // *************************************************************************************************

  if ($('body.page-vehicle-display-page').length) {
    if ($('.shopping-tool.ctabox-conditional-ctas').length) {
      if ($('#details-page-ctabox .maincta-row a').length) {
        $('.shopping-tool.ctabox-conditional-ctas').insertAfter('.maincta-row a');
      } else if ($('#details-page-ctabox .e-price').length) {
        $('.shopping-tool.ctabox-conditional-ctas').insertAfter('#details-page-ctabox .e-price');
      }
      $('.shopping-tool.ctabox-conditional-ctas a').addClass('button primary-button block');
    }

    $('#review-box').owlCarousel({
      autoPlay: 7000,
      navigation: false,
      items: 3,
      itemsDesktop: [1024, 2],
      itemsDesktopSmall: [979, 2],
      itemsTablet: [768, 1],
    });
  }

  if (jQuery('.page-vehicle-display-page').length) {
    if (document.readyState === 'interactive' || document.readyState === 'complete') {
      if (jQuery('.detail-item-row__header.open').length) {
        setTimeout(function () {
          jQuery('.detail-item-row__header.open')[0].click();
        }, 400);
      }
    }
  }

  // Copied over from fletcherjonesmbnewport for Mobile Redevelopments
  // *************************************************************************************************
  //  MOBILE MENUS
  // *************************************************************************************************

  if ($(window).width() <= 768) {
    // Hours modal
    $('#menu-mobile-footer-menu .menu-hours a, a.hours-modal').attr({
      'data-toggle': 'modal',
      'data-target': '#DIModal',
      'data-modal-content': '#mobileHours',
      'data-modal-class': 'hours-modal',
      'data-modal-title': '',
    });

    if ($('#dealerHours').length) {
      var str = document.getElementById('dealerHours').innerHTML;
      var res = str.replace(/Hours:/g, '');
      document.getElementById('dealerHours').innerHTML = res;
    }
  }

  // HEADER MOBILE MENU

  $('.open-overlay-js').click(function (e) {
    if ($('#full-overlay').hasClass('open')) {
      // if what was clicked on doesn't have the showTarget class we will show it and hide the other overlay
      if (!$('#' + $(this).attr('target') + '-overlay').hasClass('showTarget')) {
        // fade out overlay we don't want
        $('.tool-overlay.showTarget').hide().removeClass('showTarget');
        $('#algolia-overlay').addClass('hidden-all');
        $('#algolia-overlay').removeClass('active');
        // fade in the overlay we want
        $('#' + $(this).attr('target') + '-overlay')
          .show()
          .addClass('showTarget');
        $('body').css('overflow-y', 'hidden');
      } else {
        // close the overlay & target
        $('#' + $(this).attr('target') + '-overlay')
          .hide()
          .removeClass('showTarget');
        $('#full-overlay').removeClass('open');
        $('body').css('overflow-y', 'initial');
        $('body').css('overflow-x', 'hidden');
        $('.targetOverlay').hide();
      }
    } else {
      // open overlay
      $('#full-overlay').addClass('open');
      $('.menu-top').addClass('open');
      $('.targetOverlay').hide();
      $('#algolia-overlay').addClass('hidden-all');
      $('#search-overlay, #algolia-overlay').removeClass('active');
      $('#' + $(this).attr('target') + '-overlay')
        .show()
        .addClass('showTarget');
      $('body').css('overflow-y', 'hidden');
    }
  });

  // JS for Mobile/Tablet Menu/Overlay Menu
  var submenuparent = $('.menu-item-has-children a.dropdown-toggle');
  var submenuoverlay = $('#menu-submenu-overlay');

  var mobile_menu = $('#menu-mobile-header-menu.nav');

  $('#close-button').on('click tap', function () {
    $('#full-overlay').removeClass('open');
    submenuoverlay.removeClass('active');
    submenuoverlay.find('.dropdown-menu').remove();
    mobile_menu.removeClass('hide-item');
    $('body').css('overflow-y', 'initial');
  });

  $('#back-button').on('click tap', function () {
    submenuoverlay.removeClass('active');
    submenuoverlay.find('.dropdown-menu').remove();

    mobile_menu.removeClass('hide-item');
  });

  submenuparent.on('click tap', function (e) {
    e.preventDefault();
    var that = $(this);
    // grabbing title to set in the overlay
    var title = that.attr('title');

    // we are cloning the submenu attatched to the parent link we clicked on - we add the nav class for css styles
    var submenu = that.siblings('ul.dropdown-menu').clone().addClass('nav');
    submenuoverlay.scrollTop = 0;
    // set heading to the overlay
    $('#heading-title span').html(title);

    mobile_menu.addClass('hide-item');

    // append the new submenu to the overlay
    submenuoverlay.append(submenu);
    submenuoverlay.addClass('active');

    var innermenuparent = $('.dropdown-menu .menu-item-has-children');
    innermenuparent.addClass('inner-submenu');
    if (innermenuparent.hasClass('inner-submenu')) {
      $('.inner-submenu > a').on('click tap', function (e) {
        e.preventDefault();
        $(this).parent().toggleClass('active');
      });
    }
  });

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
      navigation: {
        nextEl: '.mobile-carousel .swiper-button-next',
        prevEl: '.mobile-carousel .swiper-button-prev',
      },
      watchOverflow: true,
    });

    $('.mobile-carousel .mobile-carousel_wrap .swiper-wrapper').each(function () {
      if ($(this).children().length < 2) {
        $(this).parent().addClass('single');
      }
    });
  }
  // END DIPC CUSTOM SECTIONS

  $('.mobile-tabs').on('click', function (e) {
    if (typeof e.target != 'undefined') {
      if ($(e.target).hasClass('mobile-tab-label')) {
        $('body').addClass('open-mobile-tabs');
      } else if ($(e.target).hasClass('mobile-tab-close')) {
        $('body').removeClass('open-mobile-tabs');
      }
    }
  });

  // *************************************************************************************************
  //  REVIEWS SHORTCODE
  // *************************************************************************************************
  setTimeout(function () {
    var reviews = new Swiper('.reviewsRow .swiper-container', {
      speed: 300,
      slidesPerGroup: 3,
      slidesPerView: 3,
      spaceBetween: 55, // This should match the ".swiper-container" left/right padding on tablet+ in the stylesheet (to allow space for the arrows)
      watchOverflow: true,
      lazy: {
        enabled: true,
      },
      navigation: {
        nextEl: '.reviewsRow .swiper-button-next.reviews',
        prevEl: '.reviewsRow .swiper-button-prev.reviews',
      },
      breakpoints: {
        1199: {
          slidesPerGroup: 2,
          slidesPerView: 2,
        },
        979: {
          slidesPerGroup: 1,
          slidesPerView: 1,
        },
      },
    });
  });

  // *************************************************************************************************
  //  LAZY LOADING
  // *************************************************************************************************

  $('img[data-original]').on('load', function (e) {
    if (this.complete) {
      $(this).addClass('di-lazyloaded');
    } else {
    }
  });

  setTimeout(function () {
    $('body').removeClass('di-third-party-render');
  }, 12000);

  // *************************************************************************************************
  //  FIX SMOOTH SCROLL ON LIGHTBOX
  // *************************************************************************************************

  scrollFunction = window.scroll;
  $.fancybox.defaults.beforeLoad = function () {
    window.scroll = function () {};
  };

  $.fancybox.defaults.AfterClose = function () {
    window.scroll = scrollFunction;
  };

  // *************************************************************************************************
  //  FJ EVENTS IN NAV
  // *************************************************************************************************
  if (variables.is_MB) {
    var dataLayer = window.dataLayer || [];
    jQuery('#main-navbar,#mobile-menu').on('click', '.menu-item a', function (e) {
      var value = jQuery(this).text().trim() || false;
      var label = jQuery(this).data('gtm-event-label') || value;

      if (label && typeof label === 'string') {
        dataLayer.push({
          event: 'FJMenuClick',
          eventCategory: 'Navigation',
          eventAction: 'Click',
          eventLabel: 'Clicks on ' + label + ' in Nav',
          eventValue: value,
        });
      }
    });
  }

  $(document).on('click', 'li.top-level-empty', function (e) {
    // e.preventDefault();
    e.stopPropagation();
    $(this).parent('ul.dropdown-menu').toggleClass('open');
  });
});

function addDays(date, days) {
  var result = new Date(date);
  result.setDate(result.getDate() + days);
  return result;
}

$(document).on('gform_post_render', function (event, form_id, current_page) {
  if (typeof gform !== 'undefined') {
    gform.addFilter('gform_datepicker_options_pre_init', function (optionsObj, formId, fieldId) {
      jQuery('.datepicker').attr('readonly', 'readonly');
      return optionsObj;
    });
  }

  var todaysDate = new Date();
  if (typeof variables.shuttle_form != 'undefined') {
    if (form_id == variables.shuttle_form) {
      var new_date = addDays(todaysDate, 2);
      var new_date3 = addDays(todaysDate, 3);
      $(window).on('di_gravity_forms_loaded', function () {
        selector = '#gform_' + variables.shuttle_form + ' input.datepicker';
        selector2 = '#gform_' + variables.shuttle_form + ' .di_gf_plus_2d input.datepicker';
        selector3 = '#gform_' + variables.shuttle_form + ' .di_gf_plus_3d input.datepicker';

        $(selector).datepicker('option', 'minDate', new_date);
        $(selector2).datepicker('option', 'minDate', new_date);
        $(selector3).datepicker('option', 'minDate', new_date3);
      });
    }
  }
});
