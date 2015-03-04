<?php
/*
Plugin Name: SpeakOut! Email Petitions
Plugin URI: http://speakout.123host.com.au/
Description: Create custom email petition forms and include them on your site via shortcode or widget. Signatures are saved in the database and can be exported to CSV.
Version: 1.1.0
Author: Steve D forked from SpeakUp!
Author URI: http://speakout.123host.com.au
License: GPL2
*/

global $wpdb, $db_petitions, $db_signatures, $dk_speakout_version;
$db_petitions  = $wpdb->prefix . 'dk_speakout_petitions';
$db_signatures = $wpdb->prefix . 'dk_speakout_signatures';
$dk_speakout_version = '1.1.0';

// enable localizations
add_action( 'init', 'dk_speakout_translate' );
function dk_speakout_translate() {
	load_plugin_textdomain( 'dk_speakout', false, 'speakout/languages' );
}

// load admin functions only on admin pages
if ( is_admin() ) {
	include_once( dirname( __FILE__ ) . '/includes/install.php' );
	include_once( dirname( __FILE__ ) . '/includes/admin.php' );
	include_once( dirname( __FILE__ ) . '/includes/petitions.php' );
	include_once( dirname( __FILE__ ) . '/includes/addnew.php' );
	include_once( dirname( __FILE__ ) . '/includes/signatures.php' );
	include_once( dirname( __FILE__ ) . '/includes/settings.php' );
	include_once( dirname( __FILE__ ) . '/includes/csv.php' );
	include_once( dirname( __FILE__ ) . '/includes/ajax.php' );

	if ( version_compare( get_bloginfo( 'version' ), '3.3', '>' ) == 1 ) {
		include_once( dirname( __FILE__ ) . '/includes/help.php' );
	}

	// enable plugin activation
	register_activation_hook( __FILE__, 'dk_speakout_install' );
}
// public pages
else {
	include_once( dirname( __FILE__ ) . '/includes/emailpetition.php' );
	include_once( dirname( __FILE__ ) . '/includes/signaturelist.php' );
	include_once( dirname( __FILE__ ) . '/includes/confirmations.php' );
}

// load the widget (admin and public)
include_once( dirname( __FILE__ ) . '/includes/widget.php' );

// add Support and Donate links to the Plugins page
add_filter( 'plugin_row_meta', 'dk_speakout_meta_links', 10, 2 );
function dk_speakout_meta_links( $links, $file ) {
	$plugin = plugin_basename( __FILE__ );

	// create link
	if ( $file == $plugin ) {
		return array_merge(
			$links,
			array(
				sprintf( '<a href="http://wordpress.org/tags/speakout-email-petitions?forum_id=10">%s</a>', __( 'Support', 'dk_speakout' ) ),
				sprintf( '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=4PPYZ8K2KLXUJ">%s</a>', __( 'Donate', 'dk_speakout' ) )
			)
		);
	}

	return $links;
}

?>