(function ($) {
	"use strict"
	var PATH = {};
	/******************** 1. PRELOADER ********************/
	PATH.preLoader = function () {
        // will first fade out the loading animation
        $(".status").fadeOut();
        // will fade out the whole DIV that covers the website.
        $(".preloader").delay(1000).fadeOut("slow");	
	}
	
	/******************** 2. MASSONARY JS ********************/
	PATH.masonaryGrid = function (){
			$('.grid').masonry({
			itemSelector: '.grid-item',
			columnWidth: '.grid-item',
		});
	}
	

	/******************** 4. NAV COLLAPSE ********************/
	PATH.MenuClose = function () {
		$('.navbar-nav .nav-link').on('click', function () {
			var toggle = $('.navbar-toggler').is(':visible');
			if (toggle) {
				$('.navbar-collapse').collapse('hide');
			}
		});
	}

	
	/******************** 7. STELLAR JS ********************/
	PATH.stellerJs = function () {
        $(window).stellar({
            horizontalScrolling: false,
        });
	}
			
	/******************** 13. SCREENSHOTS POP-UP ********************/
	PATH.ssPopUp = function () {
        $('.zoom-gallery').magnificPopup({
            delegate: 'a',
            type: 'image',
            closeOnContentClick: false,
            closeBtnInside: false,
            mainClass: 'mfp-with-zoom mfp-img-mobile',
            gallery: {
            enabled: true,
            },
            zoom: {
                enabled: true,
                duration: 300, // don't foget to change the duration also in CSS
                opener: function(element) {
                    return element.find('img');
                }
            }
        });
	}
	/******************** 14. VIDEO POP-UP ********************/
	PATH.videoModal = function () {
		$(".js-modal-btn").modalVideo();
	}

	/******************** 19. SCROLL TO UP ********************/
	PATH.scrollToUp = function () {
		$(window).on('scroll', function() {
			if ($(this).scrollTop() > 500) {
				$('.scrollup').fadeIn();
			} else {
				$('.scrollup').fadeOut();
			}
		});
		$('.scrollup').on("click", function() {
			$("html, body").animate({
				scrollTop: 0
			}, 800);
			return false;
		});	
	}
				
	/* Document ready function */
	
	$(function(){
		PATH.MenuClose();
		PATH.stellerJs();
		PATH.ssPopUp();
		PATH.videoModal();
		PATH.scrollToUp();
	});
	
	/* Window on scroll function */
	$(window).on("scroll", function () {
		
	});

	/* Window on load function */
	$(window).on('load', function () {
		PATH.preLoader();
		PATH.masonaryGrid();
	});
	
	
	$(window).scroll(function() {    
		var scroll = $(window).scrollTop();

		if (scroll >= 60) {
			$(".header-nav").addClass("nav-sticky");
		}else{
			$(".header-nav").removeClass("nav-sticky");
		}
	});
	
	var type1 = window.location.hash.substr(1);
	if(type1!=""){		
		$('html,body').animate({		
			scrollTop: $("#"+type1).offset().top-70	 
		}, 1500);
	}		
	$('.nav-link').click(function() {	
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {		
			var target = $(this.hash);		
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');		
			if (target.length) {			
				$('html, body').animate({		
					scrollTop: target.offset().top-70			
				}, 1500);	
				
				return false;	
			}		
		}	
	});
	
})(jQuery);
