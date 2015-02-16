jQuery( document ).ready( function( $ ) {
	'use strict';

/* Add New page
------------------------------------------------------------------- */
	$( 'input#requires_confirmation' ).change( function () {
		if ( $( this ).attr( 'checked' ) ) {
			$( 'div.dk-speakout-returnurl' ).slideDown();
			$( '#dk-speakout input#return_url' ).focus();
		} else {
			$( 'div.dk-speakout-returnurl' ).slideUp();
		}
	});

	// open or close signature goal settings
	$( 'input#has_goal' ).change( function () {
		if ( $( this ).attr( 'checked' ) ) {
			$( 'div.dk-speakout-goal' ).slideDown();
			$( '#dk-speakout input#goal' ).focus();
		} else {
			$( 'div.dk-speakout-goal' ).slideUp();
		}
	});

	// open or close expiration date settings
	$( 'input#expires' ).change( function () {
		if ( $( this ).attr( 'checked' ) ) {
			$( 'div.dk-speakout-date' ).slideDown();
		} else {
			$( 'div.dk-speakout-date' ).slideUp();
		}
	});

	// open or close address fields settings
	$( 'input#display-address' ).change( function () {
		if ( $( this ).attr( 'checked' ) ) {
			$( 'div.dk-speakout-address' ).slideDown();
		} else {
			$( 'div.dk-speakout-address' ).slideUp();
		}
	});

	// open or close custom field settings
	$( 'input#displays-custom-field' ).change( function () {
		if ( $( this ).attr( 'checked' ) ) {
			$( 'div.dk-speakout-custom-field' ).slideDown();
			$( '#dk-speakout input#custom-field-label' ).focus();
		} else {
			$( 'div.dk-speakout-custom-field' ).slideUp();
		}
	});

	// open or close email opt-in settings
	$( 'input#displays-optin' ).change( function () {
		if ( $( this ).attr( 'checked' ) ) {
			$( 'div.dk-speakout-optin' ).slideDown();
			$( '#dk-speakout input#optin-label' ).focus();
		} else {
			$( 'div.dk-speakout-optin' ).slideUp();
		}
	});

	// open or close email header settings
	if ( $( 'input#sends_email' ).attr( 'checked' ) ) {
		$( 'div.dk-speakout-email-headers' ).hide();
	}
	$( 'input#sends_email' ).change( function () {
		if ( $( this ).attr( 'checked' ) ) {
			$( 'div.dk-speakout-email-headers' ).slideUp();
		} else {
			$( 'div.dk-speakout-email-headers' ).slideDown();
		}
	});

	// auto-focus the title field on add/edit petitions form if empty
	if ( $( '#dk-speakout input#title' ).val() === '' ) {
		$( '#dk-speakout input#title' ).focus();
	}

	// validate form values before submitting
	$( '#dk_speakout_submit' ).click( function() {

		$( '.dk-speakout-error' ).removeClass( 'dk-speakout-error' );

		var errors     = 0,
			emailRegEx = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,6})?$/,
			email      = $( '#dk-speakout-edit-petition #target_email' ).val(),
			subject    = $( '#dk-speakout-edit-petition #email_subject' ).val(),
			message    = $( '#dk-speakout-edit-petition #petition_message' ).val(),
			goal       = $( '#dk-speakout-edit-petition #goal' ).val(),
			day        = $( '#dk-speakout-edit-petition #day' ).val(),
			year       = $( '#dk-speakout-edit-petition #year' ).val(),
			hour       = $( '#dk-speakout-edit-petition #hour' ).val(),
			minutes    = $( '#dk-speakout-edit-petition #minutes' ).val();

		// if "Do not send email (only collect signatures)" checkbox is not checked
		if ( !$( 'input#sends_email' ).attr( 'checked' ) ) {
			// remove any spaces
			var emails = email.split( ',' );
			for ( var i=0; i < emails.length; i++ ) {
				if ( emails[i].trim() === '' || !emailRegEx.test( emails[i].trim() ) ) { // must include valid email address
					$( '#dk-speakout-edit-petition #target_email' ).addClass( 'dk-speakout-error' );
					errors ++;
				}
			}
			
			if ( subject === '' ) { // must include subject
				$( '#dk-speakout-edit-petition #email_subject' ).addClass( 'dk-speakout-error' );
				errors ++;
			}
		}
		if ( message === '' ) { // must include petition message
			$( '#dk-speakout-edit-petition #petition_message' ).addClass( 'dk-speakout-error' );
			errors ++;
		}

		// if "Set signature goal" checkbox is checked
		if ( $( 'input#has_goal' ).attr( 'checked' ) ) {
			if ( isNaN( goal ) ) { // only numbers are allowed
				$( '#dk-speakout-edit-petition #goal' ).addClass( 'dk-speakout-error' );
				errors ++;
			}
		}

		// if "Set expiration date" checkbox is checked
		if ( $( 'input#expires' ).attr( 'checked' ) ) {
			if ( isNaN( day ) ) { // only numbers are allowed
				$( '#dk-speakout-edit-petition #day' ).addClass( 'dk-speakout-error' );
				errors ++;
			}
			if ( isNaN( year ) ) { // only numbers are allowed
				$( '#dk-speakout-edit-petition #year' ).addClass( 'dk-speakout-error' );
				errors ++;
			}
			if ( isNaN( hour ) ) { // only numbers are allowed
				$( '#dk-speakout-edit-petition #hour' ).addClass( 'dk-speakout-error' );
				errors ++;
			}
			if ( isNaN( minutes ) ) { // only numbers are allowed
				$( '#dk-speakout-edit-petition #minutes' ).addClass( 'dk-speakout-error' );
				errors ++;
			}
		}

		// if no errors found, submit the form
		if ( errors === 0 ) {

			// uncheck all address fields if "Display address fields" is not checked
			if ( ! $( 'input#display-address' ).attr( 'checked' ) ) {
				$( '#street' ).removeAttr( 'checked' );
				$( '#city' ).removeAttr( 'checked' );
				$( '#state' ).removeAttr( 'checked' );
				$( '#postcode' ).removeAttr( 'checked' );
				$( '#country' ).removeAttr( 'checked' );
			}

			$( 'form#dk-speakout-edit-petition' ).submit();
		}
		else {
			$( '.dk-speakout-error-msg' ).fadeIn();
		}

		return false;

	});

	// display character count for for Twitter Message field
	// max characters is 120 to accomodate the shortnened URL provided by Twitter when submitted
	function dkSpeakoutTwitterCount() {
		var max_characters = 120;
		var text = $( '#twitter_message' ).val();
		var charcter_count = text.length;
		var charcters_left = max_characters - charcter_count;

		if ( charcter_count <= max_characters ) {
			$( '#twitter-counter' ).html( charcters_left ).css( 'color', '#000' );
		}
		else {
			$( '#twitter-counter' ).html( charcters_left ).css( 'color', '#c00' );
		}
	}
	if ( $( '#twitter_message' ).length > 0 ) {
		dkSpeakoutTwitterCount();
	}
	$( '#twitter_message' ).keyup( function() {
		dkSpeakoutTwitterCount();
	});

