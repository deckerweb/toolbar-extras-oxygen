<?php

// includes/oxygen-addons/items-my-custom-functionality

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexob_aoitems_my_custom_functionality', 100 );
/**
 * Items for Add-On: My Custom Functionality (free, by Sridhar Katakam)
 *
 * @since 1.1.0
 *
 * @uses ddw_tbex_string_free_addon_title_attr()
 * @uses ddw_tbex_resource_item()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexob_aoitems_my_custom_functionality( $admin_bar ) {

	/** Bail early if Theme Editor is disabled */
	if ( defined( 'DISALLOW_FILE_EDIT' ) && DISALLOW_FILE_EDIT ) {
		return;
	}

	$main_file = esc_url( admin_url( 'plugin-editor.php?plugin=my-custom-functionality-master%2Fplugin.php' ) );

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-oxytheme-enabler',
			'parent' => 'group-active-theme',
			'title'  => esc_attr__( 'My Custom Functionality', 'toolbar-extras-oxygen' ),
			'href'   => $main_file,
			'meta'   => array(
				'target' => ddw_tbex_meta_target(),
				'title'  => ddw_tbex_string_free_addon_title_attr( __( 'My Custom Functionality', 'toolbar-extras-oxygen' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-oxytheme-enabler-settings',
				'parent' => 'ao-oxytheme-enabler',
				'title'  => esc_attr__( 'Main Plugin File', 'toolbar-extras-oxygen' ),
				'href'   => $main_file,
				'meta'   => array(
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'Main Plugin File', 'toolbar-extras-oxygen' ),
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-obthemeenabler-resources',
					'parent' => 'ao-oxytheme-enabler',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'obthemeenabler-docs',
				'group-obthemeenabler-resources',
				'https://wpdevdesign.com/a-basic-wordpress-custom-functionality-plugin/'
			);

			ddw_tbex_resource_item(
				'github',
				'obthemeenabler-github',
				'group-obthemeenabler-resources',
				'https://github.com/srikat/my-custom-functionality'
			);

		}  // end if

}  // end function
