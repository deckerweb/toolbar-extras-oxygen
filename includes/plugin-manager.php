<?php

// includes/plugin-manager

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Optionally include the Toolbar Extras Plugin Manager to manage the required
 *   and suggested plugins.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'ddw_tbex_plugin_manager' ) ) :

	if ( defined( 'TBEX_PLUGIN_DIR' ) ) {
		require_once TBEX_PLUGIN_DIR . 'includes/admin/plugin-manager.php';
	}

endif;


add_filter( 'tbex/filter/plugin_manager', 'ddw_tbexob_plugin_manager_oxygen' );
/**
 * Add the required and suggested plugins for Toolbar Extras for Oxygen Builder
 *   to the plugins array of the Toolbar Extras Plugin Manager.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_pm_badge()
 * @uses ddw_tbex_pmstring_for()
 * @uses ddw_tbex_pmstring_info()
 *
 * @param array $plugins Array of plugins for Plugin Manager.
 * @return array Merged and modified array of plugins and their arguments.
 */
function ddw_tbexob_plugin_manager_oxygen( $plugins ) {

	$class = 'info';

	$for_oxygen = ddw_tbex_pmstring_for( __( 'Add-On for Oxygen Builder', 'toolbar-extras-oxygen' ) );

	$plugins_oxygen = array(
		array(
			'name'    => _x( 'Oxygen Builder', 'Plugin Name', 'toolbar-extras-oxygen' ),
			'slug'    => 'oxygen',
			'version' => '2.2.1+',
			'url'     => 'https://oxygenbuilder.com/',
			'notice'  => array(
				'message' => ddw_tbex_pm_badge( 'required' ) .
					$for_oxygen .
					ddw_tbex_pmstring_info( __( 'Required base plugin for this Add-On to have any impact', 'toolbar-extras-oxygen' ) ),
				'class'   => $class,
			),
		),
		array(
			'name'    => _x( 'Oxygens Swiss Knife', 'Plugin Name', 'toolbar-extras-oxygen' ),
			'slug'    => 'Oxygens-Swiss-Knife',
			'version' => '0.2+',
			'url'     => 'https://github.com/krstivoja/Oxygens-Swiss-Knife',
			'notice'  => array(
				'message' => ddw_tbex_pm_badge( 'recommended' ) .
					$for_oxygen .
					ddw_tbex_pmstring_info( __( 'Highly recommended free extension by Marko Krstic that will help optimize WordPress and Oxygen builder', 'toolbar-extras-oxygen' ) ),
				'class'   => $class,
			),
		),
		array(
			'name'    => _x( 'Oxygen Theme Enabler', 'Plugin Name', 'toolbar-extras-oxygen' ),
			'slug'    => 'oxygenthemeenabler',
			'version' => '1.0.0+',
			'url'     => 'https://github.com/srikat/oxygenthemeenabler',
			'notice'  => array(
				'message' => ddw_tbex_pm_badge( 'recommended' ) .
					$for_oxygen .
					ddw_tbex_pmstring_info( __( 'Highly recommended free extension by Sridhar Katakam that makes it possible to still use the active WordPress theme when Oxygen Builder is active', 'toolbar-extras-oxygen' ) ),
				'class'   => $class,
			),
		),
	);  // end array

	/** Merge arrays and return */
	return array_merge( $plugins, $plugins_oxygen );

}  // end function
