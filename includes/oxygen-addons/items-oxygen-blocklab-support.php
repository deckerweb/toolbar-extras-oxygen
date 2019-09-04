<?php

// includes/oxygen-addons/items-oxygen-blocklab-support

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexob_aoitems_oxygen_blocklab_support', 100 );
/**
 * Items for Add-On: Oxygen Block Lab Support (free, by David Browne)
 *
 * @since 1.2.0
 *
 * @uses ddw_tbex_string_free_addon_title_attr()
 * @uses ddw_tbex_resource_item()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexob_aoitems_oxygen_blocklab_support( $admin_bar ) {

	/** Bail early if Theme Editor is disabled */
	if ( defined( 'DISALLOW_FILE_EDIT' ) && DISALLOW_FILE_EDIT ) {
		return $admin_bar;
	}

	$suffix = '';

	if ( file_exists( trailingslashit( WP_PLUGIN_DIR ) . 'oxygen-block-lab-support-master' ) ) {
		$suffix = '-master';
	}

	$main_file = esc_url( admin_url( 'plugin-editor.php?plugin=oxygen-block-lab-support' . $suffix . '%2Fplugin.php' ) );

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-oxyblocklabsupport',
			'parent' => 'group-active-theme',
			'title'  => esc_attr__( 'Oxygen Block Lab Support', 'toolbar-extras-oxygen' ),
			'href'   => $main_file,
			'meta'   => array(
				'target' => ddw_tbex_meta_target(),
				'title'  => ddw_tbex_string_free_addon_title_attr( __( 'Oxygen Block Lab Support - Template files', 'toolbar-extras-oxygen' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-oxyblocklabsupport-file',
				'parent' => 'ao-oxyblocklabsupport',
				'title'  => esc_attr__( 'Template Files', 'toolbar-extras-oxygen' ),
				'href'   => $main_file,
				'meta'   => array(
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'Block Lab Template Files', 'toolbar-extras-oxygen' ),
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-oxyblocklabsupport-resources',
					'parent' => 'ao-oxyblocklabsupport',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'oxyblocklabsupport-docs',
				'group-oxyblocklabsupport-resources',
				'https://github.com/wplit/oxygen-block-lab-support/blob/master/README.md'
			);

			ddw_tbex_resource_item(
				'github',
				'oxyblocklabsupport-github',
				'group-oxyblocklabsupport-resources',
				'https://github.com/wplit/oxygen-block-lab-support'
			);

		}  // end if

}  // end function
