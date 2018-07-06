////////////////////////////////////////
// File birdfield.js.
jQuery(function() {

	jQuery( window ).load(function() {

		// home grid
		jQuery( "#blog ul li" ).tile( 3 );

		// Browser supports matchMedia
		if ( window.matchMedia ) {
			// MediaQueryList
			var mq = window.matchMedia( "( min-width: 930px )" );

			// MediaQueryListListener
			var birdfieldHeightCheck = function ( mq ) {
				if ( mq.matches ) {
					// tile for home
					jQuery( "#blog ul li" ).tile(3);
				}
				else {
					// cansel
					jQuery( '#blog ul li' ).css( 'height', 'auto' );
				}
			};

			var birdfield_AdjustHeader = function() {
				var headerHeight = parseInt( jQuery( '#header' ).height() );
				if( 80 < headerHeight ){
					// so many Navigation
					jQuery( '.wrapper' ).addClass( 'many-navigation' );
					jQuery( '.wrapper' ).removeClass( 'fixed-header' );
				}
			}

			// Add listener HeightChec
			mq.addListener( birdfieldHeightCheck );
			birdfieldHeightCheck( mq );

			// Add listener navigation height
			mq.addListener( birdfield_AdjustHeader );
			birdfield_AdjustHeader();
		}
		else {
			// Browser doesn't support matchMedia
			jQuery( "#blog ul li" ).tile( 3 );
		}

		// Header Slider
		jQuery( '.slider' ).birdfield_Slider();

		// gallery columns tile
		jQuery.each(  jQuery ( ' .gallery' ),  function(){
			gallery_class = jQuery( this ).attr( 'class' );
			gallery_columns = String(gallery_class.match( /gallery-columns-\d/ ));
			gallery_columns = gallery_columns.replace( 'gallery-columns-', '' );
				jQuery( this ).find( '.gallery-item').tile( parseInt( gallery_columns ));
			});

		// Masonry for footer widget area
		jQuery( '#widget-area .container' ).masonry({
				itemSelector: '.widget',
				isAnimated: true
			});

		// Swiper for gallery
		var swiper = new Swiper('.swiper-container', {
			slidesPerView: '4',
			spaceBetween: 7,
			preloadImages: false,
			lazy: true,
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			on: {
				lazyImageReady: function ( slide, image ) {
					var width = parseInt( jQuery( image ).css( 'width' ));
					var height = parseInt( jQuery( image ).css( 'height' ));
					if( width < height ){
						// vertical image
						var height_new = parseInt( jQuery( slide ).css( 'height' ));
						var width_new = parseInt( width * ( height_new / height ));
						jQuery( slide ).css({ 'width': width_new + 'px' });
					}
				},
			},
			breakpoints: {
				660: {
					slidesPerView: 3,
					spaceBetween: 5,
				},
			}
		});

		// Zoom for thumbnail
		jQuery("[data-fancybox]").fancybox({
			loop : true,
			buttons: [
				"thumbs",
				"close"
			],
		});

		jQuery( '.setos-gallery-cover' ).click(function() {
			jQuery( ".swiper-slide:first a" ).click();
			return false;
		});

	});

	// Navigation for mobile
	jQuery( "#small-menu" ).click( function(){
		jQuery( "#menu-primary-items" ).slideToggle();
		jQuery( this ).toggleClass( "current" );
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
			if ( scrollTop > 200 ) {
				jQuery('.wrapper:not(.many-navigation) #header').addClass('mini');
			}
			else {
				jQuery('.wrapper:not(.many-navigation) #header').removeClass('mini');
			}
		}
	});

	// back to pagetop
	totop.click( function () {
		jQuery( 'body, html' ).animate( { scrollTop: 0 }, 500 ); return false;
	});
});

////////////////////////////////////////
// Header Slider
jQuery.fn.birdfield_Slider = function(){

	return this.each(function(i, elem) {
		// change slide
		var birdfield_interval = jQuery( '.slider' ).attr( 'data-interval' );
		setInterval( function(){

			index = jQuery( '.slideitem.active' ).index( '.slideitem' );
			index++;
			if( index >= jQuery( '.slideitem' ).length ){
				index = 0;
			}

			// fade in
			jQuery( '.slideitem:eq(' + index + ')' ).fadeIn( 1000, function (){
				// fade out
				jQuery( '.slideitem.active' ).fadeOut( 1000 );
				jQuery( '.slideitem.start').removeClass( 'start' );
				jQuery( '.slideitem.active').removeClass( 'active' );
				jQuery( '.slideitem:eq(' + index + ')').addClass( 'active' );
			} );
		}, birdfield_interval );
	});
};
