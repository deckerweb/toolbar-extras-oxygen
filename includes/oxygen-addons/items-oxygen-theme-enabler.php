<?php

// includes/oxygen-addons/items-oxygen-theme-enabler

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexob_aoitems_oxygen_theme_enabler', 100 );
/**
 * Items for Add-On: Oxygen Theme Enabler (free, by Sridhar Katakam)
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_free_addon_title_attr()
 * @uses ddw_tbex_resource_item()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexob_aoitems_oxygen_theme_enabler( $admin_bar ) {

	/** Use Add-On hook place */
	add_filter( 'tbex_filter_is_addon', '__return_empty_string' );

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-oxytheme-enabler',
			'parent' => 'tbex-addons',
			'title'  => esc_attr__( 'Theme Enabler', 'toolbar-extras-oxygen' ),
			'href'   => esc_url( admin_url( 'admin.php?page=oxygen-theme-enabler' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_free_addon_title_attr( __( 'Theme Enabler', 'toolbar-extras-oxygen' ) )
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-oxytheme-enabler-settings',
				'parent' => 'ao-oxytheme-enabler',
				'title'  => esc_attr__( 'Settings', 'toolbar-extras-oxygen' ),
				'href'   => esc_url( admin_url( 'admin.php?page=oxygen-theme-enabler' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Settings', 'toolbar-extras-oxygen' )
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-obthemeenabler-resources',
					'parent' => 'ao-oxytheme-enabler',
					'meta'   => array( 'class' => 'ab-sub-secondary' )
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'obthemeenabler-docs',
				'group-obthemeenabler-resources',
				'https://wpdevdesign.com/oxygen-theme-enabler-plugin/'
			);

			ddw_tbex_resource_item(
				'github',
				'obthemeenabler-github',
				'group-obthemeenabler-resources',
				'https://github.com/srikat/oxygenthemeenabler'
			);

		}  // end if

}  // end function


add_action( 'admin_bar_menu', 'ddw_tbexob_maybe_reactivate_active_theme_group' );
/**
 * When "Oxygen Theme Enabler" option is set to 'use-theme-mostly', re-enable
 *   the active theme group.
 *
 * @since 1.0.0
 *
 * @see plugin file: /includes/oxygen-official/items-oxygen-core.php
 */
function ddw_tbexob_maybe_reactivate_active_theme_group() {

	$theme_enabler = get_option( 'oxygen_theme_enabler_option_name' );

	if ( 'use-theme-mostly' === $theme_enabler[ 'select_how_you_want_to_enable_the_theme_0' ] ) {
		add_filter( 'tbexob/filter/oxygen/notheme', '__return_false' );
	}

}  // end function
