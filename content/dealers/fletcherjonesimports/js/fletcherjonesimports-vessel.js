jQuery(document).ready(function($) {

  $('.blog .featured-carousel, .category .featured-carousel').owlCarousel({
    loop:true,
    margin:10,
    navigation:true,
    navigationText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
    items: 4,
    itemsDesktop: [1200,3],
    itemsDesktopSmall: [1024,2],
    itemsTablet: [767,1],
  });
  
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

  if(isVRP.any()) {
    $('body').on('vrp-ready vrp-ajax-complete', function() {
      $('.vehicle').each(function(i, obj) {
        if($(this).find(".vehicle-price .primary-cta").length == 0) {
          var mobile = $('.visible-xs .vehicle').eq(i);
          var cta = $(this).find('.button-bar .primary-cta .button-form');
          var finance_button = $(this).find(".button-bar .button.finance-link");
          var location = $(this).find('.vehicle-price');
          var mLocation = $(mobile).find('.vehicle-price');
          $(cta).addClass("block green button button-primary").appendTo( $(mobile).find('.vehicle-price') );
          $(mLocation).append($(finance_button).removeClass("hidden-all")).find(".price-top").prepend( $(".vehicle-title h2 a", mobile).clone().addClass("pull-right").text("View Details").css({fontSize:"16px", fontWeight:"bold"}) );
          $(location).append(cta,finance_button.removeClass("hidden-all"));
        }
      });
      if($(document).width() < 768 && $('.show-filters-button').length == 0) {
        var sort = $('.sorting-options');
        $(sort).removeClass("hidden-xs hidden-phone").append("<a trid='b032cf81ce3f49cd89b60e' trc class='button primary-button show-filters-button align-left' style='margin:0'>Filter Results</a>").find('select').css({width:"40%"});
        $('.show-filters-button').click(function(e) {
          $('.mobile-tab-1 .mobile-tab-label').trigger('click');
        });
      }
      if($(document).width() > 1024) {
        $('.roadster-btn').vrpTextHover({  
          text: '<p>Create your own lease or finance quote including special e-pricing.</p>', 
          });
      }
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
  // $("#search-overlay .overlay-content").html("");
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

  //
  //    Hotwheels Custom Scripts
  //
  if(isVDP.hotwheels()) {
    $('body').on('click', "#ctabox-premium-features .features-link", function(e) {
      $("#factory_options .panel-title a").trigger("click");
    });
    $('#mini-header').css("display", "none");
    $('.details-page-titlewrap .details-page-row').removeClass("no-spacer");

    $('.cta-caption > p:first').insertAfter(".disclaimer-small > p:first");

    $(".panel-title a").not(".collapsed").addClass('collapsed').parents('.panel').find('.panel-collapse').removeClass('in');
    $(window).resize();

    if($(window).width() > 1024) {
      $('.roadster-button').vdpTextHover({    
        text: '<p>Create your own lease or finance quote including special e-pricing.</p>',   
        });
    }
  }

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

  //CTABOX PREMIUM OPTIONS
  $('#ctabox-premium-features .features-link').click(function() {
    $(this).parent().toggleClass('open');
  });

  //Move custom CTA for G-Class & GT models
  if ($('body').hasClass('page-vehicle-display-page')) {
    $('div#inquire-button').insertAfter('.maincta-row.ctabox-row');
    $('div#inquire-button a').css('display', 'block');
  }

  // Add day of week to header hours
  //$(".dayOW").appendTo(".dealer-hours span.department");

  if ($('#count-number').html() == 0) {
    $('#vehicle-count-overview-number').hide();
  }

  jQuery('body').on('vrp-ajax-complete vrp-ready', function() {

    var vehicle = $('.vehicle');

    $(vehicle).each(function(){

      var gylonBtn = $(this).find('.lease-for-less');

      var form = $(this).find('.button-bar-item.hidden-always a');

      $(gylonBtn).click(function (e) {
        $(form).click();
      })

      $(this).find('.inquire-cta').appendTo($(this).find('.vehicle-price'));

    });

  });
  $("#vehicleDetails .shopping-tool.button.cta-button.inquire").insertAfter(".advanced-pricing-stack");




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

/**
 * SC96962 - The Make was not showing up in the search title on the VRP Page. This function will put in the Make
 * if it is not passed in
 * @param params
 */
function vrp_search_page_title_params(params){

    var hasOnlyNewType = 0,
        doesNotHaveMake = 1;

    for (var x in params) {

        if (x === 'type[]' && params[x].length === 1) {
            if (params[x][0] === 'New') {
                hasOnlyNewType = 1;
            }
        }

        if (x === 'make[]' || x === 'make') {
            doesNotHaveMake = 0;
        }
    }

    if ( hasOnlyNewType === 1 && doesNotHaveMake === 1) {
        params['make[]'] = ['Mercedes-Benz'];

    }
}
//Compile me please
