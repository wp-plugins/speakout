<?php

// contextual help to Add New page
function dk_speakout_help_addnew() {
	$tab_petitions = '
		<p><strong>' . __( "Title", "dk_speakout" ) . '</strong>&mdash;' . __( "Enter the title of your petition, which will appear at the top of the petition form.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Do not send email (only collect signatures)", "dk_speakout" ) . '</strong>&mdash;' . __( "Use this option if do not wish to send petition emails to a target address.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Target Email", "dk_speakout" ) . '</strong>&mdash;' . __( "Enter the email address to which the petition will be sent. You may enter multiple email addresses, separated by commas.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Email Subject", "dk_speakout" ) . '</strong>&mdash;' . __( "Enter the subject of your petition email.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Greeting", "dk_speakout" ) . '</strong>&mdash;' . __( "Include a greeting to the recipient of your petition, such as \"Dear Sir,\" which will appear as the first line of the email.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Petition Message", "dk_speakout" ) . '</strong>&mdash;' . __( "Enter the content of your petition email.", "dk_speakout" ) . '</p>
	';
	$tab_twitter_message = '
		<p><strong>' . __( "Twitter Message", "dk_speakout" ) . '</strong>&mdash;' . __( "Enter a prepared tweet that will be presented to users when the Twitter button is clicked.", "dk_speakout" ) . '</p>
	';
	$tab_petition_options = '
		<p><strong>' . __( "Confirm signatures", "dk_speakout" ) . '</strong>&mdash;' . __( "Use this option to cause an email to be sent to the signers of your petition. This email contains a special link must be clicked to confirm the signer's email address. Petition emails will not be sent until the signature is confirmed.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Allow custom messages", "dk_speakout" ) . '</strong>&mdash;' . __( "Check this option to allow signatories to customize the text of their petition email.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Set signature goal", "dk_speakout" ) . '</strong>&mdash;' . __( "Enter the number of signatures you hope to collect. This number is used to calculate the progress bar display.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Set expiration date", "dk_speakout" ) . '</strong>&mdash;' . __( "Use this option to stop collecting signatures on a specific date.", "dk_speakout" ) . '</p>
	';
	$tab_display_options = '
		<p><strong>' . __( "Display address fields", "dk_speakout" ) . '</strong>&mdash;' . __( "Select the address fields to display in the petition form.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Display custom field", "dk_speakout" ) . '</strong>&mdash;' . __( "Add a custom field to the petition form for collecting additional data.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Display opt-in checkbox", "dk_speakout" ) . '</strong>&mdash;' . __( "Include a checkbox that allows users to consent to receiving further email.", "dk_speakout" ) . '</p>
	';

	// create the tabs
	$screen = get_current_screen();

	$screen->add_help_tab( array (
		'id'      => 'dk_speakout_help_petition',
		'title'   => __( "Petition", "dk_speakout" ),
		'content' => $tab_petitions
	));
	$screen->add_help_tab( array (
		'id'      => 'dk_speakout_help_twitter_message',
		'title'   => __( "Twitter Message", "dk_speakout" ),
		'content' => $tab_twitter_message
	));
	$screen->add_help_tab( array (
		'id'      => 'dk_speakout_help_petition_options',
		'title'   => __( "Petition Options", "dk_speakout" ),
		'content' => $tab_petition_options
	));
	$screen->add_help_tab( array (
		'id'      => 'dk_speakout_help_display_options',
		'title'   => __( "Display Options", "dk_speakout" ),
		'content' => $tab_display_options
	));
}

