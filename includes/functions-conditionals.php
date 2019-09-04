<?php

// includes/functions-conditionals

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * 1st GROUP: Active checks
 * @since 1.0.0
 * -----------------------------------------------------------------------------
 */

/**
 * Is the Toolbar Extras plugin active or not?
 *
 * @since 1.0.0
 *
 * @return bool TRUE if plugin is active, FALSE otherwise.
 */
function ddw_tbexob_is_toolbar_extras_active() {

	return defined( 'TBEX_PLUGIN_VERSION' );

}  // end function


/**
 * Is the Oxygen Builder plugin active or not?
 *
 * @since 1.0.0
 *
 * @return bool TRUE if plugin is active, FALSE otherwise.
 */
function ddw_tbexob_is_oxygen_active() {

	return defined( 'CT_VERSION' );

}  // end function


/**
 * Can the current user access Oxygen Builder items?
 *
 * @since 1.2.0
 *
 * @uses oxygen_vsb_current_user_can_access()
 *
 * @return bool TRUE if Oxygen access function returns true, FALSE otherwise.
 */
function ddw_tbexob_current_user_can_access_oxygen() {

	/** Bail early if function not exists */
	if ( ! function_exists( 'oxygen_vsb_current_user_can_access' ) ) {
		return FALSE;
	}

	/** Return boolean value of function itself */
	return oxygen_vsb_current_user_can_access();

}  // end function


/**
 * Check if Oxygen User Library Module is available or not, that means Oxygen
 *   must be at least in version 2.3 alpha1 or higher.
 *
 * @since 1.0.0
 *
 * @return bool TRUE if class exists, FALSE otherwise.
 */
function ddw_tbexob_is_oxygen_user_library_prepared() {

	return class_exists( 'OXY_VSB_Connection' );

}  // end function


/**
 * Check if Oxygen User Library Module is activated in plugin settings or not.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_is_oxygen_user_library_prepared()
 *
 * @return bool TRUE if option is set to "true", FALSE otherwise.
 */
function ddw_tbexob_is_oxygen_user_library_active() {

	if ( ! ddw_tbexob_is_oxygen_user_library_prepared() ) {
		return FALSE;
	}

	$status = get_option( 'oxygen_vsb_enable_connection' );

	return ( 'true' === $status );

}  // end function


/**
 * Check if import of third-party design sets in Oxygen is activated.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_is_oxygen_user_library_prepared()
 *
 * @return bool TRUE if option is set to "true", FALSE otherwise.
 */
function ddw_tbexob_is_oxygen_design_set_import() {

	if ( ! ddw_tbexob_is_oxygen_user_library_prepared() ) {
		return FALSE;
	}

	$design_sets = get_option( 'oxygen_vsb_enable_3rdp_designsets' );

	return ( 'true' === $design_sets );

}  // end function


/**
 * Is the Oxygen Theme Enabler plugin active or not?
 *
 * @since 1.0.0
 *
 * @return bool TRUE if plugin is active, FALSE otherwise.
 */
function ddw_tbexob_is_oxygen_theme_enabler_active() {

	return class_exists( 'OxygenThemeEnabler' );

}  // end function


/**
 * Is the Oxygen Gutenberg Integration Add-On plugin active or not?
 *
 * @since 1.2.0
 *
 * @return bool TRUE if Add-On plugin is active, FALSE otherwise.
 */
function ddw_tbexob_is_oxygen_gutenberg_active() {

	return class_exists( 'Oxygen_Gutenberg' );

}  // end function



/**
 * 2nd GROUP: Settings (Checks)
 * @since 1.0.0
 * -----------------------------------------------------------------------------
 */

/**
 * Check if a post type item contains Oxygen Builder Elements
 *   (= was edited with Oxygen already).
 *
 * @since 1.0.0
 *
 * @uses get_post_meta()
 *
 * @param int $post_id ID of the post type item to check for.
 * @return bool TRUE if post meta key exists, FALSE otherwise.
 */
function ddw_tbexob_is_builder( $post_id ) {

	return get_post_meta( absint( $post_id ), 'ct_builder_shortcodes', TRUE );

}  // end function


