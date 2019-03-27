<?php

// includes/admin/admin-help

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


//add_action( 'admin_enqueue_scripts', 'ddw_tbexob_register_styles_help_tabs', 20 );
/**
 * Register CSS styles for our help tabs.
 *
 * @since 1.0.0
 */
function ddw_tbexob_register_styles_help_tabs() {

	wp_register_style(
		'tbexob-help-tabs',
		plugins_url( '/assets/css/tbexob-help.css', dirname( dirname( __FILE__ ) ) ),
		array(),
		TBEXOB_PLUGIN_VERSION,
		'screen'
	);

	wp_enqueue_style( 'tbexob-help-tabs' );

}  // end function


add_action( 'load-edit.php', 'ddw_tbexob_prepare_help_tab', 100 );
add_action( 'load-post.php', 'ddw_tbexob_prepare_help_tab', 100 );
/**
 * Add the plugin's help tab also on Oxygen Template edit screens.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_help_tab()
 */
function ddw_tbexob_prepare_help_tab() {

	$screen = get_current_screen();

    $screen_ids = array( 'edit-ct_template', 'ct_template' );

    if ( in_array( $screen->id, $screen_ids ) ) {
        ddw_tbexob_help_tab();
    }

}  // end function


add_action( 'load-settings_page_toolbar-extras', 'ddw_tbexob_help_tab', 15 );			// Toolbar Extras settings
add_action( 'load-toplevel_page_ct_dashboard_page', 'ddw_tbexob_help_tab', 100 );		// Oxygen Dashboard
add_action( 'load-oxygen_page_oxygen_vsb_settings', 'ddw_tbexob_help_tab', 100 );		// Oxygen Settings
add_action( 'load-plugins_page_toolbar-extras-suggested-plugins', 'ddw_tbexob_help_tab', 100 );
/**
 * Build the help tab for this add-on plugin.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_content_help_sidebar()
 *
 * @global object $GLOBALS[ 'tbexob_screen' ]
 */
function ddw_tbexob_help_tab() {

	$GLOBALS[ 'tbexob_screen' ] = get_current_screen();

	/** Check for proper admin screen & permissions */
	if ( ! $GLOBALS[ 'tbexob_screen' ]
		|| ! is_super_admin()
	) {
		return;
	}

	/** Add the new help tab */
	$GLOBALS[ 'tbexob_screen' ]->add_help_tab(
		array(
			'id'       => 'tbexob-addon-help',
			'title'    => esc_html__( 'Add-On: Oxygen', 'toolbar-extras-oxygen' ),
			'callback' => apply_filters(
				'tbexob/filter/content/help_tab',
				'ddw_tbexob_help_tab_content'
			),
		)
	);

	/** Load the actual help content view */
	require_once TBEXOB_PLUGIN_DIR . 'includes/admin/views/help-content-addon.php';

	$screens_for_sidebar = array(
		'toplevel_page_ct_dashboard_page',
		'edit-ct_template',
		'oxygen_page_oxygen_vsb_settings',
		'plugins_page_toolbar-extras-suggested-plugins'
	);

	/** Add help sidebar from TBEX */
	if ( 'plugins_page_toolbar-extras-suggested-plugins' === $GLOBALS[ 'tbexob_screen' ]->id
		|| in_array( $GLOBALS[ 'tbexob_screen' ]->id, $screens_for_sidebar )
	) {

		require_once TBEX_PLUGIN_DIR . 'includes/admin/views/help-content-sidebar.php';

		$GLOBALS[ 'tbexob_screen' ]->set_help_sidebar( ddw_tbex_content_help_sidebar() );

	}  // end if

	/** CSS style tweaks */
	add_action( 'admin_enqueue_scripts', 'ddw_tbexob_register_styles_help_tabs', 20 );

}  // end function
