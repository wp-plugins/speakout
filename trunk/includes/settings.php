<?php

function dk_speakout_settings_page() {

	// security check
	if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Insufficient privileges: You need to be an administrator to do that.' );

	include_once( 'class.speakout.php' );
	include_once( 'class.settings.php' );
	include_once( 'class.wpml.php' );
	$the_settings = new dk_speakout_Settings();
	$wpml         = new dk_speakout_WPML();

	$action = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : '';
	$tab    = isset( $_REQUEST['tab'] ) ? $_REQUEST['tab'] : 'dk-speakout-tab-01';

	switch( $action ) {

		case 'update' :

			// security check
			check_admin_referer( 'dk_speakout-update_settings' );

			$the_settings->update();
			$the_settings->retrieve();

			// attempt to resgister strings for translation in WPML
			$options = get_option( 'dk_speakout_options' );
			$wpml->register_options( $options );

			$message_update = __( 'Settings updated.', 'dk_speakout' );

			break;

		default :

			$the_settings->retrieve();

			$message_update = '';
	}

	$nonce  = 'dk_speakout-update_settings';
	$action = 'update';
	include_once( dirname( __FILE__ ) . '/settings.view.php' );
}

?>