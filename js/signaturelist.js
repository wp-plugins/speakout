jQuery( document ).ready( function( $ ) {
	'use strict';

	// next pagination button is clicked
	$( '.dk-speakout-signaturelist-next' ).click( function( e ) {
		e.preventDefault();
		get_signaturelist( $( this ) );
	});

	// prev pagination button is clicked
	$( '.dk-speakout-signaturelist-prev' ).click( function( e ) {
		e.preventDefault();
		get_signaturelist( $( this ) );
	});

	// pagination: query new signatures and display results
	function get_signaturelist( button, link ) {
		// change button appearance to disabled while ajax request is processing
		$( this ).addClass( 'dk-speakout-signaturelist-disabled' );
		
		var link   = button.attr( 'rel' ).split( ',' ),
			id     = link[0],
			start  = link[1],
			limit  = link[2],
			total  = link[3],
			status = link[4],
			ajax   = {
				action: 'dk_speakout_paginate_signaturelist',
				id:         id,
				start:      start,
				limit:      limit,
				dateformat: dk_speakout_signaturelist_js.dateformat
			};

		if ( status === '1' ) {
			// submit data and handle ajax response
			$.post( dk_speakout_signaturelist_js.ajaxurl, ajax,
				function( response ) {
					var next_link = get_next_link( id, start, limit, total );
					var prev_link = get_prev_link( id, start, limit, total );

					toggle_button_display( id, next_link, prev_link );

					$( '.dk-speakout-signaturelist-' + id + ' tr:not(:last-child)' ).remove();
					$( '.dk-speakout-signaturelist-' + id ).prepend( response );
					$( '.dk-speakout-signaturelist-' + id + ' .dk-speakout-signaturelist-next' ).attr( 'rel', next_link );
					$( '.dk-speakout-signaturelist-' + id + ' .dk-speakout-signaturelist-prev' ).attr( 'rel', prev_link );
				}
			);
		}
	}

	// format new link for next pagination button
	function get_next_link( id, start, limit, total ) {
		var start = parseInt( start ),
			limit = parseInt( limit ),
			total = parseInt( total ),
			new_start = '',
			status    = '',
			link      = '';

		if ( start + limit  < total ) {
			new_start = start + limit;
			status = '1';
		}
		else {
			new_start = total;
			status = '0';
		}

		link = id + ',' + new_start + ',' + limit + ',' + total + ',' + status;
		return link;
	}

	// format new link for prev pagination button
	function get_prev_link( id, start, limit, total ) {
		var start = parseInt( start ),
			limit = parseInt( limit ),
			total = parseInt( total ),
			new_start = '',
			status    = '',
			link      = '';

		if ( start - limit >= 0 ) {
			new_start = start - limit;
			status = '1';
		}
		else {
			new_start = total;
			status = '0';
		}

		link = id + ',' + new_start + ',' + limit + ',' + total + ',' + status;
		return link;
	}

	function toggle_button_display( id, next_link, prev_link ) {
		if ( next_link.split( ',' )[4] === '0' ) {
			$( '.dk-speakout-signaturelist-' + id + ' .dk-speakout-signaturelist-next' ).addClass( 'dk-speakout-signaturelist-disabled' );
		}
		else {
			$( '.dk-speakout-signaturelist-' + id + ' .dk-speakout-signaturelist-next' ).removeClass( 'dk-speakout-signaturelist-disabled' );
		}

		if ( prev_link.split( ',' )[4] === '0' ) {
			$( '.dk-speakout-signaturelist-' + id + ' .dk-speakout-signaturelist-prev' ).addClass( 'dk-speakout-signaturelist-disabled' );
		}
		else {
			$( '.dk-speakout-signaturelist-' + id + ' .dk-speakout-signaturelist-prev' ).removeClass( 'dk-speakout-signaturelist-disabled' );
		}
	}

});