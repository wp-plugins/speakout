<?php

/**
 * Class for accessing and manipulating signature data in SpeakOut! Email Petitions plugin for WordPress
 */
class dk_speakout_Signature
{
	public $id;
	public $petitions_id;
	public $first_name = '';
	public $last_name = '';
	public $email = '';
	public $street_address = '';
	public $city = '';
	public $state = '';
	public $postcode = '';
	public $country = '';
	public $custom_field = '';
	public $optin = '';
	public $date = '';
	public $confirmation_code = '';
	public $is_confirmed = '';
	public $custom_message = '';
	public $submitted_message = '';
	public $language = '';

	/**
	 * Retrieves a selection of signature records from the database
	 * 
	 * @param $petition_id (int) optional: the id of the petition whose signature should be retrieved
	 * @param $start (int) optional: the first record to be retrieved
	 * @param $limit (int) optional: the maximum number of records to be retrieved
	 * @param $context (string) optional: context the method is being called from ('csv' or 'signaturelist')
	 * @return (object) query results
	 */
	public function all( $petition_id, $start = 0, $limit = 0, $context = '' )
	{
		global $wpdb, $db_petitions, $db_signatures;

		// restrict query results to signatures from a single petition?
		$sql_petition_filter = '';
		if ( $petition_id ) {
			$sql_petition_filter = "AND $db_signatures.petitions_id = '$petition_id'";
		}

		// limit query results returned if $limit filter is provided
		$sql_limit = '';
		if ( $limit != 0 ) {
			$sql_limit = 'LIMIT ' . $start . ', ' . $limit;
		}

		$sql_context_filter = '';
		// restrict results to either single or double opt-in signatures
		if ( $context == 'csv' ) {
			$options = get_option( 'dk_speakout_options' );

			if ( $options['csv_signatures'] == 'single_optin' ) {
				$sql_context_filter = "AND $db_signatures.optin = '1'";
			}
			elseif ( $options['csv_signatures'] == 'double_optin' ) {
				$sql_context_filter = "AND $db_signatures.optin = '1' AND $db_signatures.is_confirmed = '1'" ;
			}
		}
		// exclude unconfirmed signatures
		elseif ( $context == 'signaturelist' ) {
			$sql_context_filter = "AND ( $db_signatures.is_confirmed = '' OR $db_signatures.is_confirmed = '1' )";
		}

		$sql = "
			SELECT $db_signatures.*, $db_petitions.title, $db_petitions.custom_field_label
			FROM `$db_signatures`, `$db_petitions`
			WHERE $db_signatures.petitions_id = $db_petitions.id
			$sql_petition_filter
			$sql_context_filter
			ORDER BY $db_signatures.id DESC $sql_limit
		";
		$query_results = $wpdb->get_results( $sql );

		return $query_results;
	}

