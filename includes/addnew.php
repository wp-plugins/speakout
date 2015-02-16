<?php

// page used for creating new petitions
// and for editing existing petitions
function dk_speakout_addnew_page() {
	// check security: ensure user has authority
	if ( ! current_user_can( 'publish_posts' ) ) wp_die( 'Insufficient privileges: You need to be an editor to do that.' );

	include_once( 'class.petition.php' );
	include_once( 'class.wpml.php' );
	$petition     = new dk_speakout_Petition();
	$wpml         = new dk_speakout_WPML();
	$action       = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : '';
	$petition->id = isset( $_REQUEST['id'] ) ? absint( $_REQUEST['id'] ) : '';

	switch( $action ) {
		// add a new petition to database
		// then display form for editing the new petition
		case 'create' :
			// security: ensure user has intention
			check_admin_referer( 'dk_speakout-create_petition' );

			$petition->poppulate_from_post();
			$petition->create();
			$wpml->register_petition( $petition );

			// set up page display variables
			$page_title  = __( 'Edit Email Petition', 'dk_speakout' );
			$nonce       = 'dk_speakout-update_petition' . $petition->id;
			$action      = 'update';
			$x_date      = $petition->get_expiration_date_components();
			$button_text = __( 'Update Petition', 'dk_speakout' );

			// construct update message box content
			$emailpetition_shortcode = '[emailpetition id="' . $petition->id . '"]';
			$signaturelist_shortcode = '[signaturelist id="' . $petition->id . '"]';
			$start_tag               = '<strong>';
			$end_tag                 = '</strong>';
			$message_text            = __( 'Petition created. Use %1$s %2$s %3$s to display in a page or post. Use %1$s %4$s %3$s to display the signatures list.', 'dk_speakout' );
			$message_update          = sprintf( $message_text, $start_tag, $emailpetition_shortcode, $end_tag, $signaturelist_shortcode );

			break;

		// 'edit' is only called from text links on the Email Petitions page
		// displays existing petition for alteration and submits with 'update' action
		case 'edit' :
			// security: ensure user has intention
			check_admin_referer( 'dk_speakout-edit_petition' . $petition->id );

			$petition->retrieve( $petition->id );

			// set up page display variables
			$page_title     = __( 'Edit Email Petition', 'dk_speakout' );
			$nonce          = 'dk_speakout-update_petition' . $petition->id;
			$action         = 'update';
			$x_date         = $petition->get_expiration_date_components();
			$button_text    = __( 'Update Petition', 'dk_speakout' );
			$message_update = '';

			break;

		// alter an existing petition
		case 'update' :
			// security: ensure user has intention
			check_admin_referer( 'dk_speakout-update_petition' . $petition->id );

			$petition->poppulate_from_post();
			$petition->update( $petition->id );
			$wpml->register_petition( $petition );

			// set up page display variables
			$page_title     = __( 'Edit New Email Petition', 'dk_speakout' );
			$nonce          = 'dk_speakout-update_petition' . $petition->id;
			$action         = 'update';
			$x_date         = $petition->get_expiration_date_components();
			$button_text    = __( 'Update Petition', 'dk_speakout' );
			$message_update = __( 'Petition updated.' );

			break;

		// show blank form for adding a new petition
		default :
			// set up page display variables
			$page_title     = __( 'Add New Email Petition', 'dk_speakout' );
			$nonce          = 'dk_speakout-create_petition';
			$action         = 'create';
			$x_date         = $petition->get_expiration_date_components();
			$button_text    = __( 'Create Petition', 'dk_speakout' );
			$message_update = '';
			$petition->optin_label = __( 'Add me to your mailing list', 'dk_speakout' );
	}

	if ( $petition->return_url == '' ) {
		$petition->return_url = home_url();
		error_log($petition->return_url);
	}

	// display the form
	include_once( 'addnew.view.php' );
}

?>