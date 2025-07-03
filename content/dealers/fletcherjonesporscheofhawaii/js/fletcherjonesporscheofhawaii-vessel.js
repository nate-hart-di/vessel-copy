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

    //START - CUSTOM CSS ANIMATION ON PAGE LOAD
    setTimeout(function() {
          jQuery('.fall-item').addClass('active');
    }, 200);
    //END - CUSTOM CSS ANIMATION ON PAGE LOAD

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
                $(sort).removeClass("hidden-xs hidden-phone").append("<a trid='0cea2590080a4bcc94b85b' trc class='button primary-button show-filters-button align-left' style='margin:0'>Filter Results</a>").find('select').css({width:"40%"});
                $('.show-filters-button').click(function(e) {
                    $('.mobile-tab-1 .mobile-tab-label').trigger('click');
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

//PAYMENT OVERLAY
    $(".menu-top .menu-search a").data("toggle-content", "#algolia-overlay");
    $(".menu-top .menu-phone a").data("toggle-content", "#contact-overlay");

	$('.overlay-toggle, .menu-top .menu-search a, .menu-top .menu-phone a').click(function(e){
		e.preventDefault();
		var content = $(this).data("toggle-target");
		$("#search-overlay").addClass("open");
		$("body").css("overflow", "hidden");
		$("body").trigger("homepage-usp-shown");
		if($(this).data("toggle-content") == "#algolia-overlay" ){
			$('#algolia-overlay').removeClass('hidden-all');
			$('#algolia-overlay').addClass('active');
	    }
	    else {
			$("#search-overlay .overlay-content").html($(content).clone().css("display", "block"));
	    }
	});

	$(".close-overlay").click(function() {
    	closeOverlay();
	});


	$(window).keypress(function(e) {
		if(e.keyCode == 27 && $('#search-overlay.open').length > 0) {
			closeOverlay();
		}
	});

	$("body").on(
	    'click',
	    function(e) {
    	    if($(e.target).attr("id") == 'search-overlay') {
    	        closeOverlay();
            }
	    }
    );

    function closeOverlay() {
      $('#search-overlay').removeClass("open");
		  $('body').css('overflow', 'visible');
		  $("body").trigger("homepage-usp-hidden");

      $("#algolia-overlay").addClass("hidden-all");
      $("#algolia-overlay").removeClass("active");
    }



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
    }

    if($(window).width() < 768) {
        if(isMobile.iOS())
            $('.fj-drive .android').hide();
        else
            $(".fj-drive .iOS").hide();
    }

    	// Rotate through Smart and Sprinter logos in header
	var rotatingImgs = $(".rotating-logos img");
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

	//  Clicking outside of the mobile side menu closes it
    $('#footer, #videobanner, .menu-top').click(function () {
		$.sidr('close', 'mobile-menu');
    });

    /* Added 10-08-2015: Change phone number on mobile */
	if(isSmallMobile.any()) {
		var phone_hypen = "510-500-9069";
		var phone_dot = "510.500.9069";
		var phone_raw = "5105009069";

		var phone_el = ['span.phone-sales','li.phone-sales', '.phone-main', '.call-us', '.mobile-tab-content-inside .phone'];
		$.each(phone_el, function(i, el){
			if( $(el).length && typeof $(el) != 'undefined' ){
				var dealer_phone = $(el).html().replace(/((\(\d{3}\) ?)|(\d{3}-))?\d{3}-\d{4}/, phone_hypen);
				$(el).html(dealer_phone);
			}
		});

		$('a[href^="tel:"]').each(function(i, phone){
			var phone_href = $(phone).attr('href').replace(/(?:\d{3}(?:\d{7}|(\-|\.)\d{3}(\-|\.)\d{4}))|(?:\(\d{3}\)(?:(\-|\.)\d{3}(\-|\.))|(?: \d{3} )\d{4})/, phone_raw);
			$(phone).attr('href', phone_href);
		});
	}


	// CASE #38978 --- VRP/VDP CTA BUTTONS //
	jQuery(function(){
		vrp_eprice();
		jQuery("body").live("vrp-ajax-complete",function(){
			vrp_eprice();
		});
	})
	vrp_eprice = function(){
		jQuery(".results_table .vehicle").each(function(index, element) {
			jQuery(this).find(".primary-cta").appendTo(jQuery(this).find(".vehicle-price"));
		});
	}

	jQuery(function(){
		vrp_financing();
		jQuery("body").live("vrp-ajax-complete",function(){
			vrp_financing();
		});
	})
	vrp_financing = function(){
		jQuery(".results_table .vehicle").each(function(index, element) {
			jQuery(this).find(".financing-button").appendTo(jQuery(this).find(".vehicle-price"));
		});
	}

	$(".inStockCTAContainer .cta-button").after($(".third-party-shopping-box .financing-button"));

	//Service menu customizations
	$('.parts-link').wrapAll('<div class="service-menu-right" />');
	$('<h2 class="parts-link">Parts</h2>').insertBefore('li#menu-item-18808');

    // Add day of week to header hours
    $(".dayOW").appendTo(".dealer-hours span.department");

    $('#menu-top-menu li.menu-item a:contains("New")').click(function() {
        // $('#main-navbar ul.nav li.menu-item:contains("New")').addClass('new');
        // $(this).toggleClass('open');
        // $('#main-navbar ul.nav li.menu-item:contains("New")').toggleClass('open');
        $('#main-navbar ul.nav').addClass('open');
        $('#menu_modelRow').addClass('open');
      });

          $(function() {
            var owl =  jQuery("#sedanModels").owlCarousel({
              autoPlay: 7000,
              slideSpeed: 1000,
              navigation: true,
              items : 5,
              itemsDesktop : [1024,3],
              itemsDesktopSmall: [979,3],
              itemsTablet: [767,1],
              itemsMobile: [320,1]
            });
          });

          $(function() {
            var owl =  jQuery("#coupeModels").owlCarousel({
              autoPlay: 7000,
              slideSpeed: 1000,
              navigation: true,
              items : 5,
              itemsDesktop : [1024,3],
              itemsDesktopSmall: [979,3],
              navigationText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
              itemsTablet: [767,1],
              itemsMobile: [320,1]
            });
            $("#coupeModels .owl-next, #coupeModels .owl-prev").on("click",function(e){
                e.stopPropagation();
                e.preventDefault();
              });
          });

          $(function() {
            var owl =  jQuery("#suvModels").owlCarousel({
              autoPlay: 7000,
              slideSpeed: 1000,
              navigation: true,
              items : 5,
              itemsDesktop : [1024,3],
              itemsDesktopSmall: [979,3],
              itemsTablet: [767,1],
              itemsMobile: [320,1]
            });
          });

          $(function() {
            var owl =  jQuery("#convertModels").owlCarousel({
              autoPlay: 7000,
              slideSpeed: 1000,
              navigation: true,
              items : 5,
              itemsDesktop : [1024,3],
              navigationText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
              itemsDesktopSmall: [979,3],
              itemsTablet: [767,1],
              itemsMobile: [320,1]
            });
            $("#convertModels .owl-next, #convertModels .owl-prev").on("click",function(e){
                e.stopPropagation();
                e.preventDefault();
              });
          });

          $(function() {
            var owl =  jQuery("#hybridModels").owlCarousel({
              autoPlay: 7000,
              slideSpeed: 1000,
              navigation: true,
              items : 3,
              itemsDesktop : [1024,3],
              itemsDesktopSmall: [979,3],
              itemsTablet: [767,1],
              itemsMobile: [320,1]
            });
          });

          $("#modelTab button").click(function(e){
            e.stopPropagation();
            $(this).tab('show');

          });

          $('#menu_modelRow').insertBefore('#header .menu-item:contains("New") .header-dropdown.dropdown-full .header-dropdown-container');

});
