////////////////////////////////////////
// File birdfield.js.
jQuery(function() {

	jQuery( window ).load(function() {
        // init fixed navigation
        jQuery('#menu-wrapper').removeClass('fixed');

        // Hero Slider
        var swiper = new Swiper('.home .swiper-container', {
            loop: true,
            autoHeight:  true,
            effect: 'fade',
            speed: 500,
            autoplay: {
                delay: 7000,
			},
			pagination: {
				el: '.swiper-pagination',
				type: 'bullets',
			}			
        });

		// link in page slowly
		/*
		jQuery('a[href^="#"]').click(function () {
			var href = jQuery(this).attr("href");
			var target = jQuery(href == "#" || href == "" ? 'html' : href);
			if (1 < href.length) {
				// has anchor
				var top = target.offset().top - 80;
				jQuery('html,body').delay(100).animate({ scrollTop: top }, "slow");
				return false;
			}
		}); */
		
        // close small menu
        jQuery("#menu-wrapper .close").click(function () {
            jQuery("#small-menu").click();
            return false;
        });

		// Initialize bogo-language-switcher
		jQuery( '.bogo-language-switcher' ).insertAfter( '.menu .language a' ).css({ 'display': 'block' });
	});

	// Windows Scroll
	var totop = jQuery( '#back-top' );
	totop.hide();
	jQuery( window ).scroll(function () {
		// back to pagetop
		var scrollTop = parseInt( jQuery( this ).scrollTop() );
		if ( scrollTop > 800 ) totop.fadeIn(); else totop.fadeOut();

		// mini header with scroll
		var header_clip = jQuery( '#header' ).css( 'clip' );
		if( -1 == header_clip.indexOf( 'rect' ) ) {
			if (scrollTop > 200) {
				jQuery('body').addClass('fixed-header');
			}
			else {
				jQuery('body').removeClass('fixed-header');
			}

			if (scrollTop > 300) {
				jQuery('.fixed-header #header').addClass('show');
			}
			else {
				jQuery('.fixed-header #header').removeClass('show');
			}
		}
	});

	// back to pagetop
	totop.click(function () {
		jQuery('body, html').animate({ scrollTop: 0 }, 500);
		return false;
	});

	var swiper = setos_set_books_gallery();
});

////////////////////////////////////////
// Navigation for mobile
window.addEventListener('DOMContentLoaded', function (e) {

    var $toggle = document.getElementById('small-menu');
    $toggle.addEventListener('click', function (e) {
        jQuery("#small-menu").toggleClass("open");
        jQuery("body").toggleClass("drawer-open");

        if (jQuery("body").hasClass('drawer-open')) {
            jQuery('#menu-wrapper').scrollTop(0);
        }
    });
});

////////////////////////////////////////
// set books swipe gallery
function setos_set_books_gallery() {

	var has_books_gallery = false;

	if (jQuery('figure.wp-block-gallery').length) {
		// add swiper class
		jQuery('.wp-block-gallery').addClass('books-gallery');

		// remove block gallery class
		jQuery('.books-gallery').removeClass('wp-block-gallery').addClass('swiper-container');
		jQuery('.books-gallery').find('ul').removeClass('blocks-gallery-grid').addClass('swiper-wrapper');
		jQuery('.books-gallery').find('li').removeClass('blocks-gallery-item').addClass('swiper-slide');

		// set thumbnail
		jQuery('.books-gallery').after('<div class="books-thumbnail swiper-container"><ul class="swiper-wrapper"></ul></div>');
		jQuery('.books-gallery .swiper-wrapper li').each(function (index, element) {
			var url = jQuery(this).find('img').attr('src');
			jQuery('.books-thumbnail ul').append('<li class="swiper-slide"><img src="' + url + '" alt=""></li>');

			jQuery(this).find('a').attr('data-fancybox', 'gallery');
		})

		has_books_gallery = true;
	}
	else if (jQuery('.single-books ul.wp-block-gallery, single-post ul.wp-block-gallery').length) {
		// previous wpvarsion
		jQuery('.wp-block-gallery').wrapAll('<div class="books-gallery"></div>'); jQuery('.books-gallery').addClass('swiper-container');

		// remove block gallery class
		jQuery('.books-gallery').find('ul').removeClass('wp-block-gallery').addClass('swiper-wrapper');
		jQuery('.books-gallery').find('li').removeClass('blocks-gallery-item').addClass('swiper-slide');

		// set thumbnail
		jQuery('.books-gallery').after('<div class="books-thumbnail"><ul></ul></div>');
		jQuery('.books-gallery .swiper-wrapper li').each(function (index, element) {
			var url = jQuery(this).find('a[href]').attr('href');
			jQuery('.books-thumbnail ul').append('<li><img src="' + url + '" alt=""></li>');

			jQuery(this).find('a').attr('data-fancybox', 'gallery');
		})

		has_books_gallery = true;
	}

	if (has_books_gallery) {
		// navigation
		jQuery('.swiper-container').append('<div class="swiper-button-prev swiper-button-white"></div><div class= "swiper-button-next swiper-button-white" ></div >');

		jQuery('.books-gallery').append('<div class="swiper-scrollbar"></div>');

		// thumbnail Slider
		var swiper_thumbs = new Swiper('.books-thumbnail', {
			slidesPerView: 4,
			spaceBetween: 5,
			slideToClickedSlide: true,
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			}, 
			breakpoints: {
				660: {
					slidesPerView: 6,
				},
			}
		});

		// Photo Slider
		var swiper_books = new Swiper('.books-gallery', {
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			scrollbar: {
				el: '.swiper-scrollbar',
			},
			thumbs: {
				swiper: swiper_thumbs
			}
		});

		// Zoom
		jQuery('[data-fancybox="gallery"]').fancybox({
			buttons: [
				'close'
			],
		});

		return swiper_books;
	}

	return false;
}