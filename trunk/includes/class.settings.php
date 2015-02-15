<?php

/**
 * Class for accessing and manipulating settings array in SpeakOut! Email Petitions plugin for WordPress
 */
class dk_speakout_Settings
{
	public $petitions_rows;
	public $signatures_rows;
	public $petition_theme;
	public $widget_theme;
	public $button_text;
	public $expiration_message;
	public $success_message;
	public $already_signed_message;
	public $share_message;
	public $confirm_subject;
	public $confirm_message;
	public $confirm_email;
	public $optin_default;
	public $display_count;
	public $csv_signatures;
	public $signaturelist_theme;
	public $signaturelist_header;
	public $signaturelist_rows;
	public $signaturelist_columns;
	public $signaturelist_privacy;
	public $sig_city = 0;
	public $sig_state = 0;
	public $sig_postcode = 0;
	public $sig_country = 0;
	public $sig_custom = 0;
	public $sig_date = 0;

	/**
	 * Retrieves the plugin options and poppulates this object
	 */
	public function retrieve()
	{
		$options  = get_option( 'dk_speakout_options' );

		$this->petitions_rows         = $options['petitions_rows'];
		$this->signatures_rows        = $options['signatures_rows'];
		$this->petition_theme         = $options['petition_theme'];
		$this->widget_theme           = $options['widget_theme'];
		$this->button_text            = $options['button_text'];
		$this->expiration_message     = $options['expiration_message'];
		$this->success_message        = $options['success_message'];
		$this->already_signed_message = $options['already_signed_message'];
		$this->share_message          = $options['share_message'];
		$this->confirm_subject        = $options['confirm_subject'];
		$this->confirm_message        = $options['confirm_message'];
		$this->confirm_email          = $options['confirm_email'];
		$this->optin_default          = $options['optin_default'];
		$this->display_count          = $options['display_count'];
		$this->csv_signatures         = $options['csv_signatures'];
		$this->signaturelist_theme    = $options['signaturelist_theme'];
		$this->signaturelist_header   = $options['signaturelist_header'];
		$this->signaturelist_rows     = $options['signaturelist_rows'];
		$this->signaturelist_privacy  = $options['signaturelist_privacy'];
		$this->signaturelist_columns  = $options['signaturelist_columns'];

		$this->_read_signaturelist_columns();
	}

	/**
	 * Updates the plugin options
	 */
	public function update()
	{
		$this->_clean_post_data();

		$options = array(
			'petitions_rows'         => $this->petitions_rows,
			'signatures_rows'        => $this->signatures_rows,
			'petition_theme'         => $this->petition_theme,
			'widget_theme'           => $this->widget_theme,
			'button_text'            => $this->button_text,
			'expiration_message'     => $this->expiration_message,
			'success_message'        => $this->success_message,
			'already_signed_message' => $this->already_signed_message,
			'share_message'          => $this->share_message,
			'confirm_subject'        => $this->confirm_subject,
			'confirm_message'        => $this->confirm_message,
			'confirm_email'          => $this->confirm_email,
			'optin_default'          => $this->optin_default,
			'display_count'          => $this->display_count,
			'csv_signatures'         => $this->csv_signatures,
			'signaturelist_theme'    => $this->signaturelist_theme,
			'signaturelist_header'   => $this->signaturelist_header,
			'signaturelist_rows'     => $this->signaturelist_rows,
			'signaturelist_columns'  => $this->signaturelist_columns,
			'signaturelist_privacy'  => $this->signaturelist_privacy
		);

		update_option( 'dk_speakout_options', $options );
	}

	/**
	 * Constructs an array of user-allowed HTML tags for use with wp_kses()
	 */
	private function _allowed_html_tags()
	{
		$allowed_tags = array(
			'a'      => array( 'href' => array(),'title' => array() ),
			'em'     => array(),
			'strong' => array(),
			'p'      => array()
		);

		return $allowed_tags;
	}

	/**
	 * Prepares user-submitted form values for placing in the database
	 */
	private function _clean_post_data()
	{
		$allowed_tags = $this->_allowed_html_tags();
		$signaturelist_columns = $this->_write_signaturelist_columns();

		$this->petitions_rows         = absint( $_POST['petitions_rows'] );
		$this->signatures_rows        = absint( $_POST['signatures_rows'] );
		$this->petition_theme         = $_POST['petition_theme'];
		$this->widget_theme           = $_POST['widget_theme'];
		$this->button_text            = esc_html( stripslashes( $_POST['button_text'] ) );
		$this->expiration_message     = esc_html( stripslashes( $_POST['expiration_message'] ) );
		$this->success_message        = wp_kses( stripslashes( $_POST['success_message'] ), $allowed_tags );
		$this->already_signed_message = esc_html( stripslashes( $_POST['already_signed_message'] ) );
		$this->share_message          = esc_html( stripslashes( $_POST['share_message'] ) );
		$this->confirm_subject        = esc_html( $_POST['confirm_subject'] );
		$this->confirm_message        = strip_tags( stripslashes( $_POST['confirm_message'] ) );
		$this->confirm_email          = stripslashes( $_POST['confirm_email'] );
		$this->optin_default          = $_POST['optin_default'];
		$this->display_count          = $_POST['display_count'];
		$this->csv_signatures         = $_POST['csv_signatures'];
		$this->signaturelist_theme    = $_POST['signaturelist_theme'];
		$this->signaturelist_header   = esc_html( stripslashes( $_POST['signaturelist_header'] ) );
		$this->signaturelist_rows     = absint( $_POST['signaturelist_rows'] );
		$this->signaturelist_columns  = $signaturelist_columns;
		$this->signaturelist_privacy    = $_POST['signaturelist_privacy'];
	}

	/**
	 * Unserializes signaturelist_columns array and assigns values to this object
	 */
	private function _read_signaturelist_columns()
	{
		$signature_columns = unserialize( $this->signaturelist_columns );

		if ( in_array( 'sig_city', $signature_columns ) ) {
			$this->sig_city = 1;
		}
		if ( in_array( 'sig_state', $signature_columns ) ) {
			$this->sig_state = 1;
		}
		if ( in_array( 'sig_postcode', $signature_columns ) ) {
			$this->sig_postcode = 1;
		}
		if ( in_array( 'sig_country', $signature_columns ) ) {
			$this->sig_country = 1;
		}
		if ( in_array( 'sig_custom', $signature_columns ) ) {
			$this->sig_custom = 1;
		}
		if ( in_array( 'sig_date', $signature_columns ) ) {
			$this->sig_date = 1;
		}
	}

	/**
	 * Creates array from signaturelist columns values
	 * and serializes the array for placement in the database
	 */
	private function _write_signaturelist_columns()
	{
		$columns = array();

		if ( isset( $_POST['sig_city'] ) ) {
			array_push( $columns, 'sig_city' );
		}
		if ( isset( $_POST['sig_state'] ) ) {
			array_push( $columns, 'sig_state' );
		}
		if ( isset( $_POST['sig_postcode'] ) ) {
			array_push( $columns, 'sig_postcode' );
		}
		if ( isset( $_POST['sig_country'] ) ) {
			array_push( $columns, 'sig_country' );
		}
		if ( isset( $_POST['sig_custom'] ) ) {
			array_push( $columns, 'sig_custom' );
		}
		if ( isset( $_POST['sig_date'] ) ) {
			array_push( $columns, 'sig_date' );
		}

		return serialize( $columns );
	}
	
}

?>