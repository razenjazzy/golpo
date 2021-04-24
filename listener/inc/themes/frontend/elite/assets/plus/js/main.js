(function($){
	"use strict";
	jQuery(document).on('ready', function () {

        // Mean Menu
		jQuery('.mean-menu').meanmenu({
			meanScreenWidth: "991"
        });
        
        // Header Sticky
		$(window).on('scroll',function() {
            if ($(this).scrollTop() > 120){  
                $('.uxhaven-nav').addClass("is-sticky");
            }
            else{
                $('.uxhaven-nav').removeClass("is-sticky");
            }
        });

        // Home Slides
		$('.home-slides').owlCarousel({
			loop: true,
			nav: false,
            dots: true,
            animateOut: 'fadeOut',
			autoplayHoverPause: true,
            autoplay: true,
            items:1,
            navText: [
                "<i class='pe-7s-angle-left'></i>",
                "<i class='pe-7s-angle-right'></i>"
            ],
        });
        $(".home-slides").on("translate.owl.carousel", function(){
            $(".home-slides .main-banner-content p").removeClass("animated fadeInDown").css("opacity", "0");
            $(".home-slides .main-banner-content h1").removeClass("animated fadeInUp").css("opacity", "0");
            $(".home-slides .main-banner-content span").removeClass("animated zoomIn").css("opacity", "0");
            $(".home-slides .main-banner-content .btn").removeClass("animated fadeInDown").css("opacity", "0");
        });
        $(".home-slides").on("translated.owl.carousel", function(){
            $(".home-slides .main-banner-content p").addClass("animated fadeInDown").css("opacity", "1");
            $(".home-slides .main-banner-content h1").addClass("animated fadeInUp").css("opacity", "1");
            $(".home-slides .main-banner-content span").addClass("animated zoomIn").css("opacity", "1");
            $(".home-slides .main-banner-content .btn").addClass("animated fadeInDown").css("opacity", "1");
        });
        
        // Popup Gallery
		$('.popup-btn').magnificPopup({
            type: 'image',
            gallery:{
                enabled:true
            }
		});

		// Featured Services Slides
		$('.featured-services-slides').owlCarousel({
			loop: true,
			nav: true,
			dots: false,
			autoplayHoverPause: true,
			autoplay: true,
            navText: [
                "<i class='pe-7s-angle-left'></i>",
                "<i class='pe-7s-angle-right'></i>"
            ],
			responsive:{
                0: {
                    items:1,
                },
                768: {
                    items:2,
                },
                1200: {
                    items:3,
				}
            }
        });

        // Tabs
        (function ($) {
            $('.tab ul.tabs').addClass('active').find('> li:eq(0)').addClass('current');
            $('.tab ul.tabs li a').on('click', function (g) {
                var tab = $(this).closest('.tab'), 
                index = $(this).closest('li').index();
                tab.find('ul.tabs > li').removeClass('current');
                $(this).closest('li').addClass('current');
                tab.find('.tab_content').find('div.tabs_item').not('div.tabs_item:eq(' + index + ')').slideUp();
                tab.find('.tab_content').find('div.tabs_item:eq(' + index + ')').slideDown();
                g.preventDefault();
            });
        })(jQuery);
        
        // Feedback Slides
		$('.feedback-slides').owlCarousel({
			loop: true,
			nav: false,
			dots: true,
			autoplayHoverPause: true,
            autoplay: true,
            items:1,
            navText: [
                "<i class='pe-7s-angle-left'></i>",
                "<i class='pe-7s-angle-right'></i>"
            ],
        });

        // Services Slides
		$('.services-slides').owlCarousel({
			loop: true,
			nav: true,
			dots: false,
			autoplayHoverPause: true,
			autoplay: true,
            navText: [
                "<i class='pe-7s-angle-left'></i>",
                "<i class='pe-7s-angle-right'></i>"
            ],
			responsive:{
                0: {
                    items:1,
                },
                576: {
                    items:2,
                },
                768: {
                    items:2,
                },
                1200: {
                    items:2,
                },
                1400: {
                    items:3,
				}
            }
        });

        // Blog Slides
		$('.blog-slides').owlCarousel({
			loop: true,
			nav: false,
			dots: true,
			autoplayHoverPause: true,
			autoplay: true,
            navText: [
                "<i class='fas fa-angle-left'></i>",
                "<i class='fas fa-angle-right'></i>"
            ],
			responsive:{
                0: {
                    items:1,
                },
                768: {
                    items:2,
                },
                1200: {
                    items:3,
				}
            }
        });

        // Team Slides
		$('.team-slides').owlCarousel({
			loop: true,
			nav: true,
			dots: false,
			autoplayHoverPause: true,
			autoplay: true,
            navText: [
                "<i class='pe-7s-angle-left'></i>",
                "<i class='pe-7s-angle-right'></i>"
            ],
			responsive:{
                0: {
                    items:1,
                },
                576: {
                    items:2,
                },
                768: {
                    items:2,
                },
                1200: {
                    items:4,
				}
            }
        });

        // Go to Top
        $(function(){
            //Scroll event
            $(window).on('scroll', function(){
                var scrolled = $(window).scrollTop();
                if (scrolled > 300) $('.go-top').fadeIn('slow');
                if (scrolled < 300) $('.go-top').fadeOut('slow');
            });  
            //Click event
            $('.go-top').on('click', function() {
                $("html, body").animate({ scrollTop: "0" },  500);
            });
        });
        
        // Subscribe form
		$(".newsletter-form").validator().on("submit", function (event) {
			if (event.isDefaultPrevented()) {
			// handle the invalid form...
				formErrorSub();
				submitMSGSub(false, "Please enter your email correctly.");
			} else {
				// everything looks good!
				event.preventDefault();
			}
		});
		function callbackFunction (resp) {
			if (resp.result === "success") {
				formSuccessSub();
			}
			else {
				formErrorSub();
			}
		}
		function formSuccessSub(){
			$(".newsletter-form")[0].reset();
			submitMSGSub(true, "Thank you for subscribing!");
			setTimeout(function() {
				$("#validator-newsletter").addClass('hide');
			}, 4000)
		}
		function formErrorSub(){
			$(".newsletter-form").addClass("animated shake");
			setTimeout(function() {
				$(".newsletter-form").removeClass("animated shake");
			}, 1000)
		}
		function submitMSGSub(valid, msg){
			if(valid){
				var msgClasses = "validation-success";
			} else {
				var msgClasses = "validation-danger";
			}
			$("#validator-newsletter").removeClass().addClass(msgClasses).text(msg);
		}
		// AJAX MailChimp
		$(".newsletter-form").ajaxChimp({
			url: "https://envytheme.us20.list-manage.com/subscribe/post?u=60e1ffe2e8a68ce1204cd39a5&amp;id=42d6d188d9", // Your url MailChimp
			callback: callbackFunction
        });
        
        // FAQ Accordion
        $(function() {
            $('.accordion').find('.accordion-title').on('click', function(){
                // Adds Active Class
                $(this).toggleClass('active');
                // Expand or Collapse This Panel
                $(this).next().slideToggle('fast');
                // Hide The Other Panels
                $('.accordion-content').not($(this).next()).slideUp('fast');
                // Removes Active Class From Other Titles
                $('.accordion-title').not($(this)).removeClass('active');		
            });
        });

    });
    
    // Odometer JS
    jQuery(document).on('ready', function() {
        $('.odometer').appear(function(e) {
            var odo = $(".odometer");
            odo.each(function() {
                var countNumber = $(this).attr("data-count");
                $(this).html(countNumber);
            });
        });
    });

	// WOW JS
	$(window).on ('load', function (){
        if ($(".wow").length) { 
            var wow = new WOW({
            boxClass: 'wow', // animated element css class (default is wow)
            animateClass: 'animated', // animation css class (default is animated)
            offset: 20, // distance to the element when triggering the animation (default is 0)
            mobile: true, // trigger animations on mobile devices (default is true)
            live: true, // act on asynchronously loaded content (default is true)
          });
          wow.init();
        }
	});
	
	// Preloader Area
	jQuery(window).on('load', function() {
	    $('.preloader').fadeOut();
	});
}(jQuery));