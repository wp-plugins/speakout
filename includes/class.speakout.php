<?php

/**
 * Library of common methods for SpeakOut! Email Petitions plugin for WordPress
 */
class dk_speakout_SpeakOut
{
	/**
	 * Gets firstname, lastname and email for logged in users
	 * Used to auto-populate fields in petition form
	 * 
	 * @return array with keys: firstname, lastname, email
	 */
	public static function userinfo() {
		$current_user = wp_get_current_user();

		if ( $current_user->ID != 0 ) {
			$firstname = $current_user->user_firstname;
			$lastname  = $current_user->user_lastname;
			$email     = $current_user->user_email;
		}
		else {
			$firstname = '';
			$lastname  = '';
			$email     = '';
		}

		$userdata = array(
			'firstname' => $firstname,
			'lastname'  => $lastname,
			'email'     => $email
		);

		return $userdata;
	}

	/**
	 * Constructs HTML for progress bars
	 *
	 * @param int $goal number of signatures we hope to collect
	 * @param int $signatures number of signatures collected so far
	 * @param int $max_width width of the outer progress bar div in pixels
	 * @return HTML string
	 */
	public static function progress_bar( $goal, $signatures, $max_width ) {
		// determine how wide the internal progress bar should be
		$multiplier        = $max_width / 100;
		$percent_complete  = ( $goal != 0 ) ? floor( ( $signatures / $goal ) * 100 ) : 0;
		$progressbar_width = ( $percent_complete > 100 ) ? $max_width : floor( $percent_complete * $multiplier );
		$progressbar       = '';

		// set progress bar color via CSS class
		if ( $percent_complete < 25 ) {
			$color_class = 'dk-speakout-progressbar-low';
		}
		elseif ( $percent_complete < 75 ) {
			$color_class = 'dk-speakout-progressbar-medium';
		}
		elseif ( $percent_complete < 100 ) {
			$color_class = 'dk-speakout-progressbar-high';
		}
		else {
			$color_class = 'dk-speakout-progressbar-complete';
		}

		// create HTML for progress bar display
		if ( $goal > 0 ) {
			$progressbar = '<div class="dk-speakout-progress" style="width: ' . $max_width . 'px;">
								<div class="dk-speakout-progressbar ' . $color_class . '" style="width: ' . $progressbar_width . 'px;"></div>
							</div>';
		}

		return $progressbar;
	}

	/**
	 * url-encodes the Twiitter message for submission
	 *
	 * @param string $tweet the twitter message
	 * @return string: a properly url-encoded tweet
	 */
	public static function twitter_encode( $tweet ) {
		$tweet = str_replace( "&#039;", "'", $tweet ); // needed for older versions of plugin
		$tweet = str_replace( '"', urlencode( '"' ), $tweet );
		$tweet = str_replace( "#", urlencode( "#" ), $tweet );
		$tweet = stripslashes( $tweet );

		return $tweet;
	}

	/**
	 * Create pagination links for paging through large numbers of rows on admin table views
	 * echoes the resulting html
	 *
	 * @param $limit (int) number of rows to display in a single view
	 * @param $count (int) total number of records retrieved from query
	 * @param $page_handle (string) handle of currently loaded page
	 * @param $current_page (int) "paged" value of the url that is currently displayed
	 * @param $base_url (string) URL of current page with minimal get variables for constructing text links
	 * @param $use_form (bool) whether to display the form input for switching pages
	 */
	public static function pagination( $limit, $count, $page_handle, $current_page, $base_url, $use_form ) {
		// round up the page count so we get an integer
		$total_pages = ceil( $count / $limit );
		// make sure arrows aren't clickable when there are zero signatures
		if ( $total_pages == 0 ) $total_pages = 1;

		if ( $total_pages <= 1 ) {
			$pager_html = '<div class="tablenav-pages one-page">';
		}
		else {
			$pager_html = '<div class="tablenav-pages">';
		}
		$pager_html  .= '<form action="" method="post" id="dk-speakout-pager">';
		$pager_html  .= '<input type="hidden" name="dk-speakout-total-pages" id="dk-speakout-total-pages" value="' . $total_pages . '">';
		$pager_html  .= '<input type="hidden" name="dk-speakout-page" id="dk-speakout-page" value="' . $page_handle . '">';
		$pager_html  .= '<span class="displaying-num">' . $count . ' ' . __( 'items', 'dk_speakout' ) . '</span>';

		// first page and previous page links
		if ( $current_page == 1 ) {
	 		$pager_html .= '<a class="first-page disabled" href="">&laquo;</a> ';
			$pager_html .= '<a class="prev-page disabled" href="">&lsaquo;</a> ';
	   }
		else {
			$pager_html .= '<a class="first-page" href="' . $base_url . '&paged=1' . '&total_pages=' . $total_pages . '">&laquo;</a> ';
			$pager_html .= '<a class="prev-page" href="' . $base_url . '&paged=' . ( $current_page - 1 ) . '&total_pages=' . $total_pages . '">&lsaquo;</a> ';
	    }

		// #page of #pages text, optionally with a form input for changing values
		if ( $use_form == true ) {
			$pager_html .= '<span class="paging-input"><input class="current-page" name="dk-speakout-paged" id="dk-speakout-paged" value="' . $current_page . '" size="1" maxlength="4" type="text"> ' . __('of') . ' <span class="total-pages">' . $total_pages . ' </span></span>';
		}
		else {
			$pager_html .= '<span class="paging-input"> ' . $current_page . ' ' . __( 'of', 'dk_speakout' ) . ' <span class="total-pages">' . $total_pages . ' </span></span>';
		}

		// next page and last page links
		if ( $current_page == $total_pages ) {
			$pager_html .= '<a class="next-page disabled" href="">&rsaquo;</a> ';
			$pager_html .= '<a class="last-page disabled" href="">&raquo;</a>';
		}
		else {
			$pager_html .= '<a class="next-page" href="' . $base_url . '&paged=' . ( $current_page + 1 ) . '&total_pages=' . $total_pages . '">&rsaquo;</a> ';
			$pager_html .= '<a class="last-page" href="' . $base_url . '&paged=' . $total_pages . '&total_pages=' . $total_pages . '">&raquo;</a>';
		}

		$pager_html .= '</form>';
		$pager_html .= '</div>';

		return $pager_html;
	}

	/**
	 * Cleans up values entered in the pager form on paged table view pages
	 * Non-numeric values return page number to 1
	 * Values larger than total available pages return highest available page number
	 * returns a number
	 *
	 * @param $requested (int) number of the page requested for display
	 * @param $total (int) total number of available pages (total rows / rows per page)
	 */
	public static function current_paged( $requested, $total ) {
		// ensure only numeric values for page number
		$current_page = ( is_numeric( $requested ) ) ? $requested : 1;

		// ensure current page number doesn't exceed total number of pages
		if ( $current_page > $total ) {
			$current_page = $total;
		}

		return $current_page;
	}
}

?>