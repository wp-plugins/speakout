<?php
// create admin menus
add_action( 'admin_menu', 'dk_speakout_create_menus' );
function dk_speakout_create_menus() {

	// load sidebar menus
	$petitions = array(
		'page_title' => __( 'Email Petitions', 'dk_speakout' ),
		'menu_title' => __( 'Email Petitions', 'dk_speakout' ),
		'capability' => 'publish_posts',
		'menu_slug'  => 'dk_speakout',
		'function'   => 'dk_speakout_petitions_page',
		'icon_url'   => plugins_url( 'speakout/images/blank.png' )
	);
	$petitions_page = add_menu_page( $petitions['page_title'], $petitions['menu_title'], $petitions['capability'], $petitions['menu_slug'], $petitions['function'], $petitions['icon_url'] );

	$addnew = array(
		'parent_slug' => 'dk_speakout',
		'page_title'  => __( 'Add New', 'dk_speakout' ),
		'menu_title'  => __( 'Add New', 'dk_speakout' ),
		'capability'  => 'publish_posts',
		'menu_slug'   => 'dk_speakout_addnew',
		'function'    => 'dk_speakout_addnew_page'
	);
	$addnew_page = add_submenu_page( $addnew['parent_slug'], $addnew['page_title'], $addnew['menu_title'], $addnew['capability'], $addnew['menu_slug'], $addnew['function'] );

	$signatures = array(
		'parent_slug' => 'dk_speakout',
		'page_title'  => __( 'Signatures', 'dk_speakout' ),
		'menu_title'  => __( 'Signatures', 'dk_speakout' ),
		'capability'  => 'publish_posts',
		'menu_slug'   => 'dk_speakout_signatures',
		'function'    => 'dk_speakout_signatures_page'
	);
	$signatures_page = add_submenu_page( $signatures['parent_slug'], $signatures['page_title'], $signatures['menu_title'], $signatures['capability'], $signatures['menu_slug'], $signatures['function'] );

	$settings = array(
		'parent_slug' => 'dk_speakout',
		'page_title'  => __( 'Email Petitions Settings', 'dk_speakout' ),
		'menu_title'  => __( 'Settings', 'dk_speakout' ),
		'capability'  => 'manage_options',
		'menu_slug'   => 'dk_speakout_settings',
		'function'    => 'dk_speakout_settings_page'
	);
	$settings_page = add_submenu_page( $settings['parent_slug'], $settings['page_title'], $settings['menu_title'], $settings['capability'], $settings['menu_slug'], $settings['function'] );

	// load contextual help tabs for newer WordPress installs (requires 3.3.1)
	if ( version_compare( get_bloginfo( 'version' ), '3.3', '>' ) == 1 ) {
		add_action( 'load-' . $addnew_page, 'dk_speakout_help_addnew' );
		add_action( 'load-' . $settings_page, 'dk_speakout_help_settings' );
	}
}

// display custom menu icon
add_action( 'admin_head', 'dk_speakout_menu_icon' );
function dk_speakout_menu_icon() {
	echo '
		<style type="text/css">
			#toplevel_page_dk_speakout .wp-menu-image {
				background: url(' . plugins_url( "speakout/images/icon-emailpetitions-16.png" ) . ') no-repeat 6px 7px !important;
			}
			body.admin-color-classic #toplevel_page_dk_speakout .wp-menu-image {
				background: url(' . plugins_url( "speakout/images/icon-emailpetitions-16.png" ) . ') no-repeat 6px -41px !important;
			}
			#toplevel_page_dk_speakout:hover .wp-menu-image, #toplevel_page_dk_speakout.wp-has-current-submenu .wp-menu-image {
				background-position: 6px -17px !important;
			}
			body.admin-color-classic #toplevel_page_dk_speakout:hover .wp-menu-image, body.admin-color-classic #toplevel_page_dk_speakout.wp-has-current-submenu .wp-menu-image {
				background-position: 6px -17px !important;
			}

		</style>
	';
}

// load JavaScript for use on admin pages
add_action( 'admin_print_scripts', 'dk_speakout_admin_js' );
function dk_speakout_admin_js() {
	global $parent_file;

	if ( $parent_file == 'dk_speakout' ) {
		wp_enqueue_script( 'dk_speakout_admin_js', plugins_url( 'speakout/js/admin.js' ), array( 'jquery' ) );
		wp_enqueue_script( 'post', admin_url( 'js/post.js' ), 'jquery' );
	}
}

// load CSS for use on admin pages
add_action( 'admin_print_styles', 'dk_speakout_admin_css' );
function dk_speakout_admin_css() {
	global $parent_file;

	if ( $parent_file == 'dk_speakout' ) {
		wp_enqueue_style( 'dk_speakout_admin_css', plugins_url( 'speakout/css/admin.css' ) );
	}
}

?>