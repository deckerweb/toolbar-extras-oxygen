<?php

// includes/tbexob-update-settings

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'plugins_loaded', 'ddw_tbexob_addon_check_version' );
/**
 * Update plugin's options to newest version.
 *
 * @since 1.2.0
 */
function ddw_tbexob_addon_check_version() {

	/**
	 * Bail early if we already on plugin version 1.4.0 or higher,
	 *   or, if current user has no permission.
	 */
	if ( ! current_user_can( 'manage_options' )
		&& version_compare( get_option( 'tbexob-addon-version' ), '1.2.0', '>=' )
	) {
		return;
	}


	/**
	 * Update new options for plugin version 1.2.0 or higher
	 * @since 1.2.0
	 * -------------------------------------------------------------------------
	 */
		$oxygenao_v120 = array(
			'oxygen_tl_note'         => '',
			'display_tpl_toolbar'    => 'no',
			'display_tpl_name'       => esc_attr_x( 'Templates', 'Toolbar top-level item title', 'toolbar-extras-oxygen' ),
			'display_tpl_count'      => 10,
			'display_tpl_use_icon'   => 'oxygen',
			'display_tpl_icon'       => 'dashicons-welcome-widgets-menus',
			'display_tpl_priority'   => 1000,
			'display_tpl_parent'     => '',
			'display_pages_toolbar'  => 'no',
			'display_pages_name'     => esc_attr_x( 'Pages', 'Toolbar top-level item title', 'toolbar-extras-oxygen' ),
			'display_pages_count'    => 10,
			'display_pages_use_icon' => 'oxygen',
			'display_pages_icon'     => 'dashicons-admin-page',
			'display_pages_priority' => 1000,
			'display_pages_parent'   => '',

		);

		$existing_opt = (array) get_option( 'tbex-options-oxygen' );
		$new_opt      = array();

		if ( ! array_key_exists( 'oxygen_tl_note', $existing_opt )
			|| ! array_key_exists( 'display_tpl_toolbar', $existing_opt )
			|| ! array_key_exists( 'display_tpl_name', $existing_opt )
			|| ! array_key_exists( 'display_tpl_count', $existing_opt )
			|| ! array_key_exists( 'display_tpl_use_icon', $existing_opt )
			|| ! array_key_exists( 'display_tpl_icon', $existing_opt )
			|| ! array_key_exists( 'display_tpl_priority', $existing_opt )
			|| ! array_key_exists( 'display_tpl_parent', $existing_opt )
			|| ! array_key_exists( 'display_pages_toolbar', $existing_opt )
			|| ! array_key_exists( 'display_pages_name', $existing_opt )
			|| ! array_key_exists( 'display_pages_count', $existing_opt )
			|| ! array_key_exists( 'display_pages_use_icon', $existing_opt )
			|| ! array_key_exists( 'display_pages_icon', $existing_opt )
			|| ! array_key_exists( 'display_pages_priority', $existing_opt )
			|| ! array_key_exists( 'display_pages_parent', $existing_opt )
		) {
			$new_opt = wp_parse_args( $oxygenao_v120, $existing_opt );
			update_option( 'tbex-options-oxygen', $new_opt );
		}

	/**
	 * After updating all new setting options, update the version setting to the
	 *   latest version number.
	 *
	 * @since 1.2.0
	 */
	if ( TBEXOB_PLUGIN_VERSION !== get_option( 'tbexob-addon-version' ) ) {
		update_option( 'tbexob-addon-version', TBEXOB_PLUGIN_VERSION );
	}

}  // end function