/**
 * Tweak: Display Settings Customizer in Build Group?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return bool TRUE if tweak should be used (setting 'yes'), FALSE otherwise.
 */
function ddw_tbexob_display_settings_customizer() {

	return ( 'yes' === ddw_tbex_get_option( 'oxygen', 'oxygen_display_customizer' ) );

}  // end function


/**
 * Tweak: Display post type Row Actions for Oxygen?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return bool TRUE if tweak should be used (setting 'yes'), FALSE otherwise.
 */
function ddw_tbexob_display_row_actions() {

	return ( 'yes' === ddw_tbex_get_option( 'oxygen', 'oxygen_row_actions' ) );

}  // end function


/**
 * Tweak: Display post type Post State for Oxygen?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return bool TRUE if tweak should be used (setting 'yes'), FALSE otherwise.
 */
function ddw_tbexob_display_post_state() {

	return ( 'yes' === ddw_tbex_get_option( 'oxygen', 'oxygen_post_state' ) );

}  // end function


/**
 * Tweak: Display Template Group for Oxygen Templates?
 *
 * @since 1.2.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return bool TRUE if tweak should be used (setting 'yes'), FALSE otherwise.
 */
function ddw_tbexob_display_template_group() {

	return ( 'yes' === ddw_tbex_get_option( 'oxygen', 'display_tpl_toolbar' ) );

}  // end function


/**
 * Tweak: Display Pages Group for Oxygen editable Pages?
 *
 * @since 1.2.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return bool TRUE if tweak should be used (setting 'yes'), FALSE otherwise.
 */
function ddw_tbexob_display_pages_group() {

	return ( 'yes' === ddw_tbex_get_option( 'oxygen', 'display_pages_toolbar' ) );

}  // end function


/**
 * Tweak: Enable "Back to WP" additional links.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return bool TRUE if tweak should be used (setting 'yes'), FALSE otherwise.
 */
function ddw_tbexob_add_more_btwp_links() {

	return ( 'yes' === ddw_tbex_get_option( 'oxygen', 'oxygen_btwp_links' ) );

}  // end function



/**
 * 3rd GROUP: Tweaks (Removings etc.)
 * @since 1.0.0
 * -----------------------------------------------------------------------------
 */

/**
 * Tweak: Remove "Themes" submenu from "Appearance".
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return bool TRUE if tweak should be used (setting 'yes'), FALSE otherwise.
 */
function ddw_tbexob_use_tweak_remove_submenu_themes() {

	return ( 'yes' === ddw_tbex_get_option( 'oxygen', 'remove_submenu_themes' ) );

}  // end function


/**
 * Tweak: Remove "Customizer" submenu from "Appearance".
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return bool TRUE if tweak should be used (setting 'yes'), FALSE otherwise.
 */
function ddw_tbexob_use_tweak_remove_submenu_customizer() {

	return ( 'yes' === ddw_tbex_get_option( 'oxygen', 'remove_submenu_customizer' ) );

}  // end function


/**
 * Tweak: Remove "Theme Editor" submenu from "Appearance".
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return bool TRUE if tweak should be used (setting 'yes'), FALSE otherwise.
 */
function ddw_tbexob_use_tweak_remove_theme_editor() {

	return ( 'yes' === ddw_tbex_get_option( 'oxygen', 'remove_theme_editor' ) );

}  // end function


/**
 * Tweak: Unload Oxygen Builder translations?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return bool TRUE if tweak should be used (setting 'yes'), FALSE otherwise.
 */
function ddw_tbexob_use_tweak_unload_translations_oxygen() {

	return ( 'yes' === ddw_tbex_get_option( 'oxygen', 'unload_td_oxygen' ) );

}  // end function


/**
 * Tweak: Unload Toolbar Extras for Oxygen translations?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return bool TRUE if tweak should be used (setting 'yes'), FALSE otherwise.
 */
function ddw_tbexob_use_tweak_unload_translations_tbexob() {

	return ( 'yes' === ddw_tbex_get_option( 'oxygen', 'unload_td_tbexob' ) );

}  // end function
