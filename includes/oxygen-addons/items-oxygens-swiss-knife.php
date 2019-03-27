<?php

// includes/oxygen-addons/items-oxygens-swiss-knife

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexob_aoitems_oxygens_swiss_knife', 100 );
/**
 * Items for Add-On: Oxygens Swiss Knife (free, by Marko Krstic)
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_free_addon_title_attr()
 * @uses ddw_tbex_resource_item()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexob_aoitems_oxygens_swiss_knife( $admin_bar ) {

	/** Use Add-On hook place */
	add_filter( 'tbex_filter_is_addon', '__return_empty_string' );

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-oxy-swisskife',
			'parent' => 'tbex-addons',
			'title'  => esc_attr__( 'Swiss Knife', 'toolbar-extras-oxygen' ),
			'href'   => esc_url( admin_url( 'options-general.php?page=swiss-knife' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_free_addon_title_attr( __( 'Swiss Knife', 'toolbar-extras-oxygen' ) )
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-oxy-swisskife-settings',
				'parent' => 'ao-oxy-swisskife',
				'title'  => esc_attr__( 'Settings', 'toolbar-extras-oxygen' ),
				'href'   => esc_url( admin_url( 'options-general.php?page=swiss-knife' ) ),
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
					'id'     => 'group-obswissknife-resources',
					'parent' => 'ao-oxy-swisskife',
					'meta'   => array( 'class' => 'ab-sub-secondary' )
				)
			);

			ddw_tbex_resource_item(
				'github',
				'obswissknife-github',
				'group-obswissknife-resources',
				'https://github.com/krstivoja/Oxygens-Swiss-Knife'
			);

		}  // end if

}  // end function
