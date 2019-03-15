////////////////////////////////////////
// File birdfield.js.
jQuery(function() {

	jQuery( window ).load(function() {

		// home grid
		jQuery( "ul.tile li" ).tile( 3 );

		// Browser supports matchMedia
		if ( window.matchMedia ) {
			// MediaQueryList
			var mq = window.matchMedia( "( min-width: 930px )" );

			// MediaQueryListListener
			var birdfieldHeightCheck = function ( mq ) {
				if ( mq.matches ) {
					// tile for home
					jQuery( "ul.tile li" ).tile(3);
				}
				else {
					// cansel tile
					jQuery( 'ul.tile li' ).css( 'height', 'auto' );
				}
			};

			// Add listener HeightChec
			mq.addListener( birdfieldHeightCheck );
			birdfieldHeightCheck( mq );
		}
		else {
			// Browser doesn't support matchMedia
			jQuery( "ul.tile li" ).tile( 3 );
		}

		// Header Slider
		jQuery('.slider[data-interval]').setos_Slider();

		// gallery columns tile
		jQuery.each(  jQuery ( ' .gallery' ),  function(){
			gallery_class = jQuery( this ).attr( 'class' );
			gallery_columns = String(gallery_class.match( /gallery-columns-\d/ ));
			gallery_columns = gallery_columns.replace( 'gallery-columns-', '' );
					jQuery( this ).find( '.gallery-item').tile( parseInt( gallery_columns ));
			});

		// photos slide in book page
		var slide_num = jQuery("[data-fancybox]").length;
		if( 1 < slide_num ){
			jQuery( '.setos-photos-slide-start' ).insertAfter( '.book-meta' );

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
		jQuery( '.slideitem' ).each( function ( index, element ) {

			// set image ratio
			var w = jQuery( this ).find( 'img' ).attr( 'width' );
			var h = jQuery( this ).find('img').attr( 'height' );
			var ratio = parseInt( h /w *100 );
			jQuery(this).attr( 'ratio', ratio + '%' );

			if( jQuery( this ).hasClass( 'start' )){
				// first slide
				jQuery( this ).parent().css({ 'padding-top': ratio + '%' });
			}
		});

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
	});
};
