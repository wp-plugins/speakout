<?php

/**
 * Class for accessing and manipulating petition data in SpeakOut! Email Petitions plugin for WordPress
 */
class dk_speakout_Petition
{

	public $id;
	public $title;
	public $target_email;
	public $email_subject;
	public $greeting;
	public $petition_message;
	public $address_fields = array();
	public $expires = 0;
	public $expiration_date = '0000-00-00 00:00:00';
	public $created_date;
	public $goal = 0;
	public $is_editable = 0;
	public $sends_email = 1;
	public $twitter_message;
	public $requires_confirmation = 0;
	public $return_url;
	public $displays_custom_field = 0;
	public $custom_field_label;
	public $displays_optin = 0;
	public $optin_label;
	public $signatures;

	/**
	 * Retrieves a selection of petition records from the database
	 * 
	 * @param $start (int) the first record to be retrieved
	 * @param $limit (int) the total number of records to be retrieved
	 * @return (object) query results
	 */
	public function all( $start, $limit )
	{
		global $wpdb, $db_petitions, $db_signatures;

		// query petitions and number of signatures for each
		$sql = "
			SELECT $db_petitions.id, $db_petitions.title, $db_petitions.goal,
				COUNT( $db_signatures.id ) AS 'signatures'
			FROM $db_petitions
			LEFT JOIN $db_signatures
				ON $db_petitions.id = $db_signatures.petitions_id
				AND ( $db_signatures.is_confirmed = '' OR $db_signatures.is_confirmed = '1' )
			GROUP BY $db_petitions.id
			ORDER BY `id` DESC
			LIMIT $start, $limit
		";
		$query_results = $wpdb->get_results( $sql );

		return $query_results;
	}

	/**
	 * Counts the number of petitions in the database
	 * 
	 * @return (int) the number of petitions in the database
	 */
	public function count()
	{
		global $wpdb, $db_petitions;

		$sql = "
			SELECT `id`
			FROM `$db_petitions`
		";
		$query_results = $wpdb->get_results( $sql );

		return count( $query_results );
	}

	/**
	 * Creates a new petition record in the database
	 */
	public function create()
	{
		global $wpdb, $db_petitions;

		$data = array(
			'title'                 => $this->title,
			'target_email'          => $this->target_email,
			'email_subject'         => $this->email_subject,
			'greeting'              => $this->greeting,
			'petition_message'      => $this->petition_message,
			'address_fields'        => serialize( $this->address_fields ),
			'expires'               => $this->expires,
			'expiration_date'       => $this->expiration_date,
			'created_date'          => $this->created_date,
			'goal'                  => $this->goal,
			'sends_email'           => $this->sends_email,
			'twitter_message'       => $this->twitter_message,
			'requires_confirmation' => $this->requires_confirmation,
			'return_url'            => $this->return_url,
			'displays_custom_field' => $this->displays_custom_field,
			'custom_field_label'    => $this->custom_field_label,
			'displays_optin'        => $this->displays_optin,
			'optin_label'           => $this->optin_label,
			'is_editable'           => $this->is_editable
		);

		$format = array( '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%d', '%d', '%s', '%d', '%d', '%s', '%d', '%s', '%d' );

		$wpdb->insert( $db_petitions, $data, $format );

		// grab the id of the record we just added to the database
		$this->id = $wpdb->insert_id;
	}

	/**
	 * Deletes a petition and its signatures from the database
	 *
	 * @param $id (int) value of the petition's 'id' field in the database
	 */
	public function delete( $id )
	{
		global $wpdb, $db_petitions, $db_signatures;

		// delete petition from the db
		$sql_petitions = "
			DELETE FROM `$db_petitions`
			WHERE `id` = '%d'
		";
		$wpdb->query( $wpdb->prepare( $sql_petitions, $id ) );

		// delete petition's signatures from the db
		$sql_signatures = "
			DELETE FROM `$db_signatures`
			WHERE `petitions_id` = '%d'
		";
		$wpdb->query( $wpdb->prepare( $sql_signatures, $id ) );
	}

