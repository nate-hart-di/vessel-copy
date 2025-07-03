jQuery(document).ready(function($) {
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

  $('.nearly-new h2').addClass('nearly_new');

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
// *************************************************************************************************
//  GLOBAL
// *************************************************************************************************

/*
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
*/

    //  Clicking outside of the mobile side menu closes it
  $('#footer, #videobanner, .menu-top').click(function () {
    $.sidr('close', 'mobile-menu');
  });


  var menuItem = $('#menu-top-menu.nav .menu-item a:contains("New")').eq(0)

  $(menuItem).click(function() {
    console.log('click')
    $('#main-navbar ul.nav li.menu-item:contains("New")').addClass('new');
    $('#main-navbar ul.nav li.menu-item:contains("New")').toggleClass('open');
    $('#main-navbar ul.nav').addClass('open');
    $('#menu_modelRow').addClass('open');
  });

  $('#menu-top-menu li.menu-item a:not(:contains("New"))').click(function() {
    $('#menu-top-menu li.menu-item:contains("New")').removeClass('open');
    $('#main-navbar ul.nav').removeClass('open');
  });

  $(document).on('click', function (e) {
    $('#main-navbar ul.nav li.menu-item:contains("New") a').removeClass('open');
    $('#main-navbar ul.nav li.menu-item:contains("New") a').parent().removeClass('open');
  });


  if ($('#count-number').html() == 0) {
    $('#vehicle-count-overview-number').hide();
  }

  //Close the main menu if you click on the rotating logo just to the right of the main logo
  $('.logo-swap').click(function(){
    var navs = $('.nav');

    $.each(navs, function (nav) {
      if ($(this).hasClass('logo-swap')) {
        return;
      }
      $(this).removeClass('active open');
    });
  });

  if($(window).width() < 768) {
    if(isMobile.iOS())
      $('.fj-drive .android').hide();
    else
      $(".fj-drive .iOS").hide();
  }
// *************************************************************************************************
//  VRP
// *************************************************************************************************

  if(isVRP.any()) {
    $('body').on('vrp-ready vrp-ajax-complete', function() {
      $('.vehicle').each(function(i, obj) {
          var cta = $(this).find('.button-bar .primary-cta .button-form, .button-bar .below-price-cta');
          var finance_button = $(this).find(".button-bar .button.finance-link");
          var location = $(this).find('.vehicle-price');
          $(cta).addClass("block green button button-primary");
          $(location).append(cta.removeClass("hidden-all"));
      });
      if( window.outerWidth < 768 && $('.show-filters-button').length === 0) {
        var sort = $('.sorting-options');
        $(sort).removeClass("hidden-xs hidden-phone").append("<a trid='c6dc6cf3382442beba649f' trc class='button primary-button show-filters-button align-left' style='margin:0'>Filter Results</a>").find('select').css({width:"40%"});
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
  }

  jQuery(function(){
    var serviceDirections = "https://www.google.com/maps/dir/''/949+North+Elston+Avenue,+Chicago,+IL+60642";
    $('.mobile-tab-content-inside .callus a.button.primary-button:last-child').remove();
    $(".mobile-tab-content-inside .callus .phone").wrap('<a trid="1ac59902cd44490ea134b9" trc data-phone="Sales" href="tel:312-281-7856"></a>');
    $('<div style="height: 1px; margin-top: 10px; margin-bottom: 15px; background-color: #ccc;"></div><span class="mobile-service"><p class="mobile-service-title">Service Department</p><div class="callus"><p><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span><span class="phone"><a trid="ffaa7d82998d42e0bffdba" trc data-phone="Service" href="tel:773-993-1514">(773)-993-1514</a></span></p></div></span><div class="findus"><p><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> <span class="address">949 North Elston Avenue, Suite 2 • Chicago, IL, 60642</span></p><a trid="7fd1b8a42cbb4217a93c4a" trc target="_blank" itemprop="directions" href="' + serviceDirections + '" class="button primary-button">Get Directions</a></div>').appendTo($('.mobile-tab-content-inside .findus'));
    $(".mobile-tab-content-inside .mobile-service-title").css({ "display": "inline-block" });
  });

  // Moved lease button from shopping tools to details-page-ctabox
  $('.shopping-tools-wrapper .lease-box').insertAfter('#details-page-ctabox .maincta-row');
  $('#details-page-ctabox .lease-box a').addClass('button');

  // Moving custom CTA buttons around #00060105
  if (isVDP.hotwheels()) {
    $('#ctabox-custom-ctas .col-md-6').removeClass('col-md-6').addClass('col-md-12');
    $('#ctabox-custom-ctas .test-drive-cta').appendTo('.maincta-row.ctabox-row');
    $('#ctabox-custom-ctas').show();
  }
  // End #00060105

// *************************************************************************************************
//  INNER PAGES
// *************************************************************************************************

  // JS for custom service/parts coupon template disclaimer
  $('.specialCoupon .view-disclaimer-link').on('click', function(e) {
    var disclaimer = $(this).parents('.specialCoupon').find('.disclaimer');
    $(disclaimer).addClass('open');
  });
  $('.specialCoupon .disclaimer .fa-close').on('click', function(e){
    $(this).parents('.disclaimer').removeClass("open");
  });

    //Change address on Service Specials page

  if ($('body').hasClass('page-id-16139')) {
    var addresses = $('.printSection .address');
    $.each(addresses, function (address) {
      var newAddress = '<strong>Mercedes-Benz of Chicago</strong><br>949 North Elston Avenue, Suite 2 Chicago, IL, 60642 <br>Service: (312) 614-1217'
      $(this).html(newAddress);
    });
  }



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

    $('body').on('mapbox_loaded_map3', function(e, map, nodeName) {
      // modify or add map options to `map` variable
      // add a marker
      var coordinates = [
          [41.8995044, -87.6565204, '/wp-content/themes/DealerInspireDealerTheme/images/map-marker.png'],
          [41.9410636, -87.6662115]
      ]

      function setMarker(coordObject){
          var marker,
              img = new Image(),
              url = coordObject[2];

          img.addEventListener("load", function(){
              marker = L.icon({
                  iconUrl: url,
                  iconSize: [this.naturalWidth, this.naturalHeight],
                  iconAnchor: [(this.naturalWidth/2), this.naturalHeight],
              });
              L.marker([coordObject[0], coordObject[1]], {icon: marker}).addTo(map);
          });
          img.src = url;
      }

      coordinates.forEach(function(coordObject, i) {
          setMarker(coordObject)
      })

      map.fitBounds(
          [
              coordinates
          ]
      )

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


});
