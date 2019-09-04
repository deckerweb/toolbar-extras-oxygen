<?php

// includes/oxygen-addons/items-oxygen-rcp-support

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexob_aoitems_oxygen_rcp_support', 100 );
/**
 * Items for Add-On: Oxygen RCP Support (free, by David Browne)
 *
 * @since 1.2.0
 *
 * @uses ddw_tbex_string_free_addon_title_attr()
 * @uses ddw_tbex_resource_item()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexob_aoitems_oxygen_rcp_support( $admin_bar ) {

	/** Bail early if Theme Editor is disabled */
	if ( defined( 'DISALLOW_FILE_EDIT' ) && DISALLOW_FILE_EDIT ) {
		return $admin_bar;
	}

	$suffix = '';
	$path   = 'Oxygen-RCP-Support';

	if ( file_exists( trailingslashit( WP_PLUGIN_DIR ) . 'Oxygen-RCP-Support-master' ) ) {

		$suffix = '-master';

	} elseif ( file_exists( trailingslashit( WP_PLUGIN_DIR ) . 'oxygen-rcp-support-master' ) ) {

		$suffix = '-master';
		$path   = 'oxygen-rcp-support';

	}  // end if

	$main_file = esc_url( admin_url( 'plugin-editor.php?plugin=' . $path . $suffix . '%2Fplugin.php' ) );

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-oxyrcpsupport',
			'parent' => 'group-active-theme',
			'title'  => esc_attr__( 'Oxygen RCP Support', 'toolbar-extras-oxygen' ),
			'href'   => $main_file,
			'meta'   => array(
				'target' => ddw_tbex_meta_target(),
				'title'  => ddw_tbex_string_free_addon_title_attr( __( 'Oxygen RCP Support - Template files', 'toolbar-extras-oxygen' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-oxyrcpsupport-file',
				'parent' => 'ao-oxyrcpsupport',
				'title'  => esc_attr__( 'Template Files', 'toolbar-extras-oxygen' ),
				'href'   => $main_file,
				'meta'   => array(
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'RCP Template Files', 'toolbar-extras-oxygen' ),
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-oxyrcpsupport-resources',
					'parent' => 'ao-oxyrcpsupport',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'oxyrcpsupport-docs',
				'group-oxyrcpsupport-resources',
				'https://github.com/wplit/Oxygen-RCP-Support/blob/master/README.md'
			);

			ddw_tbex_resource_item(
				'github',
				'oxyrcpsupport-github',
				'group-oxyrcpsupport-resources',
				'https://github.com/wplit/Oxygen-RCP-Support'
			);

		}  // end if

}  // end function