	/**
	 * Breaks expiration date into year, month, day, hour, and minute components
	 *
	 * @return (array) with keys: year, month, day, hour, and minute
	 */
	public function get_expiration_date_components()
	{
		if ( $this->expires == 1 ) {
			$x_date = array(
				'year'    => date( 'Y', strtotime( $this->expiration_date ) ),
				'month'   => date( 'm', strtotime( $this->expiration_date ) ),
				'day'     => date( 'd', strtotime( $this->expiration_date ) ),
				'hour'    => date( 'H', strtotime( $this->expiration_date ) ),
				'minutes' => date( 'i', strtotime( $this->expiration_date ) )
			);
		}
		else {
			// default expiration date should be one week from today at 4:20
			$next_week = strtotime( current_time( 'mysql', 0 ) ) + ( 60 * 60 * 24 * 7 );
			$x_date = array(
				'month'   => date( 'm', $next_week ),
				'day'     => date( 'd', $next_week ),
				'year'    => date( 'Y', $next_week ),
				'hour'    => '16',
				'minutes' => '20'
			);
		}

		return $x_date;
	}

	/**
	 * Poppulates the properties of this object with posted form values
	 */
	public function poppulate_from_post()
	{
		// Meta info
		if ( isset( $_POST['id'] ) ) {
			$this->id = $_POST['id'];
		}
		$this->created_date = current_time( 'mysql', 0 );

		// Title Box
		if ( isset( $_POST['title'] ) && $_POST['title'] != '' ) {
			$this->title = $_POST['title'];
		}
		else {
			$this->title = __( 'No Title', 'dk_speakout' );
		}

		// Petition Box
		if ( isset( $_POST['sends_email'] ) ) {
			$this->sends_email = 0;
		}
		if ( isset( $_POST['target_email'] ) ) {
			$this->target_email = $_POST['target_email'];
		}
		if ( isset( $_POST['email_subject'] ) ) {
			$this->email_subject = $_POST['email_subject'];
		}
		if ( isset( $_POST['greeting'] ) ) {
			$this->greeting = $_POST['greeting'];
		}
		if ( isset( $_POST['petition_message'] ) ) {
			$this->petition_message = $_POST['petition_message'];
		}

		// Twitter Message Box
		if ( isset( $_POST['twitter_message'] ) ) {
			$this->twitter_message = $_POST['twitter_message'];
		}

		// Petition Options Box
		if ( isset( $_POST['requires_confirmation'] ) ) {
			$this->requires_confirmation = 1;
		}
		if ( isset( $_POST['return_url'] ) ) {
			$this->return_url = $_POST['return_url'];
		}
		if ( isset( $_POST['is_editable'] ) ) {
			$this->is_editable = 1;
		}
		if ( isset( $_POST['has_goal'] ) ) {

			if ( isset( $_POST['goal'] ) ) {
				$this->goal = $_POST['goal'];
			}
			else {
				$this->goal = 0;
			}
		}
		if ( isset( $_POST['expires'] ) ) {
			$this->expires = 1;
			$this->_set_expiration_date();
		}

		// Display Options Box
		$address_fields = array();
		if ( isset( $_POST['street'] ) ) {
			array_push( $address_fields, 'street' );
		}
		if ( isset( $_POST['city'] ) ) {
			array_push( $address_fields, 'city' );
		}
		if ( isset( $_POST['state'] ) ) {
			array_push( $address_fields, 'state' );
		}
		if ( isset( $_POST['postcode'] ) ) {
			array_push( $address_fields, 'postcode' );
		}
		if ( isset( $_POST['country'] ) ) {
			array_push( $address_fields, 'country' );
		}
		$this->address_fields = $address_fields;

		if ( isset( $_POST['displays-custom-field'] ) ) {
			$this->displays_custom_field = 1;
		}
		if ( isset( $_POST['custom-field-label'] ) ) {
			$this->custom_field_label = $_POST['custom-field-label'];
		}
		if ( isset( $_POST['displays-optin'] ) ) {
			$this->displays_optin = 1;
		}
		if ( isset( $_POST['optin-label'] ) ) {
			$this->optin_label = $_POST['optin-label'];
		}
	}

	/**
	 * Retrieves a list of petitions to populate select box navigation
	 * Only queries the info needed to populate select box at head of Signatures view
	 *
	 * @return (object) query results
	 */
	public function quicklist()
	{
		global $wpdb, $db_petitions;

		$sql = "
			SELECT id, title
			FROM `$db_petitions`
		";
		$query_results = $wpdb->get_results( $sql );

		return $query_results;
	}

