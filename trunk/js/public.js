jQuery( document ).ready( function( $ ) {
	'use strict';

	// display required asterisks
	$( '.dk-speakout-petition label.required' ).append( '<span> *</span>');

/*
-------------------------------
	Form submission
-------------------------------
*/
	$( '.dk-speakout-submit' ).click( function( e ) {
		e.preventDefault();

		var id             = $( this ).attr( 'name' ),
			lang           = $( '#dk-speakout-lang-' + id ).val(),
			firstname      = $( '#dk-speakout-first-name-' + id ).val(),
			lastname       = $( '#dk-speakout-last-name-' + id ).val(),
			email          = $( '#dk-speakout-email-' + id ).val(),
			email_confirm  = $( '#dk-speakout-email-confirm-' + id ).val(),
			street         = $( '#dk-speakout-street-' + id ).val(),
			city           = $( '#dk-speakout-city-' + id ).val(),
			state          = $( '#dk-speakout-state-' + id ).val(),
			postcode       = $( '#dk-speakout-postcode-' + id ).val(),
			country        = $( '#dk-speakout-country-' + id ).val(),
			custom_field   = $( '#dk-speakout-custom-field-' + id ).val(),
			custom_message = $( '.dk-speakout-message-' + id ).val(),
			optin          = '',
			ajaxloader     = $( '#dk-speakout-ajaxloader-' + id );

		// toggle use of .text() / .val() to read from edited textarea properly on Firefox
		if ( $( '#dk-speakout-textval-' + id ).val() === 'text' ) {
			custom_message = $( '.dk-speakout-message-' + id ).text();
		}

		if ( $( '#dk-speakout-optin-' + id ).attr( 'checked' ) ) {
			optin = 'on';
		}

		// make sure error notices are turned off before checking for new errors
		$( '#dk-speakout-petition-' + id + ' input' ).removeClass( 'dk-speakout-error' );

		// validate form values
		var errors = 0,
			emailRegEx = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,6})?$/;

		if ( email_confirm !== undefined ) {
			if ( email_confirm !== email ) {
				$( '#dk-speakout-email-' + id ).addClass( 'dk-speakout-error' );
				$( '#dk-speakout-email-confirm-' + id ).addClass( 'dk-speakout-error' );
				errors ++;
			}
		}
		if ( email === '' || ! emailRegEx.test( email ) ) {
			$( '#dk-speakout-email-' + id ).addClass( 'dk-speakout-error' );
			errors ++;
		}
		if ( firstname === '' ) {
			$( '#dk-speakout-first-name-' + id ).addClass( 'dk-speakout-error' );
			errors ++;
		}
		if ( lastname === '' ) {
			$( '#dk-speakout-last-name-' + id ).addClass( 'dk-speakout-error' );
			errors ++;
		}

		// if no errors found, submit the data via ajax
		if ( errors === 0 && $( this ).attr( 'rel' ) !== 'disabled' ) {

			// set rel to disabled as flag to block double clicks
			$( this ).attr( 'rel', 'disabled' );

			var data = {
				action:         'dk_speakout_sendmail',
				id:             id,
				first_name:     firstname,
				last_name:      lastname,
				email:          email,
				street:         street,
				city:           city,
				state:          state,
				postcode:       postcode,
				country:        country,
				custom_field:   custom_field,
				custom_message: custom_message,
				optin:          optin,
				lang:           lang
			};

			// display AJAX loading animation
			ajaxloader.css({ 'visibility' : 'visible'});

			// submit form data and handle ajax response
			$.post( dk_speakout_js.ajaxurl, data,
				function( response ) {
					var response_class = 'dk-speakout-response-success';
					if ( response.status === 'error' ) {
						response_class = 'dk-speakout-response-error';
					}
					$( '#dk-speakout-petition-' + id + ' .dk-speakout-petition' ).fadeTo( 400, 0.35 );
					$( '#dk-speakout-petition-' + id + ' .dk-speakout-response' ).addClass( response_class );
					$( '#dk-speakout-petition-' + id + ' .dk-speakout-response' ).fadeIn().html( response.message );
					ajaxloader.css({ 'visibility' : 'hidden'});
				}, 'json'
			);
		}
	});

	// launch Facebook sharing window
	$( '.dk-speakout-facebook' ).click( function( e ) {
		e.preventDefault();

		var id           = $( this ).attr( 'rel' ),
			posttitle    = $( '#dk-speakout-posttitle-' + id ).val(),
			share_url    = document.URL,
			facebook_url = 'http://www.facebook.com/sharer.php?u=' + share_url + '&amp;t=' + posttitle;

		window.open( facebook_url, 'facebook', 'height=400,width=550,left=100,top=100,resizable=yes,location=no,status=no,toolbar=no' );
	});

	// launch Twitter sharing window
	$( '.dk-speakout-twitter' ).click( function( e ) {
		e.preventDefault();

		var id          = $( this ).attr( 'rel' ),
			tweet       = $( '#dk-speakout-tweet-' + id ).val(),
			current_url = document.URL,
			share_url   = current_url.split('#')[0],
			twitter_url = 'http://twitter.com/share?url=' + share_url + '&text=' + tweet;

		window.open( twitter_url, 'twitter', 'height=400,width=550,left=100,top=100,resizable=yes,location=no,status=no,toolbar=no' );
	});

