jQuery(document).ready(function ($) {
  // *************************************************************************************************
  //	General
  // *************************************************************************************************

  // Autoselect LToyota when type is changed to New
  $('body').live('search_filters_rendered', function () {
    var selectType, selectMake;

    if ($(window).width() >= 768) {
      selectType = $('.bannerOverlay #vehicle-type');
      selectMake = $('.bannerOverlay #vehicle-make');
    } else {
      selectType = $('#mobile-advanced-search #vehicle-type');
      selectMake = $('#mobile-advanced-search #vehicle-make');
    }

    selectType.on('change', function () {
      if ($(this).val() === 'New') {
        var option = selectMake.find('option[value="Toyota"]');
        option.attr('selected', 'selected');
        selectMake.change();
      }
    });
  });

  // *************************************************************************************************
  //	Footer
  // *************************************************************************************************

  // START -> Mobile Footer Menus
  if ($(window).width() <= 768) {
    $('.footerMiddle__menus .widget').on('click', function () {
      $(this).toggleClass('active').siblings().removeClass('active');
      $(this).find(' > div').slideToggle().parent().siblings().find(' > div').slideUp();
    });
  }
  //END -> Mobile Footer Menus

  // *************************************************************************************************
  //	Homepage
  // *************************************************************************************************

  // Place Homepage only Javascript inside of IF statement //
  if (document.body.classList.contains('home')) {
    // *************************************************************************************************
    //	Hero Row
    // *************************************************************************************************

    if ($(window).width() > 767) {
      setTimeout(function () {
        $('#homepage-advanced-search select').selectpicker({ dropupAuto: false });
        $('body').live('search_filters_rendered', function () {
          $('#homepage-advanced-search select').selectpicker('refresh');
        });
        $('#homepage-advanced-search .filters').fadeIn();
      }, 600);
    }
    // END -> HOMEPAGE SELECTS

    // *************************************************************************************************
    //	Content Row
    // *************************************************************************************************
    (function () {
      'use strict';
      // breakpoint where swiper will be destroyed
      var breakpoint = window.matchMedia('(min-width:768px)');
      // keep track of swiper instances to destroy later
      var mySwiper;
      //////////////////////////////////////////////////////////////////
      //////////////////////////////////////////////////////////////////
      //////////////////////////////////////////////////////////////////
      var breakpointChecker = function () {
        // if larger viewport and multi-row layout needed
        if (breakpoint.matches === true) {
          // clean up old instances and inline styles when available
          if (mySwiper !== undefined) mySwiper.destroy(true, true);
          // or/and do nothing
          return;
          // else if a small viewport and single column layout needed
        } else if (breakpoint.matches === false) {
          // fire small viewport version of swiper
          return enableSwiper();
        }
      };
      //////////////////////////////////////////////////////////////////
      //////////////////////////////////////////////////////////////////
      //////////////////////////////////////////////////////////////////
      // change "dealersRow" and "dealers" to your section name and
      // swiper button class name
      var enableSwiper = function () {
        mySwiper = new Swiper('.contentRow .swiper-container', {
          navigation: {
            nextEl: '.contentRow .swiper-button-next.cta',
            prevEl: '.contentRow .swiper-button-prev.cta',
          },
          lazy: {
            enabled: true,
          },
        });
      };
      //////////////////////////////////////////////////////////////////
      //////////////////////////////////////////////////////////////////
      //////////////////////////////////////////////////////////////////
      // keep an eye on viewport size changes
      breakpoint.addListener(breakpointChecker);
      // kickstart
      breakpointChecker();
    })(); /* IIFE end */
  }

  // *************************************************************************************************
  //	Footer
  // *************************************************************************************************

  // START -> MOBILE FOOTER MENU SLIDE
  if ($(window).width() <= 768) {
    $('.footerTop .widget').on('click', function () {
      $(this).toggleClass('active').siblings().removeClass('active');
      $(this).find(' > div').slideToggle().parent().siblings().find(' > div').slideUp();
    });
  }
  // END -> MOBILE FOOTER MENU SLIDE

  // *************************************************************************************************
  //  Language Toggle
  // *************************************************************************************************
  (function () {
    /*
     * check current language and set temp var for new language
     */
    var toggle_language = function () {
      if (DealerInspireCookie.ReadCookie('current_language') === 'en') {
        new_language = 'es';
      } else {
        new_language = 'en';
      }
    };

    /*
     * use temp var to set url and new cookie
     */
    var set_language_url = function () {
      var new_url = new URL(location.href);

      if (new_language === 'es') {
        new_url.searchParams.set('langtarget', 'es');
      } else {
        new_url.searchParams.set('langtarget', 'en');
      }

      DealerInspireCookie.CreateCookie('current_language', new_language, 1);

      history.pushState(null, '', new_url);
      window.location.href = new_url.href;
      setTimeout(function () {
        window.location.reload();
      });
    };

    var set_languge_text = function () {
      default_text = 'Español';
      english_text = 'English';
      text_container = '.language-toggle--text';
      if (new_language == 'es') {
        $(text_container).text(english_text);
      } else {
        $(text_container).text(default_text);
      }
    };

    var new_language = '';

    var init = function () {
      if (DealerInspireCookie.ReadCookie('current_language') !== null) {
        new_language = DealerInspireCookie.ReadCookie('current_language');
      } else {
        new_language = 'en';
        DealerInspireCookie.CreateCookie('current_language', new_language, 1);
      }

      set_languge_text();

      $('.header__language-toggle a').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        //check if 3rd party tool is loaded
        if (typeof firebase !== 'undefined') {
          toggle_language();
          set_language_url();
        } else {
          alert('Languages Not Found');
        }
      });
    };

    init();
  })();

  // *************************************************************************************************
  //  Blog
  // *************************************************************************************************

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
});
