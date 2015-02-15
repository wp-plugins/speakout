<?php

// if uninstall is not initiated by WordPress, do nothing
if( !defined( 'WP_UNINSTALL_PLUGIN' ) ) exit ();

// otherwise...

// delete options from options table
delete_option( 'dk_speakout_options' );
delete_option( 'dk_speakout_version' );

// set variables for accessing database
global $wpdb;
$db_petitions = $wpdb->prefix . "dk_speakout_petitions";
$db_signatures = $wpdb->prefix . "dk_speakout_signatures";
$db_options = $wpdb->prefix . "options";

// delete any remaining transients

// get ids for all existing petitions
$sql_petition_ids = "SELECT id FROM $db_petitions";
$petitions = $wpdb->get_results( $sql_petition_ids );

// loop through petitions and delete associated transients
foreach ( $petitions as $petition ) {
	// construct transient names
	$transient_petition = 'dk_speakout_petition_' . $petition->id;
	$transient_signatureslist = 'dk_speakout_signatureslist_' . $petition->id;
	$transient_signatures_total = 'dk_speakout_signatures_total_' . $petition->id;

	// delete transients
	delete_transient( $transient_petition );
	delete_transient( $transient_signatureslist );
	delete_transient( $transient_signatures_total );
}

// delete widget data
$sql_widget = "DELETE FROM $db_options WHERE option_name = 'widget_dk_speakout_petition_widget'";
$wpdb->query( $sql_widget );

// delete custom database tables
$sql_petitions_table = "DROP TABLE $db_petitions";
$wpdb->query( $sql_petitions_table );

$sql_signatures_table = "DROP TABLE $db_signatures";
$wpdb->query( $sql_signatures_table );

// delete WPML strings
if ( function_exists( 'icl_unregister_string' ) ) {
	// delete petition strings in WPML
	foreach ( $petitions as $petition ) {

		$context = 'Petition ' . $petition->id;

		icl_unregister_string( $context, 'petition title' );
		icl_unregister_string( $context, 'email subject' );
		icl_unregister_string( $context, 'greeting' );
		icl_unregister_string( $context, 'petition message' );
		icl_unregister_string( $context, 'custom field label' );
		icl_unregister_string( $context, 'twitter message' );
		icl_unregister_string( $context, 'optin label' );
	}

	// delete widget strings in WPML
	foreach ( $petitions as $petition ) {

		$context = 'Petition ' . $petition->id;

		icl_unregister_string( $context, 'widget title' );
		icl_unregister_string( $context, 'widget call to action' );
	}

	// delete options strings in WPML
	icl_unregister_string( 'Petition', 'submit button text' );
	icl_unregister_string( 'Petition', 'success message' );
	icl_unregister_string( 'Petition', 'share message' );
	icl_unregister_string( 'Petition', 'expiration message' );
	icl_unregister_string( 'Petition', 'already signed message' );
	icl_unregister_string( 'Petition', 'signaturelist title' );
	icl_unregister_string( 'Petition', 'confirmation email subject' );
	icl_unregister_string( 'Petition', 'confirmation email message' );

	
}
?>