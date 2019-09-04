<?php

// includes/oxygen-addons/items-oxygen-edd-support

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexob_aoitems_oxygen_edd_support', 100 );
/**
 * Items for Add-On: Oxygen EDD Support (free, by David Browne)
 *
 * @since 1.2.0
 *
 * @uses ddw_tbex_string_free_addon_title_attr()
 * @uses ddw_tbex_resource_item()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexob_aoitems_oxygen_edd_support( $admin_bar ) {

	/** Bail early if Theme Editor is disabled */
	if ( defined( 'DISALLOW_FILE_EDIT' ) && DISALLOW_FILE_EDIT ) {
		return $admin_bar;
	}

	$suffix = '';
	$path   = 'Oxygen-EDD-Support';

	if ( file_exists( trailingslashit( WP_PLUGIN_DIR ) . 'Oxygen-EDD-Support-master' ) ) {

		$suffix = '-master';

	} elseif ( file_exists( trailingslashit( WP_PLUGIN_DIR ) . 'oxygen-edd-support-master' ) ) {

		$suffix = '-master';
		$path   = 'oxygen-edd-support';

	}  // end if

	$main_file = esc_url( admin_url( 'plugin-editor.php?plugin=' . $path . $suffix . '%2Fplugin.php' ) );

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-oxyeddsupport',
			'parent' => 'group-active-theme',
			'title'  => esc_attr__( 'Oxygen EDD Support', 'toolbar-extras-oxygen' ),
			'href'   => $main_file,
			'meta'   => array(
				'target' => ddw_tbex_meta_target(),
				'title'  => ddw_tbex_string_free_addon_title_attr( __( 'Oxygen EDD Support - Template files', 'toolbar-extras-oxygen' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-oxyeddsupport-file',
				'parent' => 'ao-oxyeddsupport',
				'title'  => esc_attr__( 'Template Files', 'toolbar-extras-oxygen' ),
				'href'   => $main_file,
				'meta'   => array(
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'EDD Template Files', 'toolbar-extras-oxygen' ),
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-oxyeddsupport-resources',
					'parent' => 'ao-oxyeddsupport',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'oxyeddsupport-docs',
				'group-oxyeddsupport-resources',
				'https://github.com/wplit/Oxygen-EDD-Support/blob/master/README.md'
			);

			ddw_tbex_resource_item(
				'github',
				'oxyeddsupport-github',
				'group-oxyeddsupport-resources',
				'https://github.com/wplit/Oxygen-EDD-Support'
			);

		}  // end if

}  // end function