/* Petitions page
------------------------------------------------------------------- */
	// display confirmation box when user tries to delete a petition
	// warns that all signatures associated with the petition will also be deleted
	$( '.dk-speakout-delete-petition' ).click( function( e ) {
		e.preventDefault();

		var delete_link = $( this ).attr( 'href' );
		// confirmation message is contained in a hidden div in the HTML
		// so that it is accessible to PHP translation methods
		var confirm_message = $( '#dk-speakout-delete-confirmation' ).html();
		// add new line characters for nicer confirm msg display
		confirm_message = confirm_message.replace( '? ', '?\n\n' );
		// display confirmation box
		var confirm_delete = confirm( confirm_message );
		// if user presses OK, process delete link
		if ( confirm_delete === true ) {
			document.location = delete_link;
		}
	});

/* Signatures page
------------------------------------------------------------------- */
	// Select box navigation on Signatures page
	// to switch between different petitions
	$('#dk-speakout-switch-petition').change( function() {
		var page    = 'dk_speakout_signatures',
			action  = 'petition',
			pid     = $('#dk-speakout-switch-petition option:selected').val(),
			baseurl = String( document.location ).split( '?' ),
			newurl  = baseurl[0] + '?page=' + page + '&action=' + action + '&pid=' + pid;
		document.location = newurl;
	});

	// display confirmation box when user tries to re-send confirmation emails
	// warns that a bunch of emails will be sent out if they hit OK
	$( 'a#dk-speakout-reconfirm' ).click( function( e ) {
		e.preventDefault();

		var link = $( this ).attr( 'href' );
		// confirmation message is contained in a hidden div in the HTML
		// so that it is accessible to PHP translation methods
		var confirm_message = $( '#dk-speakout-reconfirm-confirmation' ).html();
		// add new line characters for nicer confirm msg display
		confirm_message = confirm_message.replace( '? ', '?\n\n' );
		// display confirm box
		var confirm_delete = confirm( confirm_message );
		// if user presses OK, process delete link
		if ( confirm_delete === true ) {
			document.location = link;
		}
	});

	// stripe the table rows
	$( 'tr.dk-speakout-tablerow:even' ).addClass( 'dk-speakout-tablerow-even' );

/* Pagination for Signatures and Petitions pages
------------------------------------------------------------------- */
	// when new page number is entered using the form on paginated admin pages,
	// construct a new url string to pass along the variables needed to update page
	// and redirect to the new url
	$( '#dk-speakout-pager' ).submit( function() {
		var page        = $( '#dk-speakout-page' ).val(),
			paged       = $( '#dk-speakout-paged' ).val(),
			total_pages = $( '#dk-speakout-total-pages' ).val(),
			baseurl     = String( document.location ).split( '?' ),
			newurl      = baseurl[0] + '?page=' + page + '&paged=' + paged + '&total_pages=' + total_pages;
		document.location = newurl;
		return false;
	});

/* Settings page
------------------------------------------------------------------- */
	// make the correct tab active on page load
	var currentTab = $( 'input#dk-speakout-tab' ).val();
	$( '#' + currentTab ).show();
	$( 'ul#dk-speakout-tabbar li a.' + currentTab ).addClass( 'dk-speakout-active' );

	// switch tabs when they are clicked
	$( 'ul#dk-speakout-tabbar li a' ).click( function( e ) {
		e.preventDefault();

		// tab bar display
		$( 'ul#dk-speakout-tabbar li a' ).removeClass( 'dk-speakout-active' );
		$( this ).addClass( 'dk-speakout-active' );

		// content sections display
		$( '.dk-speakout-tabcontent' ).hide();

		var newTab = $( this ).attr( 'rel' );
		$( 'input#dk-speakout-tab' ).val( newTab );

		$( '#' + newTab ).show();
	});

});