	/**
	 * Checks if a signature has been confirmed by matching a provided confirmation code with one in the database
	 * 
	 * @param $confirmation_code (string) the confirmation code to check
	 * @return (bool) true if match is found, false if no match is found
	 */
	public function check_confirmation( $confirmation_code )
	{
		global $wpdb, $db_signatures;

		$sql = "
			SELECT id
			FROM $db_signatures
			WHERE `confirmation_code` = '$confirmation_code' AND `is_confirmed` = '1'
		";
		$query_results = $wpdb->get_row( $sql );

		if ( count( $query_results ) > 0 ) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Attempts to confirm an email address by matching the confirmation code provided with one in the database
	 * 
	 * @param $confirmation_code (string) variable sent through link in confirmation email
	 * @return (bool) true if confirmation status was updated, false if confirmation code was not found or the signature was already confirmed
	 */
	public function confirm( $confirmation_code )
	{
		global $wpdb, $db_signatures;

		$data  = array( 'is_confirmed' => 1 );
		$where = array( 'confirmation_code' => $confirmation_code );

		$rows_affected = $wpdb->update( $db_signatures, $data, $where );

		if ( $rows_affected > 0 ) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Counts the number of signatures in the database
	 * 
	 * @param $petition_id (int) optional: unique 'id' of a petition, used to limit results to a single petition
	 * @return (int) the number of signatures found in the database
	 */
	public function count( $petition_id, $context = '' )
	{
		global $wpdb, $db_signatures;

		// count number of signatures in db
		// add WHERE clause if counting signatures from a single petition
		$sql_where = '';
		if ( $petition_id ) {
			$sql_where = "WHERE `petitions_id` = '$petition_id'";
		}

		// exclude unconfirmed signatures
		$sql_context_filter = '';
		if ( $context == 'signaturelist' ) {
			$sql_context_filter = "AND ( $db_signatures.is_confirmed = '' OR $db_signatures.is_confirmed = '1' )";
		}

		$sql = "
			SELECT `id`
			FROM `$db_signatures`
			$sql_where
			$sql_context_filter
		";
		$query_results = $wpdb->get_results( $sql );

		return count( $query_results );
	}

	/**
	 * Creates a new signature record in the database
	 * 
	 * @param $petition_id (int) the unique id of the petition we are signing
	 */
	public function create( $petition_id )
	{
		global $wpdb, $db_signatures;

		$data = array(
			'petitions_id'      => $petition_id,
			'first_name'        => $this->first_name,
			'last_name'         => $this->last_name,
			'email'             => $this->email,
			'date'              => $this->date,
			'confirmation_code' => $this->confirmation_code,
			'is_confirmed'      => $this->is_confirmed,
			'optin'             => $this->optin,
			'street_address'    => $this->street_address,
			'city'              => $this->city,
			'state'             => $this->state,
			'postcode'          => $this->postcode,
			'country'           => $this->country,
			'custom_field'      => $this->custom_field,
			'custom_message'    => $this->custom_message,
			'language'          => $this->language
		);

		$format = array( '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' );

		$wpdb->insert( $db_signatures, $data, $format );

		// grab the id of the record we just added to the database
		$this->id = $wpdb->insert_id;
	}

	/**
	 * Generates a confirmation code and assigns it to this object
	 */
	public function create_confirmation_code()
	{
		$this->confirmation_code = substr( md5( uniqid() ), 0, 16 );
	}

	/**
	 * Deletes a signature from the database
	 * 
	 * @param int $signature_id value of the signature's 'id' field in the database
	 */
	public function delete( $signature_id )
	{
		global $wpdb, $db_signatures;

		$sql = "
			DELETE FROM `$db_signatures`
			WHERE `id` = %d
		";
		$wpdb->query( $wpdb->prepare( $sql, $signature_id ) );
	}

	/**
	 * Determines whether an email address has previously been used to sign the petition
	 * 
	 * @param string $email email address
	 * @param int $petition_id the petition whose signatures we are searching
	 * @return true if signature is unique, false if signature has been used
	 */
	public function has_unique_email( $email, $petition_id )
	{
		global $wpdb, $db_signatures;

		$sql = "
			SELECT `id`
			FROM $db_signatures
			WHERE `email` = %s AND `petitions_id` = %d
		";
		$query_results = $wpdb->get_row( $wpdb->prepare( $sql, $email, $petition_id ) );

		if ( count( $query_results ) < 1 ) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Poppulates the parameters of this object with posted form values
	 */
	public function poppulate_from_post()
	{
		$this->petitions_id = strip_tags( $_POST['id'] );
		$this->first_name   = strip_tags( $_POST['first_name'] );
		$this->last_name    = strip_tags( $_POST['last_name'] );
		$this->email        = strip_tags( $_POST['email'] );
		$this->date         = current_time( 'mysql', 0 );

		if ( isset( $_POST['custom_message'] ) ) {
			$this->submitted_message = strip_tags( $_POST['custom_message'] );
		}
		if ( isset( $_POST['street'] ) ) {
			$this->street_address = strip_tags( $_POST['street'] );
		}
		if ( isset( $_POST['city'] ) ) {
			$this->city = strip_tags( $_POST['city'] );
		}
		if ( isset( $_POST['state'] ) ) {
			$this->state = strip_tags( $_POST['state'] );
		}
		if ( isset( $_POST['postcode'] ) ) {
			$this->postcode = strip_tags( $_POST['postcode'] );
		}
		if ( isset( $_POST['country'] ) ) {
			$this->country = strip_tags( $_POST['country'] );
		}
		if ( isset( $_POST['custom_field'] ) ) {
			$this->custom_field = strip_tags( $_POST['custom_field'] );
		}
		if ( isset( $_POST['optin'] ) && $_POST['optin'] == 'on' ) {
			$this->optin = 1;
		}
		if ( isset( $_POST['lang'] ) ) {
			$this->language = strip_tags( $_POST['lang'] );
		}
	}

	/**
	 * Reads a signature record from the database and poppulates the object with it's results
	 * 
	 * @param int $signature_id value of the signature's 'id' field in the database
	 */
	public function retrieve( $signature_id )
	{
		global $wpdb, $db_signatures;

		$sql = "
			SELECT *
			FROM `$db_signatures`
			WHERE `id` = %d
		";
		$query_results = $wpdb->get_row( $wpdb->prepare( $sql, $signature_id ) );

		$this->_poppulate_from_query( $query_results );
	}

	/**
	 * Retrieves a confirmed signature via its confirmation_code
	 * and populates this object with the result
	 * 
	 * @param $confirmation_code (string) the signature's confirmation_code
	 */
	public function retrieve_confirmed( $confirmation_code )
	{
		global $wpdb, $db_signatures;

		$sql = "
			SELECT *
			FROM $db_signatures
			WHERE `confirmation_code` = '%s' AND `is_confirmed` = '1'
		";
		$query_results = $wpdb->get_row( $wpdb->prepare( $sql, $confirmation_code ) );

		$this->_poppulate_from_query( $query_results );
	}

	/**
	 * Retrieves unconfirmed signatures from the database
	 * Used to re-send confirmation emails from signatures admin screen
	 * 
	 * @param $petition_id (int) unique 'id' of the petition whose signatures we are searching
	 * @return (object) query results
	 */
	public function unconfirmed( $petition_id )
	{
		global $wpdb, $db_signatures;

		$sql = "
			SELECT `id`, `first_name`, `last_name`, `email`, `confirmation_code`
			FROM $db_signatures
			WHERE `petitions_id` = '%d' AND `is_confirmed` = '0'
		";
		$query_results = $wpdb->get_results( $wpdb->prepare( $sql, $petition_id ) );

		return $query_results;
	}

	//********************************************************************************
	//* Private
	//********************************************************************************

	/**
	 * Poppulates the parameters of this object with values from the database
	 * 
	 * @param $signature (object) database query results
	 */
	private function _poppulate_from_query( $signature )
	{
		$this->id                = $signature->id;
		$this->petitions_id      = $signature->petitions_id;
		$this->first_name        = $signature->first_name;
		$this->last_name         = $signature->last_name;
		$this->email             = $signature->email;
		$this->street_address    = $signature->street_address;
		$this->city              = $signature->city;
		$this->state             = $signature->state;
		$this->postcode          = $signature->postcode;
		$this->country           = $signature->country;
		$this->custom_field      = $signature->custom_field;
		$this->optin             = $signature->optin;
		$this->date              = $signature->date;
		$this->confirmation_code = $signature->confirmation_code;
		$this->is_confirmed      = $signature->is_confirmed;
		$this->custom_message    = $signature->custom_message;
	}

}

?>