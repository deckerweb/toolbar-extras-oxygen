<?php

// includes/items-plugins-oxygen-addons

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * 1st GROUP: Creative Content:
 * @since 1.0.0
 * -----------------------------------------------------------------------------
 */

/**
 * Add-On: My Custom Functionality (free, by Sridhar Katakam)
 * @since 1.1.0
 */
if ( function_exists( 'custom_enqueue_files' ) ) {
	require_once TBEXOB_PLUGIN_DIR . 'includes/oxygen-addons/items-my-custom-functionality.php';
}



/**
 * 2nd GROUP: Settings, Extras, Elements etc.
 * @since 1.0.0
 * -----------------------------------------------------------------------------
 */

/**
 * Add-On: Oxygens Swiss Knife (free, by Marko Krstic)
 * @since 1.0.0
 */
if ( function_exists( 'twy_cleenup_functions_frontend' ) ) {
	require_once TBEXOB_PLUGIN_DIR . 'includes/oxygen-addons/items-oxygens-swiss-knife.php';
}


/**
 * Add-On: Oxygen Theme Enabler (free, by Sridhar Katakam)
 * @since 1.0.0
 */
if ( ddw_tbexob_is_oxygen_theme_enabler_active() ) {
	require_once TBEXOB_PLUGIN_DIR . 'includes/oxygen-addons/items-oxygen-theme-enabler.php';
}



/**
 * Conditional Hook Position for Add-Ons
 * @since 1.0.0
 * -----------------------------------------------------------------------------
 */

if ( ! function_exists( 'ddw_tbex_addons_hook_place' ) ) {
	require_once TBEX_PLUGIN_DIR . 'includes/hook-place-addons.php';	// in Toolbar Extras!
}