// contextual help for Settings page
function dk_speakout_help_settings() {
	$tab_petition_form = '
		<p>' . __( "These settings control the display of the [emailpetition] shortcode and sidebar widget.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Petition Theme", "dk_speakout" ) . '</strong>&mdash;' . __( "Select a CSS theme that will control the appearance of petition forms.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Widget Theme", "dk_speakout" ) . '</strong>&mdash;' . __( "Select a CSS theme that will control the appearance of petition widgets.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Submit Button Text", "dk_speakout" ) . '</strong>&mdash;' . __( "Enter the text that displays in the orange submit button on petition forms.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Success Message", "dk_speakout" ) . '</strong>&mdash;' . __( "Enter the text that appears when a user successfully signs your petition with a unique email address.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Share Message", "dk_speakout" ) . '</strong>&mdash;' . __( "Enter the text that appears above the Twitter and Facebook buttons after the petition form has been submitted.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Expiration Message", "dk_speakout" ) . '</strong>&mdash;' . __( "Enter the text to display in place of the petition form when a petition is past its expiration date.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Already Signed Message", "dk_speakout" ) . '</strong>&mdash;' . __( "Enter the text to display when a petition is signed using an email address that has already been submitted.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Opt-in Default", "dk_speakout" ) . '</strong>&mdash;' . __( "Choose whether the opt-in checkbox is checked or unchecked by default.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Display signature count", "dk_speakout" ) . '</strong>&mdash;' . __( "Choose whether you wish to display the number of signatures that have been collected.", "dk_speakout" ) . '</p>
	';
	$tab_confirmation_emails = '
		<p>' . __( "These settings control the content of the confirmation emails.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Email From", "dk_speakout" ) . '</strong>&mdash;' . __( "Enter the email address associated with your website. Confirmation emails will be sent from this address.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Email Subject", "dk_speakout" ) . '</strong>&mdash;' . __( "Enter the subject of the confirmation email.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Email Message", "dk_speakout" ) . '</strong>&mdash;' . __( "Enter the content of the confirmation email.", "dk_speakout" ) . '</p>
	';
	$tab_signature_list = '
		<p>' . __( "These settings control the display of the [signaturelist] shortcode.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Title", "dk_speakout" ) . '</strong>&mdash;' . __( "Enter the text that appears above the signature list.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Theme", "dk_speakout" ) . '</strong>&mdash;' . __( "Select a CSS theme that will control the appearance of signature lists.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Rows", "dk_speakout" ) . '</strong>&mdash;' . __( "Enter the number of signatures that will be displayed in the signature list.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Columns", "dk_speakout" ) . '</strong>&mdash;' . __( "Select the columns that will appear in the signature list.", "dk_speakout" ) . '</p>
	';
	$tab_admin_display = '
		<p>' . __( "These settings control the look of the plugin's options pages within the WordPress administrator.", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Petitions table shows", "dk_speakout" ) . '</strong>&mdash;' . __( "Enter the number of rows to display in the \"Email Petitions\" table", "dk_speakout" ) . '</p>
		<p><strong>' . __( "Signatures table shows", "dk_speakout" ) . '</strong>&mdash;' . __( "Enter the number of rows to display in the \"Signatures\" table", "dk_speakout" ) . '</p>
		<p><strong>' . __( "CSV file includes", "dk_speakout" ) . '</strong>&mdash;' . __( "Select the subset of signatures that will be included in CSV file downloads", "dk_speakout" ) . '</p>
	';

	// create the tabs
	$screen = get_current_screen();

	$screen->add_help_tab( array (
		'id'      => 'dk_speakout_help_petition_form',
		'title'   => __( "Petition Form", "dk_speakout" ),
		'content' => $tab_petition_form
	));
	$screen->add_help_tab( array (
		'id'      => 'dk_speakout_help_signature_list',
		'title'   => __( "Signature List", "dk_speakout" ),
		'content' => $tab_signature_list
	));
	$screen->add_help_tab( array (
		'id'      => 'dk_speakout_help_confirmation_emails',
		'title'   => __( "Confirmation Emails", "dk_speakout" ),
		'content' => $tab_confirmation_emails
	));
	$screen->add_help_tab( array (
		'id'      => 'dk_speakout_help_admin_display',
		'title'   => __( "Admin Display", "dk_speakout" ),
		'content' => $tab_admin_display
	));
}
?>