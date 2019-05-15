<?php

// includes/oxygen-official/items-oxygen-core

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


//


/**
 * For the case that no theme access is wanted, disable loading of Theme support
 *   in Toolbar Extras via filter.
 *
 * @since 1.0.0
 */
if ( ddw_tbexob_display_settings_customizer() ) :
	add_filter( 'tbex_filter_display_items_themes', '__return_false' );
endif;


add_action( 'admin_bar_menu', 'ddw_tbexob_remove_item_active_theme', 100 );
/**
 * Remove the active theme group as Oxygen Builder by default disables the theme
 *   and does in no way need, use or leverage it.
 *
 *   Note: Via the filter 'tbexob/filter/oxygen/notheme' this behavior can be
 *         disabled by other plugins (like "Oxygen Theme Enabler") or via code
 *         snippets to have this group show up again.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_display_settings_customizer()
 * @uses ddw_tbexob_is_oxygen_theme_enabler_active()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 * @return object WP_Admin_Bar object.
 */
function ddw_tbexob_remove_item_active_theme( $admin_bar ) {

	if ( ddw_tbexob_display_settings_customizer() || ddw_tbexob_is_oxygen_theme_enabler_active() ) {
		return $admin_bar;
	}

	if ( (bool) apply_filters( 'tbexob/filter/oxygen/notheme', TRUE ) ) {
		$admin_bar->remove_node( 'group-active-theme' );
	}

}  // end function


