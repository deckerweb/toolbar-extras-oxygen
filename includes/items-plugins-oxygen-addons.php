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
 * Add-On: Oxygen Block Lab Support (free, by David Browne)
 * @since 1.2.0
 */
if ( function_exists( 'block_lab' ) && function_exists( 'lit_new_block_template_path' ) ) {
	require_once TBEXOB_PLUGIN_DIR . 'includes/oxygen-addons/items-oxygen-blocklab-support.php';
}


/**
 * Add-On: Oxygen EDD Support (free, by David Browne)
 * @since 1.2.0
 */
if ( class_exists( 'Easy_Digital_Downloads' ) && function_exists( 'lit_oxygen_edd_template_dir' ) ) {
	require_once TBEXOB_PLUGIN_DIR . 'includes/oxygen-addons/items-oxygen-edd-support.php';
}


/**
 * Add-On: Oxygen RCP Support (free, by David Browne)
 * @since 1.2.0
 */
if ( class_exists( 'RCP_Requirements_Check' ) && function_exists( 'lit_oxygen_rcp_template_location' ) ) {
	require_once TBEXOB_PLUGIN_DIR . 'includes/oxygen-addons/items-oxygen-rcp-support.php';
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