/*
-------------------------------
	Petition reader popup
-------------------------------
 */
	$('a.dk-speakout-readme').click( function( e ) {
		e.preventDefault();

		var id = $( this ).attr( 'rel' ),
			sourceOffset = $(this).offset(),
			sourceTop    = sourceOffset.top - $(window).scrollTop(),
			sourceLeft   = sourceOffset.left - $(window).scrollLeft(),
			screenHeight = $( document ).height(),
			screenWidth  = $( window ).width(),
			windowHeight = $( window ).height(),
			windowWidth  = $( window ).width(),
			readerHeight = 520,
			readerWidth  = 640,
			readerTop    = ( ( windowHeight / 2 ) - ( readerHeight / 2 ) ),
			readerLeft   = ( ( windowWidth / 2 ) - ( readerWidth / 2 ) ),
			petitionText = $( 'div#dk-speakout-message-' + id ).html(),
			reader       = '<div id="dk-speakout-reader"><div id="dk-speakout-reader-close"></div><div id="dk-speakout-reader-content"></div></div>';

		// set this to toggle use of .val() / .text() so that Firefox  will read from editable-message textarea as expected
		$( '#dk-speakout-textval-' + id ).val('text');

		// use textarea for editable petition messages
		if ( petitionText === undefined ) {
			petitionText = $( '#dk-speakout-message-editable-' + id ).html();
		}

		$( '#dk-speakout-windowshade' ).css( {
				'width'  : screenWidth,
				'height' : screenHeight
			});
			$( '#dk-speakout-windowshade' ).fadeTo( 500, 0.8 );

		if ( $( '#dk-speakout-reader' ).length > 0 ) {
			$( '#dk-speakout-reader' ).remove();
		}

		$( 'body' ).append( reader );

		$('#dk-speakout-reader').css({
			position   : 'fixed',
			left       : sourceLeft,
			top        : sourceTop,
			zIndex     : 100002
		});

		$('#dk-speakout-reader').animate({
			width  : readerWidth,
			height : readerHeight,
			top    : readerTop,
			left   : readerLeft
		}, 500, function() {
			$( '#dk-speakout-reader-content' ).html( petitionText );
		});

		/* Close the pop-up petition reader */
		// by clicking windowshade area
		$( '#dk-speakout-windowshade' ).click( function () {
			$( this ).fadeOut( 'slow' );
			// write edited text to form - using .text() because target textarea has display: none
			$( '.dk-speakout-message-' + id ).text( $( '#dk-speakout-reader textarea' ).val() );
			$( '#dk-speakout-reader' ).remove();
		});
		// or by clicking the close button
		$( '#dk-speakout-reader-close' ).live( 'click', function() {
			$( '#dk-speakout-windowshade' ).fadeOut( 'slow' );
			// write edited text to form - using .text() because target textarea has display: none
			$( '.dk-speakout-message-' + id ).text( $( '#dk-speakout-reader textarea' ).val() );
			$( '#dk-speakout-reader' ).remove();
		});
		// or by pressing ESC
		$( document ).keyup( function( e ) {
			if ( e.keyCode === 27 ) {
				$( '#dk-speakout-windowshade' ).fadeOut( 'slow' );
				// write edited text to form - using .text() because target textarea has display: none
				$( '.dk-speakout-message-' + id ).text( $( '#dk-speakout-reader textarea' ).val() );
				$( '#dk-speakout-reader' ).remove();
			}
		});

	});

/*
	Toggle form labels depending on input field focus
	Leaving this in for now to support older custom themes
	But it will be removed in future updates
 */

	$( '.dk-speakout-petition-wrap input[type=text]' ).focus( function( e ) {
		var label = $( this ).siblings( 'label' );
		if ( $( this ).val() === '' ) {
			$( this ).siblings( 'label' ).addClass( 'dk-speakout-focus' ).removeClass( 'dk-speakout-blur' );
		}
		$( this ).blur( function(){
			if ( this.value === '' ) {
				label.addClass( 'dk-speakout-blur' ).removeClass( 'dk-speakout-focus' );
			}
		}).focus( function() {
			label.addClass( 'dk-speakout-focus' ).removeClass( 'dk-speakout-blur' );
		}).keydown( function( e ) {
			label.addClass( 'dk-speakout-focus' ).removeClass( 'dk-speakout-blur' );
			$( this ).unbind( e );
		});
	});

	// hide labels on filled input fields when page is reloaded
	$( '.dk-speakout-petition-wrap input[type=text]' ).each( function() {
		if ( $( this ).val() !== '' ) {
			$( this ).siblings( 'label' ).addClass( 'dk-speakout-focus' );
		}
	});

});