	/**
	 * Reads a petition record and it's signature count from the database
	 * 
	 * @param (int) $id value of the petition's 'id' field in the database
	 * @return (bool) true if query returns a result, false if no results found
	 */
	public function retrieve( $id )
	{
		global $wpdb, $db_petitions, $db_signatures;

		$sql = "
			SELECT $db_petitions.*, COUNT( $db_signatures.id ) AS 'signatures'
			FROM $db_petitions
			LEFT JOIN $db_signatures
				ON $db_petitions.id = $db_signatures.petitions_id
				AND ( $db_signatures.is_confirmed != '0' )
			WHERE $db_petitions.id = %d
			GROUP BY $db_petitions.id
		";
		$petition = $wpdb->get_row( $wpdb->prepare( $sql, $id ) );
		
		if ( count( $petition ) > 0 ) {
			$this->_poppulate_from_query( $petition );
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Updates an existing petition record in the database
	 * 
	 * @param (int) $id value of the petition's 'id' field in the database
	 */
	public function update( $id )
	{
		global $wpdb, $db_petitions;

		$data = array(
			 'title'                 => $this->title,
			 'target_email'          => $this->target_email,
			 'email_subject'         => $this->email_subject,
			 'greeting'              => $this->greeting,
			 'petition_message'      => $this->petition_message,
			 'address_fields'        => serialize( $this->address_fields ),
			 'expires'               => $this->expires,
			 'expiration_date'       => $this->expiration_date,
			 'goal'                  => $this->goal,
			 'sends_email'           => $this->sends_email,
			 'twitter_message'       => $this->twitter_message,
			 'requires_confirmation' => $this->requires_confirmation,
			 'return_url'            => $this->return_url,
			 'displays_optin'        => $this->displays_optin,
			 'optin_label'           => $this->optin_label,
			 'displays_custom_field' => $this->displays_custom_field,
			 'custom_field_label'    => $this->custom_field_label,
			 'is_editable'           => $this->is_editable
		);
		$where = array( 'id' => $id );

		$wpdb->update( $db_petitions, $data, $where );
	}

	//********************************************************************************
	//* Private
	//********************************************************************************

	/**
	 * Poppulates the parameters of this object with values from the database 
	 * 
	 * @param (object) $petition database query results
	 */
	private function _poppulate_from_query( $petition )
	{
		$this->id                    = $petition->id;
		$this->title                 = $petition->title;
		$this->target_email          = $petition->target_email;
		$this->email_subject         = $petition->email_subject;
		$this->greeting              = $petition->greeting;
		$this->petition_message      = $petition->petition_message;
		$this->address_fields        = unserialize( $petition->address_fields );
		$this->expires               = $petition->expires;
		$this->expiration_date       = $petition->expiration_date;
		$this->created_date          = $petition->created_date;
		$this->goal                  = $petition->goal;
		$this->sends_email           = $petition->sends_email;
		$this->twitter_message       = $petition->twitter_message;
		$this->requires_confirmation = $petition->requires_confirmation;
		$this->return_url            = $petition->return_url;
		$this->displays_custom_field = $petition->displays_custom_field;
		$this->custom_field_label    = $petition->custom_field_label;
		$this->displays_optin        = $petition->displays_optin;
		$this->optin_label           = $petition->optin_label;
		$this->signatures            = $petition->signatures;
		$this->is_editable           = $petition->is_editable;
	}

	/**
	 * Creates MySQL-formatted date string from submitted year, month, day, hour, and minute form values
	 * And assigns it to this object's $expiration date parameter
	 */
	private function _set_expiration_date()
	{
		// clean post data
		if ( isset( $_POST['year'] ) ) {
			$year = absint( $_POST['year'] );
		}
		if ( isset( $_POST['month'] ) ) {
			$month = absint( $_POST['month'] );
		}
		if ( isset( $_POST['day'] ) ) {
			$day = absint( $_POST['day'] );
		}
		if ( isset( $_POST['hour'] ) ) {
			$hour = absint( $_POST['hour'] );
		}
		if ( isset( $_POST['minutes'] ) ) {
			$minutes = absint( $_POST['minutes'] );
		}

		// force dates to be rational (ie: converts Jan 45 to Feb 14)
		$timestamp = mktime( $hour, $minutes, 0, $month, $day, $year );
		$year      = date( 'Y', $timestamp );
		$month     = date( 'm', $timestamp );
		$day       = date( 'd', $timestamp );
		$hour      = date( 'H', $timestamp );
		$minutes   = date( 'i', $timestamp );
		$this->expiration_date = $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $minutes;
	}

}

?>