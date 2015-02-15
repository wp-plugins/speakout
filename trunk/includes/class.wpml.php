<?php

/**
 * Allows integraion with the WPML translation plugin
 */
class dk_speakout_WPML
{
	/**
	 * Registers custom petition form strings for translation with the WPML plugin if WPML is installed
	 *
	 * @param object $petition the current petition object
	 */
	public function register_petition( $petition )
	{
		if ( function_exists( 'icl_register_string' ) ) {

			$context = 'Petition ' . $petition->id;

			icl_register_string( $context, 'petition title', $petition->title );
			icl_register_string( $context, 'email subject', $petition->email_subject );
			icl_register_string( $context, 'greeting', $petition->greeting );
			icl_register_string( $context, 'petition message', $petition->petition_message );
			icl_register_string( $context, 'custom field label', $petition->custom_field_label );
			icl_register_string( $context, 'twitter message', $petition->twitter_message );
			icl_register_string( $context, 'optin label', $petition->optin_label );
		}
	}

	/**
	 * Registers the plugin's options strings for translation in WPML
	 *
	 * @param array $options dk_speakout_options array stored in wp_options
	 */
	public function register_options( $options )
	{
		if ( function_exists( 'icl_register_string' ) ) {

			$context = 'Petition';

			icl_register_string( $context, 'submit button text', $options['button_text'] );
			icl_register_string( $context, 'success message', $options['success_message'] );
			icl_register_string( $context, 'share message', $options['share_message'] );
			icl_register_string( $context, 'expiration message', $options['expiration_message'] );
			icl_register_string( $context, 'already signed message', $options['already_signed_message'] );
			icl_register_string( $context, 'signaturelist title', $options['signaturelist_header'] );
			icl_register_string( $context, 'confirmation email subject', $options['confirm_subject'] );
			icl_register_string( $context, 'confirmation email message', $options['confirm_message'] );
		}
	}

	/**
	 * Register widget strings with WPML
	 *
	 * @param array $instance the widget's custom strings
	 */
	public function register_widget( $instance )
	{
		if ( function_exists( 'icl_register_string' ) ) {

			$context = 'Petition ' . $instance['petition_id'];

			icl_register_string( $context, 'widget title', $instance['title'] );
			icl_register_string( $context, 'widget call to action', $instance['call_to_action'] );
		}
	}

	/**
	 * Deletes custom petition form strings that are registered with WPML
	 *
	 * @param int $id value of the petition's 'id' field in the database
	 */
	public function unregister_petition( $id )
	{
		if ( function_exists( 'icl_unregister_string' ) ) {

			$context = 'Petition ' . $id;

			icl_unregister_string( $context, 'petition title' );
			icl_unregister_string( $context, 'email subject' );
			icl_unregister_string( $context, 'greeting' );
			icl_unregister_string( $context, 'petition message' );
			icl_unregister_string( $context, 'custom field label' );
			icl_unregister_string( $context, 'twitter message' );
			icl_unregister_string( $context, 'optin label' );
		}
	}

	/**
	 * Processes translation for custom petition form strings if WPML plugin is installed
	 *
	 * @param object $petition the current petition object
	 */
	public function translate_petition( $petition )
	{
		if ( function_exists( 'icl_t' ) ) {

			$context = 'Petition ' . $petition->id;

			$petition->title              = icl_t( $context, 'petition title', $petition->title );
			$petition->email_subject      = icl_t( $context, 'email subject', $petition->email_subject );
			$petition->greeting           = icl_t( $context, 'greeting', $petition->greeting );
			$petition->petition_message   = icl_t( $context, 'petition message', $petition->petition_message );
			$petition->custom_field_label = icl_t( $context, 'custom field label', $petition->custom_field_label );
			$petition->twitter_message    = icl_t( $context, 'twitter message', $petition->twitter_message );
			$petition->optin_label        = icl_t( $context, 'optin label', $petition->optin_label );
		}
	}

	/**
	 * Processes translation for custom petition form strings if WPML plugin is installed
	 *
	 * @param object $petition the current petition object
	 * @return array translated version of dk_speakout_options array
	 */
	public function translate_options( $options )
	{
		if ( function_exists( 'icl_t' ) ) {

			$context = 'Petition';

			$options['button_text']            = icl_t( $context, 'submit button text', $options['button_text'] );
			$options['success_message']        = icl_t( $context, 'success message', $options['success_message'] );
			$options['share_message']          = icl_t( $context, 'share message', $options['share_message'] );
			$options['expiration_message']     = icl_t( $context, 'expiration message', $options['expiration_message'] );
			$options['already_signed_message'] = icl_t( $context, 'already signed message', $options['already_signed_message'] );
			$options['signaturelist_header']   = icl_t( $context, 'signaturelist title', $options['signaturelist_header'] );
			$options['confirm_subject']        = icl_t( $context, 'confirmation email subject', $options['confirm_subject'] );
			$options['confirm_message']        = icl_t( $context, 'confirmation email message', $options['confirm_message'] );

			return $options;
		}
		else {
			return $options;
		}
	}

	/**
	 * Processes translation widget strings in WPML
	 */
	public function translate_widget( $instance )
	{
		if ( function_exists( 'icl_t' ) ) {

			$context = 'Petition ' . $instance['petition_id'];

			$instance['title']          = icl_t( $context, 'widget title',  $instance['title'] );
			$instance['call_to_action'] = icl_t( $context, 'widget call to action', $instance['call_to_action'] );

			return $instance;
		}
		else {
			return $instance;
		}
	}

}