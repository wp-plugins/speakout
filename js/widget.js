jQuery( document ).ready( function( $ ) {
	'use strict';

	// display required asteriscs
	$( '.dk-speakout-widget-popup-wrap label.required' ).append('<span> *</span>');

	// run only if widget is on the page
	if( $( '.dk-speakout-widget-wrap' ).length ) {
		$( '.dk-speakout-widget-button' ).click( function( e ) {
			var petition_form = '#' + $( this ).attr( 'rel' ),
				screenHeight  = $( document ).height(),
				screenWidth   = $( window ).width(),
				windowHeight  = $( window ).height(),
				windowWidth   = $( window ).width();

			$( '#dk-speakout-widget-windowshade' ).css( {
				'width'  : screenWidth,
				'height' : screenHeight
			});
			$( '#dk-speakout-widget-windowshade' ).fadeTo( 500, 0.8 );

			// center the pop-up window
			$( petition_form ).css( 'top',  ( ( windowHeight / 2 ) - ( $( petition_form ).height() / 2 ) ) );
			$( petition_form ).css( 'left', ( windowWidth / 2 ) - ( $( petition_form ).width() / 2 ) );

			// display the form
			$( petition_form ).fadeIn( 500 );
		});

		/* Close the pop-up petition form */
		// by clicking windowshade area
		$( '#dk-speakout-widget-windowshade' ).click( function () {
			$( this ).fadeOut( 'slow' );
			$( '.dk-speakout-widget-popup-wrap' ).hide();
		});
		// or by clicking the close button
		$( '.dk-speakout-widget-close' ).click( function() {
			$( '#dk-speakout-widget-windowshade' ).fadeOut( 'slow' );
			$( '.dk-speakout-widget-popup-wrap' ).hide();
		});
		// or by pressing ESC
		$( document ).keyup( function( e ) {
			if ( e.keyCode === 27 ) {
				$( '#dk-speakout-widget-windowshade' ).fadeOut( 'slow' );
				$( '.dk-speakout-widget-popup-wrap' ).hide();
			}
		});

		// process petition form submissions
		$( '.dk-speakout-widget-submit' ).click( function( e ) {
			e.preventDefault();

			var id             = $( this ).attr( 'name' ),
				current_url    = document.URL,
				share_url      = $( '#dk-speakout-widget-shareurl-' + id ).val(),
				posttitle      = $( '#dk-speakout-widget-posttitle-' + id ).val(),
				tweet          = $( '#dk-speakout-widget-tweet-' + id ).val(),
				lang           = $( '#dk-speakout-widget-lang-' + id ).val(),
				firstname      = $( '#dk-speakout-widget-first-name-' + id ).val(),
				lastname       = $( '#dk-speakout-widget-last-name-' + id ).val(),
				email          = $( '#dk-speakout-widget-email-' + id ).val(),
				email_confirm  = $( '#dk-speakout-widget-email-confirm-' + id ).val(),
				street         = $( '#dk-speakout-widget-street-' + id ).val(),
				city           = $( '#dk-speakout-widget-city-' + id ).val(),
				state          = $( '#dk-speakout-widget-state-' + id ).val(),
				postcode       = $( '#dk-speakout-widget-postcode-' + id ).val(),
				country        = $( '#dk-speakout-widget-country-' + id ).val(),
				custom_field   = $( '#dk-speakout-widget-custom-field-' + id ).val(),
				custom_message = $( 'textarea#dk-speakout-widget-message-' + id ).val(),
				optin          = '',
				ajaxloader     = $( '#dk-speakout-widget-ajaxloader-' + id );

			if ( share_url === '' ) {
				share_url = current_url.split('#')[0];
			}

			if ( $( '#dk-speakout-widget-optin-' + id ).attr( 'checked' ) ) {
				optin = 'on';
			}

			// make sure error notices are turned off before checking for new errors
			$( '#dk-speakout-widget-popup-wrap-' + id + ' input' ).removeClass( 'dk-speakout-widget-error' );

			// validate form values
			var errors = 0,
				emailRegEx = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

			if ( email_confirm !== undefined && email_confirm !== email ) {
				if ( email_confirm !== email ) {
					$( '#dk-speakout-widget-email-' + id ).addClass( 'dk-speakout-widget-error' );
					$( '#dk-speakout-widget-email-confirm-' + id ).addClass( 'dk-speakout-widget-error' );
					errors ++;
				}
			}
			if ( email === '' || !emailRegEx.test( email ) ) {
				$( '#dk-speakout-widget-email-' + id ).addClass( 'dk-speakout-widget-error' );
				errors ++;
			}
			if ( firstname === '' ) {
				$( '#dk-speakout-widget-first-name-' + id ).addClass( 'dk-speakout-widget-error' );
				errors ++;
			}
			if ( lastname === '' ) {
				$( '#dk-speakout-widget-last-name-' + id ).addClass( 'dk-speakout-widget-error' );
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
				$.post( dk_speakout_widget_js.ajaxurl, data,
					function( response ) {
						var response_class = 'dk-speakout-widget-response-success';
						if ( response.status === 'error' ) {
							response_class = 'dk-speakout-widget-response-error';
						}
						$( '#dk-speakout-widget-popup-wrap-' + id + ' .dk-speakout-widget-form' ).hide();
						$( '.dk-speakout-widget-response' ).addClass( response_class );
						$( '#dk-speakout-widget-popup-wrap-' + id + ' .dk-speakout-widget-response' ).fadeIn().html( response.message );
						$( '#dk-speakout-widget-popup-wrap-' + id + ' .dk-speakout-widget-share' ).fadeIn();

						// launch Facebook sharing window
						$( '.dk-speakout-widget-facebook' ).click( function() {
							var url = 'http://www.facebook.com/sharer.php?u=' + share_url + '&t=' + posttitle;
							window.open( url, 'facebook', 'height=420,width=550,left=100,top=100,resizable=yes,location=no,status=no,toolbar=no' );
						});
						// launch Twitter sharing window
						$( '.dk-speakout-widget-twitter' ).click( function() {
							var url = 'http://twitter.com/share?url=' + share_url + '&text=' + tweet;
							window.open( url, 'twitter', 'height=420,width=550,left=100,top=100,resizable=yes,location=no,status=no,toolbar=no' );
							ajaxloader.css({ 'visibility' : 'hidden'});
						});
					}, 'json'
				);
			}
		});

	}

});