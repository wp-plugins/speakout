<?php

/**
 * Displays the Email Petitions table page
 */
function dk_speakout_petitions_page() {
	// check security: ensure user has authority
	if ( ! current_user_can( 'publish_posts' ) ) wp_die( 'Insufficient privileges: You need to be an editor to do that.' );

	include_once( 'class.speakout.php' );
	include_once( 'class.petition.php' );
	include_once( 'class.wpml.php' );
	$the_petitions = new dk_speakout_Petition();
	$wpml          = new dk_speakout_WPML();
	$action        = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : '';
	$id            = isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : '';
	$options       = get_option( 'dk_speakout_options' );

	// set variables for paged record display and limit values in db query
	// request values may be submitted either by html links (pagination.php) or by javascript (admin.js)
	$paged        = isset( $_REQUEST['paged'] ) ? $_REQUEST['paged'] : '1';
	$total_pages  = isset ( $_REQUEST['total_pages'] ) ? $_REQUEST['total_pages'] : '1';
	$current_page = dk_speakout_SpeakOut::current_paged( $paged, $total_pages );
	$query_limit  = $options['petitions_rows'];
	$query_start  = ( $current_page * $query_limit ) - $query_limit;

	// link URL for "Add New" button in header
	$addnew_url = esc_url( site_url() . '/wp-admin/admin.php?page=dk_speakout_addnew' );

	switch ( $action ) {

		case 'delete' :
			// security: ensure user has intention
			check_admin_referer( 'dk_speakout-delete_petition' . $id );

			// delete the petition and its signatures
			$the_petitions->delete( $id );
			$wpml->unregister_petition( $id );

			// get petitions
			$petitions = $the_petitions->all( $query_start, $query_limit );

			// set up page display variables
			$page_title     = __( 'Email Petitions', 'dk_speakout' );
			$count          = $the_petitions->count();
			$message_update = __( 'Petition deleted.', 'dk_speakout' );

			break;

		default :
			// get petitions
			$petitions = $the_petitions->all( $query_start, $query_limit );

			// set up page display variables
			$page_title     = __( 'Email Petitions', 'dk_speakout' );
			$count          = $the_petitions->count();
			$message_update = '';
	}

	// display the Petitions table
	include_once( 'petitions.view.php' );
}

?>