add_action( 'admin_bar_menu', 'ddw_tbexob_maybe_remove_item_wpwidgets', 100 );
/**
 * Remove the Widgets Elements from the Site Group, plus sub-items from the
 *   frontend Customizer, since Oxygen has no active sidebars.
 *
 *   Note: Exception, if the "Oxygen Theme Enabler" plugin as this re-enables
 *         the theme and therefore in 99.99% of cases also widgets...!
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_is_oxygen_theme_enabler_active()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexob_maybe_remove_item_wpwidgets( $admin_bar ) {

	if ( ! ddw_tbexob_is_oxygen_theme_enabler_active() ) {

		$admin_bar->remove_node( 'wpwidgets' );
		$admin_bar->remove_node( 'customize-wpwidgets' );

		remove_action( 'admin_bar_menu', 'ddw_tbex_site_items_widgets' );

	}  // end if

}  // end function


//


add_action( 'admin_bar_menu', 'ddw_tbexob_items_oxygen_core', 99 );
/**
 * Add main items for "Oxygen Builder" plugin (Premium, by Soflyy).
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_default_pagebuilder()
 * @uses ddw_tbex_string_oxygen()
 * @uses ddw_tbexob_string_oxygen_templates()
 * @uses ddw_tbexob_string_oxygen_settings()
 * @uses ddw_tbex_is_btcplugin_active()
 * @uses ddw_btc_string_template()
 * @uses ddw_tbexob_is_oxygen_user_library_active()
 * @uses ddw_tbexob_is_oxygen_user_library_prepared()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexob_items_oxygen_core( $admin_bar ) {

	/** Bail early if Oxygen is not set as default page builder */
	if ( 'oxygen' !== ddw_tbex_get_default_pagebuilder() ) {
		return;
	}

	$type = 'ct_template';

	/** Oxygen templates */
	$admin_bar->add_node(
		array(
			'id'     => 'oxygen-template-library',
			'parent' => 'group-creative-content',
			'title'  => ddw_tbexob_string_oxygen_templates(),
			'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbexob_string_oxygen_templates(),
			)
		)
	);

		/** Templates */
		$admin_bar->add_node(
			array(
				'id'     => 'oxygen-template-library-all-templates',
				'parent' => 'oxygen-template-library',
				'title'  => esc_attr__( 'All Templates', 'toolbar-extras-oxygen' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'All Templates', 'toolbar-extras-oxygen' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'oxygen-template-library-new-template',
				'parent' => 'oxygen-template-library',
				'title'  => esc_attr__( 'New Template', 'toolbar-extras-oxygen' ),
				'href'   => esc_url( admin_url( 'post-new.php?post_type=' . $type ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'New Template', 'toolbar-extras-oxygen' ),
				)
			)
		);

		/** Template categories, via BTC plugin */
		if ( ddw_tbex_is_btcplugin_active() ) {

			$admin_bar->add_node(
				array(
					'id'     => 'oxygen-template-library-categories',
					'parent' => 'oxygen-template-library',
					'title'  => ddw_btc_string_template( 'template' ),
					'href'   => esc_url( admin_url( 'edit-tags.php?taxonomy=builder-template-category&post_type=' . $type ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_html( ddw_btc_string_template( 'template' ) )
					)
				)
			);

		}  // end if

		/** Reusable Parts */
		$admin_bar->add_node(
			array(
				'id'     => 'oxygen-template-library-all-reusable-parts',
				'parent' => 'oxygen-template-library',
				'title'  => esc_attr__( 'All Reusable Parts', 'toolbar-extras-oxygen' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&oxygen-template-type=reusable-parts' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'All Reusable Parts', 'toolbar-extras-oxygen' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'oxygen-template-library-new-reusable-part',
				'parent' => 'oxygen-template-library',
				'title'  => esc_attr__( 'New Reusable Part', 'toolbar-extras-oxygen' ),
				'href'   => esc_url( admin_url( 'post-new.php?post_type=' . $type . '&is_reusable=true' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'New Reusable Part', 'toolbar-extras-oxygen' ),
				)
			)
		);

	/** Action Hook: After Oxygen Templates */
	do_action( 'tbexob/oxygen_templates/after' );

	/** Oxygen User Library Elements (Blocks) */
	if ( ddw_tbexob_is_oxygen_user_library_active() ) {

		$type_library = 'oxy_user_library';

		$admin_bar->add_node(
			array(
				'id'     => 'oxygen-elements-library',
				'parent' => 'group-creative-content',
				'title'  => ddw_tbexob_string_oxygen_library(),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type_library ) ),
				'meta'   => array(
					'target' => '',
					'title'  => ddw_tbexob_string_oxygen_library(),
				)
			)
		);

			$admin_bar->add_node(
				array(
					'id'     => 'oxygen-elements-library-all',
					'parent' => 'oxygen-elements-library',
					'title'  => esc_attr__( 'All Library Blocks', 'toolbar-extras-oxygen' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type_library ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'All Library Blocks', 'toolbar-extras-oxygen' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'oxygen-elements-library-new',
					'parent' => 'oxygen-elements-library',
					'title'  => esc_attr__( 'New Library Block', 'toolbar-extras-oxygen' ),
					'href'   => esc_url( admin_url( 'post-new.php?post_type=' . $type_library ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'New Library Block', 'toolbar-extras-oxygen' ),
					)
				)
			);

			/** Elements Library categories, via BTC plugin */
			if ( ddw_tbex_is_btcplugin_active() ) {

				$admin_bar->add_node(
					array(
						'id'     => 'oxygen-elements-library-categories',
						'parent' => 'oxygen-elements-library',
						'title'  => ddw_btc_string_template( 'library' ),
						'href'   => esc_url( admin_url( 'edit-tags.php?taxonomy=builder-template-category&post_type=' . $type_library ) ),
						'meta'   => array(
							'target' => '',
							'title'  => esc_html( ddw_btc_string_template( 'library' ) )
						)
					)
				);

			}  // end if

	}  // end if

	/** Action Hook: After Oxygen User Library */
	do_action( 'tbexob/oxygen_library/after' );

	/** Oxygen Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'oxygen-builder-settings',
			'parent' => 'group-pagebuilder-options',
			'title'  => ddw_tbexob_string_oxygen_settings(),
			'href'   => esc_url( admin_url( 'admin.php?page=oxygen_vsb_settings' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbexob_string_oxygen_settings(),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'oxygen-builder-settings-general',
				'parent' => 'oxygen-builder-settings',
				'title'  => esc_attr__( 'General', 'toolbar-extras-oxygen' ),
				'href'   => esc_url( admin_url( 'admin.php?page=oxygen_vsb_settings&tab=general' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'General', 'toolbar-extras-oxygen' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'oxygen-builder-settings-role-manager',
				'parent' => 'oxygen-builder-settings',
				'title'  => esc_attr__( 'Role Manager', 'toolbar-extras-oxygen' ),
				'href'   => esc_url( admin_url( 'admin.php?page=oxygen_vsb_settings&tab=role_manager' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Role Manager', 'toolbar-extras-oxygen' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'oxygen-builder-settings-post-types',
				'parent' => 'oxygen-builder-settings',
				'title'  => esc_attr__( 'Post Type Manager', 'toolbar-extras-oxygen' ),
				'href'   => esc_url( admin_url( 'admin.php?page=oxygen_vsb_settings&tab=posttype_manager' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Post Type Manager', 'toolbar-extras-oxygen' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'oxygen-builder-settings-security',
				'parent' => 'oxygen-builder-settings',
				'title'  => esc_attr__( 'Security', 'toolbar-extras-oxygen' ),
				'href'   => esc_url( admin_url( 'admin.php?page=oxygen_vsb_settings&tab=security_manager' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Security', 'toolbar-extras-oxygen' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'oxygen-builder-settings-svg-sets',
				'parent' => 'oxygen-builder-settings',
				'title'  => esc_attr__( 'SVG Sets', 'toolbar-extras-oxygen' ),
				'href'   => esc_url( admin_url( 'admin.php?page=oxygen_vsb_settings&tab=svg_manager' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'SVG Sets', 'toolbar-extras-oxygen' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'oxygen-builder-settings-typekit',
				'parent' => 'oxygen-builder-settings',
				'title'  => esc_attr__( 'Typekit Fonts', 'toolbar-extras-oxygen' ),
				'href'   => esc_url( admin_url( 'admin.php?page=oxygen_vsb_settings&tab=typekit_manager' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Typekit Fonts', 'toolbar-extras-oxygen' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'oxygen-builder-settings-css-cache',
				'parent' => 'oxygen-builder-settings',
				'title'  => esc_attr__( 'CSS Cache', 'toolbar-extras-oxygen' ),
				'href'   => esc_url( admin_url( 'admin.php?page=oxygen_vsb_settings&tab=cache' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'CSS Cache', 'toolbar-extras-oxygen' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'oxygen-builder-settings-bloat-eliminator',
				'parent' => 'oxygen-builder-settings',
				'title'  => esc_attr__( 'Bloat Eliminator', 'toolbar-extras-oxygen' ),
				'href'   => esc_url( admin_url( 'admin.php?page=oxygen_vsb_settings&tab=bloat' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Bloat Eliminator', 'toolbar-extras-oxygen' ),
				)
			)
		);

		/** Optional User Library Elements */
		if ( ddw_tbexob_is_oxygen_user_library_prepared() ) {

			$admin_bar->add_node(
				array(
					'id'     => 'oxygen-builder-settings-library',
					'parent' => 'oxygen-builder-settings',
					'title'  => esc_attr__( 'Block Library', 'toolbar-extras-oxygen' ),
					'href'   => esc_url( admin_url( 'admin.php?page=oxygen_vsb_settings&tab=library_manager' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'User Library of Builder Elements &amp; Blocks', 'toolbar-extras-oxygen' ),
					)
				)
			);

		}  // end if

		$admin_bar->add_node(
			array(
				'id'     => 'oxygen-builder-settings-export-import',
				'parent' => 'oxygen-builder-settings',
				'title'  => esc_attr__( 'Export &amp; Import', 'toolbar-extras-oxygen' ),
				'href'   => esc_url( admin_url( 'admin.php?page=ct_export_import' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Export &amp; Import', 'toolbar-extras-oxygen' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'oxygen-builder-settings-license',
				'parent' => 'oxygen-builder-settings',
				'title'  => esc_attr__( 'License', 'toolbar-extras-oxygen' ),
				'href'   => esc_url( admin_url( 'admin.php?page=oxygen_vsb_settings&tab=license_manager' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'License', 'toolbar-extras-oxygen' ),
				)
			)
		);

}  // end function


add_action( 'admin_bar_menu', 'ddw_tbexob_items_oxygen_settings_customizer', 100 );
/**
 * Provide minimalistic Customizer access via the Toolbar to adjust "Site
 *   Identity", "Custom CSS", "WooCommerce" and other third-party plugin stuff
 *   there.
 *
 *   Note: Since the default Oxygen Builder environment does not need a theme,
 *         this implementation does completely work theme-independent as well.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_display_settings_customizer()
 * @uses ddw_tbexob_is_oxygen_theme_enabler_active()
 * @uses ddw_tbex_customizer_start()
 * @uses ddw_tbex_customizer_focus()
 * @uses ddw_tbex_string_customize_attr()
 * @uses ddw_tbex_meta_target()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexob_items_oxygen_settings_customizer( $admin_bar ) {

	/** Bail early if Settings Customizer not wanted */
	if ( ! ddw_tbexob_display_settings_customizer() || ddw_tbexob_is_oxygen_theme_enabler_active() ) {
		return $admin_bar;
	}

	$admin_bar->add_node(
		array(
			'id'     => 'theme-creative',
			'parent' => 'group-active-theme',
			'title'  => esc_attr__( 'Settings Customizer', 'toolbar-extras-oxygen' ),
			'href'   => ddw_tbex_customizer_start(),
			'meta'   => array(
				'target' => ddw_tbex_meta_target(),
				'title'  => esc_attr__( 'Settings Customizer', 'toolbar-extras-oxygen' ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'theme-creative-customize',
				'parent' => 'theme-creative',
				'title'  => esc_attr__( 'Settings &amp; Design', 'toolbar-extras-oxygen' ),
				'href'   => ddw_tbex_customizer_start(),
				'meta'   => array(
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'Settings &amp; Design', 'toolbar-extras-oxygen' )
				)
			)
		);

			$admin_bar->add_node(
				array(
					'id'     => 'oxygen-customizer-site-identity',
					'parent' => 'theme-creative-customize',
					/* translators: Autofocus section in the Customizer */
					'title'  => esc_attr__( 'Site Identity', 'toolbar-extras' ),
					'href'   => ddw_tbex_customizer_focus( 'section', 'title_tagline' ),
					'meta'   => array(
						'target' => ddw_tbex_meta_target(),
						'title'  => ddw_tbex_string_customize_attr( __( 'Site Identity', 'toolbar-extras' ) )
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'oxygen-customizer-custom-css',
					'parent' => 'theme-creative-customize',
					/* translators: Autofocus section in the Customizer */
					'title'  => esc_attr__( 'Custom CSS', 'toolbar-extras-oxygen' ),
					'href'   => ddw_tbex_customizer_focus( 'section', 'custom_css' ),
					'meta'   => array(
						'target' => ddw_tbex_meta_target(),
						'title'  => ddw_tbex_string_customize_attr( __( 'Custom CSS', 'toolbar-extras-oxygen' ) )
					)
				)
			);

}  // end function


add_action( 'admin_bar_menu', 'ddw_tbexob_user_items_oxygen_core_roles', 99 );
/**
 * Add User items for Oxygen Builder (Premium, Core).
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_display_items_users()
 * @uses ddw_tbex_item_title_with_icon()
 * @uses ddw_tbexob_string_oxygen()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexob_user_items_oxygen_core_roles( $admin_bar ) {

	/** Oxygen Role Manager */
	if ( ! ddw_tbex_display_items_users() ) {
		return;
	}

	$admin_bar->add_node(
		array(
			'id'     => 'oxygen-role-manager',
			'parent' => 'group-user-roles',
			/* translators: Oxygen "Role Manager" displayed in "my-account" Toolbar submenu - it's only a small area please use a short translation term! */
			'title'  => ddw_tbex_item_title_with_icon( esc_attr_x( 'Role Manager', 'Oxygen Role Manager', 'toolbar-extras-oxygen' ) ),
			'href'   => esc_url( admin_url( 'admin.php?page=oxygen_vsb_settings&tab=role_manager' ) ),
			'meta'   => array(
				'class'  => 'tbex-users',
				'target' => '',
				'title'  => ddw_tbexob_string_oxygen() . ': ' . esc_attr__( 'Role Manager', 'toolbar-extras-oxygen' ),
			)
		)
	);

}  // end function


add_filter( 'admin_bar_menu', 'ddw_tbexob_aoitems_new_content_oxygen_core_main', 80 );
/**
 * Items for "New Content" section: New Oxygen Template
 *   Note: Filter the existing Toolbar node to make a few tweaks with the
 *         existing item.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_display_items_new_content()
 * @uses ddw_tbexob_is_oxygen_user_library_active()
 *
 * @param object $wp_admin_bar Holds all nodes of the Toolbar.
 */
function ddw_tbexob_aoitems_new_content_oxygen_core_main( $admin_bar ) {

	/** Bail early if items display is not wanted */
	if ( ! ddw_tbex_display_items_new_content() ) {
		return $admin_bar;
	}

	/** Template element */
	$template_title_attr = sprintf(
		/* translators: %s - Word "Oxygen" */
		__( '%s Template', 'toolbar-extras-oxygen' ),
		ddw_tbexob_string_oxygen()
	);

	/** Reusable Part element */
	$reusable_title_attr = sprintf(
		/* translators: %s - Word "Oxygen" */
		__( '%s Reusable Part', 'toolbar-extras-oxygen' ),
		ddw_tbexob_string_oxygen()
	);

	$admin_bar->add_node(
		array(
			'id'     => 'new-ct_template',	// same as original!
			'parent' => 'new-content',
			'title'  => sprintf(
				/* translators: %s - Word "Oxygen" */
				esc_attr__( '%s Template', 'toolbar-extras-oxygen' ),
				ddw_tbexob_string_oxygen()
			),
			'meta'   => array(
				'title'  => ddw_tbex_string_add_new_item( $template_title_attr ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'tbexob-new-oxygen-template',
				'parent' => 'new-ct_template',
				'title'  => esc_attr__( 'Template', 'toolbar-extras-oxygen' ),
				'href'   => esc_url( admin_url( 'post-new.php?post_type=ct_template' ) ),
				'meta'   => array(
					'title'  => ddw_tbex_string_add_new_item( $template_title_attr ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'tbexob-new-oxygen-reusable-part',
				'parent' => 'new-ct_template',
				'title'  => esc_attr__( 'Reusable Part', 'toolbar-extras-oxygen' ),
				'href'   => esc_url( admin_url( 'post-new.php?post_type=ct_template&is_reusable=true' ) ),
				'meta'   => array(
					'title'  => ddw_tbex_string_add_new_item( $reusable_title_attr ),
				)
			)
		);

	/** Optional User Library element */
	if ( ddw_tbexob_is_oxygen_user_library_active() ) {

		$library_title_attr = sprintf(
			/* translators: %s - Word "Oxygen" */
			__( '%s User Library Block/ Element', 'toolbar-extras-oxygen' ),
			ddw_tbexob_string_oxygen()
		);

		$admin_bar->add_node(
			array(
				'id'     => 'new-oxy_user_library',	// same as original!
				'parent' => 'new-content',
				'title'  => sprintf(
					/* translators: %s - Word "Oxygen" */
					esc_attr__( '%s Library Block', 'toolbar-extras-oxygen' ),
					ddw_tbexob_string_oxygen()
				),
				'meta'   => array(
					'title'  => ddw_tbex_string_add_new_item( $library_title_attr ),
				)
			)
		);

	}  // end if

}  // end function


add_action( 'admin_bar_menu', 'ddw_tbexob_items_oxygen_core_resources', 99 );
/**
 * Add Oxygen Builder external resources items
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_display_items_resources()
 * @uses ddw_tbex_get_default_pagebuilder()
 * @uses ddw_tbex_resource_item()
 * @uses ddw_tbex_get_resource_url()
 *
 * @param object $wp_admin_bar Holds all nodes of the Toolbar.
 */
function ddw_tbexob_items_oxygen_core_resources( $admin_bar ) {

	/**
	 * Bail early if resources display is disabled or Oxygen is not the
	 *   default Page Builder.
	 */
	if ( ! ddw_tbex_display_items_resources()
		|| 'oxygen' !== ddw_tbex_get_default_pagebuilder()
	) {
		return;
	}

	$admin_bar->add_node(
		array(
			'id'     => 'oxygen-resources',
			'parent' => 'group-pagebuilder-resources',
			'title'  => ddw_tbexob_string_oxygen_resources(),
			'href'   => ddw_tbex_get_resource_url( 'oxygen', 'url_docs' ),
			'meta'   => array(
				'rel'    => ddw_tbex_meta_rel(),
				'target' => ddw_tbex_meta_target(),
				'title'  => ddw_tbexob_string_oxygen_resources(),
			)
		)
	);

		ddw_tbex_resource_item(
			'documentation',
			'oxygen-resources-docs',
			'oxygen-resources',
			ddw_tbex_get_resource_url( 'oxygen', 'url_docs' )
		);

		ddw_tbex_resource_item(
			'tutorials',
			'oxygen-resources-tutorials',
			'oxygen-resources',
			ddw_tbex_get_resource_url( 'oxygen', 'url_tutorials' ),
			sprintf(
				/* translators: %s - Word "Oxygen" */
				esc_attr__( 'Getting Started - Learn %s Tutorials', 'toolbar-extras-oxygen' ),
				ddw_tbexob_string_oxygen()
			)
		);

		ddw_tbex_resource_item(
			'support-contact',
			'oxygen-resources-support-contact',
			'oxygen-resources',
			ddw_tbex_get_resource_url( 'oxygen', 'url_support_contact' )
		);

		ddw_tbex_resource_item(
			'official-blog',
			'oxygen-resources-blog',
			'oxygen-resources',
			ddw_tbex_get_resource_url( 'oxygen', 'url_blog' )
		);

		ddw_tbex_resource_item(
			'youtube-channel',
			'oxygen-resources-youtube',
			'oxygen-resources',
			ddw_tbex_get_resource_url( 'oxygen', 'url_videos' )
		);

		$admin_bar->add_node(
			array(
				'id'     => 'oxygen-resources-bugs-features',
				'parent' => 'oxygen-resources',
				'title'  => esc_attr__( 'Bug Reports &amp; Feature Requests', 'toolbar-extras-oxygen' ),
				'href'   => ddw_tbex_get_resource_url( 'oxygen', 'url_github_issues' ),
				'meta'   => array(
					'rel'    => ddw_tbex_meta_rel(),
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'Bug Reports &amp; Feature Requests via GitHub Issues', 'toolbar-extras-oxygen' ),
				)
			)
		);

		ddw_tbex_resource_item(
			'my-account',
			'oxygen-resources-account-portal',
			'oxygen-resources',
			ddw_tbex_get_resource_url( 'oxygen', 'url_myaccount' )
		);

	/** Action Hook: After Oxygen Resources */
	do_action( 'tbexob/oxygen_resources/after' );

	$admin_bar->add_node(
		array(
			'id'     => 'oxygen-community',
			'parent' => 'group-pagebuilder-resources',
			'title'  => ddw_tbexob_string_oxygen_community(),
			'href'   => ddw_tbex_get_resource_url( 'oxygen', 'url_fb_group' ),
			'meta'   => array(
				'rel'    => ddw_tbex_meta_rel(),
				'target' => ddw_tbex_meta_target(),
				'title'  => ddw_tbexob_string_oxygen_community(),
			)
		)
	);

		ddw_tbex_resource_item(
			'facebook-group',
			'oxygen-community-fbgroup',
			'oxygen-community',
			ddw_tbex_get_resource_url( 'oxygen', 'url_fb_group' )
		);

		ddw_tbex_resource_item(
			'slack-channel',
			'oxygen-community-slack-chat',
			'oxygen-community',
			ddw_tbex_get_resource_url( 'oxygen', 'url_slack_chat' ),
			esc_attr__( 'Slack Chat - Official Community Channel', 'toolbar-extras-oxygen' )
		);

		$admin_bar->add_node(
			array(
				'id'     => 'oxygen-community-trello-board',
				'parent' => 'oxygen-community',
				'title'  => esc_attr__( 'Community Resources - Trello Board', 'toolbar-extras-oxygen' ),
				'href'   => ddw_tbex_get_resource_url( 'oxygen', 'url_trello_resources' ),
				'meta'   => array(
					'rel'    => ddw_tbex_meta_rel(),
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'Collected Community Resources - Trello Board', 'toolbar-extras-oxygen' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'oxygen-community-blog-wpdevdesign',
				'parent' => 'oxygen-community',
				'title'  => 'WPDevDesign: ' . esc_attr__( 'Tutorials on Oxygen &amp; WP', 'toolbar-extras-oxygen' ),
				'href'   => ddw_tbex_get_resource_url( 'oxygen', 'url_blog_wpdd' ),
				'meta'   => array(
					'rel'    => ddw_tbex_meta_rel(),
					'target' => ddw_tbex_meta_target(),
					'title'  => 'WPDevDesign: ' . esc_attr__( 'Tutorials on Oxygen and WordPress - Community Blog', 'toolbar-extras-oxygen' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'oxygen-community-blog-supa',
				'parent' => 'oxygen-community',
				'title'  => 'Oxygen4Fun: ' . esc_attr__( 'Tutorials &amp; Tips', 'toolbar-extras-oxygen' ),
				'href'   => ddw_tbex_get_resource_url( 'oxygen', 'url_blog_supa' ),
				'meta'   => array(
					'rel'    => ddw_tbex_meta_rel(),
					'target' => ddw_tbex_meta_target(),
					'title'  => 'Oxygen4Fun: ' . esc_attr__( 'Tutorials &amp; Tips - Community Blog', 'toolbar-extras-oxygen' ),
				)
			)
		);

}  // end function


add_action( 'admin_bar_menu', 'ddw_tbexob_design_items_oxygen_sites_library', 100 );
/**
 * Oxygen items for adding new websites/ design sets:
 *   - Item for Installing Oxygen Websites/ Design Sets (aka "Demo Imports"...)
 *   - Optional: Item for adding third-party Design Sets in Oxygen
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_display_items_demo_import()
 * @uses ddw_tbex_id_sites_browser()
 * @uses ddw_tbex_item_title_with_settings_icon()
 * @uses ddw_tbex_meta_target()
 * @uses ddw_tbexob_is_oxygen_design_set_import()
 *
 * @param object $wp_admin_bar Holds all nodes of the Toolbar.
 */
function ddw_tbexob_design_items_oxygen_sites_library( $admin_bar ) {

	/** Bail early if no display of Demo Import items */
	if ( ! ddw_tbex_display_items_demo_import() ) {
		return;
	}

	$browse_library = add_query_arg(
		'page',
		'ct_install_wiz',
		get_admin_url()
	);

	/** Oxygen Sites Library */
	$admin_bar->add_node(
		array(
			'id'     => ddw_tbex_id_sites_browser(),
			'parent' => 'group-demo-import',
			'title'  => ddw_tbex_item_title_with_settings_icon(
				esc_attr__( 'Install Website', 'toolbar-extras-oxygen' ),
				'general',
				'demo_import_icon'
			),
			'href'   => esc_url( $browse_library ),
			'meta'   => array(
				'target' => ddw_tbex_meta_target(),
				'title'  => sprintf(
					/* translators: %s - Word "Oxygen" */
					esc_attr__( '%s Design Library - Install a Different Website', 'toolbar-extras-oxygen' ),
					ddw_tbexob_string_oxygen()
				),
			)
		)
	);

	/** Optional: Add third-party Design Sets */
	if ( ddw_tbexob_is_oxygen_design_set_import() ) {

		$admin_bar->add_node(
			array(
				'id'     => 'oxygen-design-set-import-thirdparty',
				'parent' => 'group-demo-import',
				'title'  => ddw_tbex_item_title_with_icon( esc_attr__( 'Add Design Sets', 'toolbar-extras-oxygen' ) ),
				'href'   => esc_url( admin_url( 'admin.php?page=add_3rdp_designset' ) ),
				'meta'   => array(
					'class'  => 'tbex-add-design-set',
					'target' => '',
					'title'  => esc_attr__( 'Oxygen: Add Third-Party Design Set (Import)', 'toolbar-extras-oxygen' ),
				)
			)
		);

	}  // end if

}  // end function
