////////////////////////////////////////
// File birdfield.js.
jQuery(function() {

	jQuery( window ).load(function() {

		// Header Slider
		jQuery('.slider[data-interval]').setos_Slider();

		// photos slide in book page
		var slide_num = jQuery("[data-fancybox]").length;
		if( 1 < slide_num ){
			// Zoom for thumbnail
			jQuery("[data-fancybox]").fancybox({
				loop : false,
				buttons: [
					"thumbs",
					"close"
				],
				protect : true,
				clickContent : function( current, event ) {
					return false;
				},
			});
		}

		// Masonry for list
		jQuery('ul.masonry').masonry({
			itemSelector: 'li',
			isAnimated: true
		});

		jQuery( '.setos-photos-cover, .setos-photos-slide-start' ).click(function() {
			jQuery( ".setos-photos-slide a:first" ).click();
			return false;
		});

		// Initialize bogo-language-switcher
		jQuery( '.bogo-language-switcher' ).insertAfter( '.menu .language a' ).css({ 'display': 'block' });
	});

	// Navigation for mobile
	jQuery("#small-menu").click(function () {
		jQuery( "#menu-primary-items" ).slideToggle()
		jQuery( "#menu-wrapper" ).toggleClass( "open" );
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
	totop.click( function () {
		jQuery( 'body, html' ).animate( { scrollTop: 0 }, 500 ); return false;
	});
});

////////////////////////////////////////
// Header Slider
jQuery.fn.setos_Slider = function(){

	return this.each( function( i, elem ) {
		// change slide
		var setos_interval = jQuery( '.slider' ).attr( 'data-interval' );

		// init slider size
		var count = 0;
		jQuery( '.slideitem' ).each( function ( index, element ) {

			// set image ratio
			var w = jQuery( this ).find( 'img' ).attr( 'width' );
			var h = jQuery( this ).find('img').attr( 'height' );
			var ratio = parseInt( h /w *100 );
			jQuery(this).attr( 'ratio', ratio + '%' );
			count++;

			if( jQuery( this ).hasClass( 'start' )){
				// first slide
				jQuery( this ).parent().css({ 'padding-top': ratio + '%' });
			}
		});

		if( 1 < count ){

			setInterval( function(){

				index = jQuery( '.slideitem.active' ).index( '.slideitem' );
				index++;
				if( index >= jQuery( '.slideitem' ).length ){
					index = 0;
				}

				// fade in
				jQuery( '.slideitem:eq(' + index + ')' ).fadeIn( 1000, function (){

					// reset slider size
					var ratio = jQuery( this ).attr( 'ratio' );
					jQuery( '#wall .slider' ).css({ 'padding-top': ratio });

					// fade out
					jQuery( '.slideitem.active' ).fadeOut( 500, function(){
						jQuery( '.slideitem.start' ).removeClass( 'start' );
						jQuery( '.slideitem.active' ).removeClass( 'active ');
						jQuery( '.slideitem:eq(' + index + ')').addClass('active' );
					} );
				} );
			}, setos_interval );
		}
	});
};
