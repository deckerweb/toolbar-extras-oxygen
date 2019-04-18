<?php

// includes/tweaks

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'register_post_type_args', 'ddw_tbexob_post_type_args_oxygen', 10, 2 );
/**
 * Tweak labels of Oxygen post types.
 *
 * @since 1.0.0
 *
 * @param array  $args Array of post type arguments.
 * @param string $post_type ID of the post type.
 * @return array Array of modified post type arguments.
 */
function ddw_tbexob_post_type_args_oxygen( $args, $post_type ) {

	/** Filter allows for custom disabling */
	if ( apply_filters( 'tbexob/filter/oxygen/tweak/post_type_args', FALSE ) ) {
		return $args;
	}

	/** Oxygen Templates */
	if ( 'ct_template' === $post_type ) {

		$args[ 'labels' ] = array(
			'view_items'    => __( 'View Templates', 'toolbar-extras-oxygen' ),
		);

	}  // end if

	/** Oxygen User Elements Library */
	if ( 'oxy_user_library' === $post_type ) {

		$args[ 'labels' ] = array(
			'name'               => _x( 'Elements', 'Post type general name', 'toolbar-extras-oxygen' ),
			'singular_name'      => _x( 'Element', 'Post type singular name', 'toolbar-extras-oxygen' ),
			'menu_name'          => _x( 'Oxy User Library', 'Admin menu name', 'toolbar-extras-oxygen' ),
			'all_items'          => __( 'All Elements', 'toolbar-extras-oxygen' ),
			'add_new'            => __( 'Add New', 'toolbar-extras-oxygen' ),
			'add_new_item'       => __( 'Add New Element', 'toolbar-extras-oxygen' ),
			'edit_item'          => __( 'Edit Element', 'toolbar-extras-oxygen' ),
			'view_item'          => __( 'View Element', 'toolbar-extras-oxygen' ),
			'new_item'           => __( 'New Element', 'toolbar-extras-oxygen' ),
			'search_items'       => __( 'Search Elements', 'toolbar-extras-oxygen' ),
			'parent_item_colon'  => __( 'Parent Elements:', 'toolbar-extras-oxygen' ),
			'not_found'          => __( 'No Elements found.', 'toolbar-extras-oxygen' ),
			'not_found_in_trash' => __( 'No Elements found in Trash.', 'toolbar-extras-oxygen' ),
			'name_admin_bar'     => __( 'Element', 'toolbar-extras-oxygen' ),
		);

	}  // end if

	/** Return tweaked post type arguments */
	return $args;
	
}  // end function


add_filter( 'parse_query', 'ddw_tbexob_oxygen_list_reusable_parts' );
/**
 * Create the necessary query adjustments for the "Reusable Parts" view for
 *   Oxygen Templates.
 *
 * @since 1.0.0
 *
 * @see ddw_tbexob_views_oxygen_reusable_parts()
 *
 * @param object $query
 */
function ddw_tbexob_oxygen_list_reusable_parts( $query ) {

	if ( is_admin() && 'ct_template' === $query->query[ 'post_type' ] ) {

		if ( isset( $_GET[ 'oxygen-template-type' ] ) && 'reusable-parts' === sanitize_key( wp_unslash( $_GET[ 'oxygen-template-type' ] ) )	) {

			$query_var = &$query->query_vars;

			$query_var[ 'meta_query' ] = array(
				array(
					'key'     => 'ct_template_type',
					'compare' => 'EXISTS',
					'value'   => 'reusable_part',
				)
			);

		}  // end if

	}  // end if

}  // end function


add_filter( 'views_edit-ct_template', 'ddw_tbexob_views_oxygen_reusable_parts', 15 );
/**
 * Add additional view for "Reusable Parts" template type for the Oxygen
 *   Templates post type list table.
 *
 *   Note: This is a necessaray in-between step so we can link to this view
 *         independently from the Toolbar.
 *
 * @since 1.0.0
 *
 * @param array $views Array which holds all views.
 * @return array Modified array of views.
 */
function ddw_tbexob_views_oxygen_reusable_parts( $views ) {

	/** Set custom query arguments */
	$args = array(
		'post_type'  => 'ct_template',
		'meta_query' => array(
			array(
				'key'     => 'ct_template_type',
				'compare' => 'EXISTS',
				'value'   => 'reusable_part'
			),
		)
	);

	/** Do the query and reset */
	$result_reusable = new WP_Query( $args );
	wp_reset_postdata();

	/** Conditions for the necessary "current" class */
	$class_reusable = ( isset( $_GET[ 'oxygen-template-type' ] ) && 'reusable-parts' === sanitize_key( wp_unslash( $_GET[ 'oxygen-template-type' ] ) ) ) ? ' class="current"' : '';

	/** URL query arguments */
	$admin_url_reusable = add_query_arg(
		'oxygen-template-type',
		'reusable-parts',
		admin_url( 'edit.php?post_type=ct_template' )
	);

	/** Finally build the additional view */
	$views[ 'tbexob-reusable-parts' ] = sprintf(
		'<a href="%1$s"%2$s>%3$s <span class="count">(%4$d)</span></a>',
		esc_url( $admin_url_reusable ),
		$class_reusable,
		__( 'Reusable Parts', 'toolbar-extras-oxygen' ),
		$result_reusable->found_posts
	);

	/** Return the modified $views array */
	return $views;

}  // end function


add_filter( 'post_row_actions', 'ddw_tbexob_add_row_action_oxygen_types', 100, 2 );
/**
 * For Oxygen's own template post types adds an additional row action for
 *   "Edit with Oxygen".
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_display_row_actions()
 * @uses ddw_tbexob_string_edit_with_oxygen()
 * @uses ddw_tbex_meta_target()
 * @uses ddw_tbex_meta_rel()
 *
 * @param array  $actions Array holding all row actions.
 * @param object $post    Object of the current post type item.
 * @return array Modified array of row actions.
 */
function ddw_tbexob_add_row_action_oxygen_types( $actions, $post ) {

	/** Bail early if now Row Actions wanted */
	if ( ! ddw_tbexob_display_row_actions() ) {
		return $actions;
	}

	/** Set post types */
	$post_types = array( 'ct_template', 'oxy_user_library' );

	/** Check for Oxygen Shortcodes */
	$shortcodes = get_post_meta( $post->ID, 'ct_builder_shortcodes', TRUE );

	if ( $shortcodes ) {
		$contains_inner_content = ( strpos( $shortcodes, '[ct_inner_content' ) !== FALSE );
	}

	/** Set query arg params */
	$query_params = array(
		'ct_builder' => 'true',
	);

	if ( $contains_inner_content ) {

		$query_params = array(
			'ct_builder' => 'true',
			'ct_inner'   => 'true',
		);

	}  // end if

	/** Build the proper URL with the correct query params */
	if ( in_array( $post->post_type, $post_types ) ) {

		$edit_url = add_query_arg(
			$query_params,
			get_permalink( $post->ID )
		);

		$actions[ 'edit_with_oxygen' ] = sprintf(
			'<a href="%1$s" target="%3$s" %4$s>%2$s</a>',
			esc_url( $edit_url ),
			ddw_tbexob_string_edit_with_oxygen(),
			ddw_tbex_meta_target( 'builder' ),
			ddw_tbex_meta_rel()
		);

	}  // end if

	/** Finally, return the modified actions for row */
	return $actions;

}  // end function


add_filter( 'post_row_actions', 'ddw_tbexob_add_row_action_post_types', 100, 2 );
add_filter( 'page_row_actions', 'ddw_tbexob_add_row_action_post_types', 100, 2 );
/**
 * For any post type not unlisted in Oxygen's settings an additional row action
 *   for "Edit with Oxygen" gets added as long as this post type item got added
 *   at least one element in the Oxygen Builder.
 *
 * Note: This is done for all hierachical (i.e. Pages) and non-hierachical
 *       (i.e. Posts) post types.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_display_row_actions()
 * @uses ddw_tbexob_is_builder()
 * @uses ddw_tbexob_string_edit_with_oxygen()
 * @uses ddw_tbex_meta_target()
 * @uses ddw_tbex_meta_rel()
 *
 * @global array $ct_ignore_post_types
 *
 * @param array  $actions Array holding all row actions.
 * @param object $post    Object of the current post type item.
 * @return array Modified array of row actions.
 */
function ddw_tbexob_add_row_action_post_types( $actions, $post ) {

	/** Bail early if now Row Actions wanted */
	if ( ! ddw_tbexob_display_row_actions() ) {
		return $actions;
	}

	/** Get Oxygen's list of ignored post types */
	global $ct_ignore_post_types;

	/** Get all registered post types */
	$post_types = get_post_types();

	/** Check post type list against list of ignored types */
	if ( is_array( $ct_ignore_post_types ) && is_array( $post_types ) ) {
		$post_types = array_diff( $post_types, $ct_ignore_post_types );
	}

	/** Conditionally add row action where wanted */
	if ( in_array( $post->post_type, $post_types )
		&& 'ct_template' !== $post->post_type
		&& 'oxy_user_library' !== $post->post_type
	) {

		/** Only add row action if we have a Oxygen-enabled item */
		if ( ddw_tbexob_is_builder( $post->ID ) ) {

			/** Check for Oxygen Shortcodes */
			$shortcodes = get_post_meta( $post->ID, 'ct_builder_shortcodes', TRUE );

			if ( $shortcodes ) {
				$contains_inner_content = ( strpos( $shortcodes, '[ct_inner_content' ) !== FALSE );
			}

			/** Set query arg params */
			$query_params = array(
				'ct_builder' => 'true',
			);

			if ( $contains_inner_content ) {

				$query_params = array(
					'ct_builder' => 'true',
					'ct_inner'   => 'true',
				);
				
			}  // end if
	
			$edit_url = add_query_arg(
				$query_params,
				get_permalink( $post->ID )
			);

			$actions[ 'edit_with_oxygen' ] = sprintf(
				'<a href="%1$s" target="%3$s" %4$s>%2$s</a>',
				esc_url( $edit_url ),
				ddw_tbexob_string_edit_with_oxygen(),
				ddw_tbex_meta_target( 'builder' ),
				ddw_tbex_meta_rel()
			);

		}  // end if

	}  // end if

	return $actions;

}  // end function


add_filter( 'display_post_states', 'ddw_tbexob_add_post_state_oxygen', 10, 2 );
/**
 * Adds a new post state "Oxygen" to all post type items that were already edited with Oxygen (= contain at least one Element).
 *
 *   Note: This is NOT for special Oxygen Template post types, and also not for
 *         post types that were explicitely ignored via Oxygen settings.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_display_post_state()
 * @uses ddw_tbexob_is_builder()
 * @uses ddw_tbex_get_option()
 *
 * @param array  $post_states Array holding all post states.
 * @param object $post        Object of the current post type item.
 * @return array Modified array of post states.
 */
function ddw_tbexob_add_post_state_oxygen( $post_states, $post ) {

	/** Bail early if now Post State wanted */
	if ( ! ddw_tbexob_display_post_state() ) {
		return $post_states;
	}

	/** Get Oxygen's list of ignored post types */
	global $ct_ignore_post_types;

	/** Get all registered post types */
	$post_types = get_post_types();

	/** Check post type list against list of ignored types */
	if ( is_array( $ct_ignore_post_types ) && is_array( $post_types ) ) {
		$post_types = array_diff( $post_types, $ct_ignore_post_types );
	}

	/** Conditionally add row action where wanted */
	if ( in_array( $post->post_type, $post_types )
		&& 'ct_template' !== $post->post_type
		&& 'oxy_user_library' !== $post->post_type
	) {

		/** Only add row action if we have a Oxygen-enabled item */
		if ( ddw_tbexob_is_builder( $post->ID ) ) {

			$post_states[ 'edited_with_oxygen' ] = sprintf(
				'<span style="color: %2$s;">%1$s</span>',
				__( 'Oxygen', 'Label for Post State', 'toolbar-extras-oxygen' ),
				sanitize_hex_color( ddw_tbex_get_option( 'oxygen', 'oxygen_post_state_color' ) )
			);

		}  // end if

	}  // end if

	return $post_states;

}  // end function


add_action( 'admin_menu', 'ddw_tbexob_maybe_remove_appearance_submenus', 1000 );
/**
 * If both supported Meta Box Add-Ons are active at the same time, we need to
 *   remove one of the (identical) submenus in the admin again. Otherwise it
 *   would be highly confusing for users.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_is_oxygen_theme_enabler_active()
 * @uses ddw_tbexob_use_tweak_remove_submenu_themes()
 * @uses ddw_tbexob_use_tweak_remove_submenu_customizer()
 * @uses ddw_tbexob_use_tweak_remove_theme_editor()
 */
function ddw_tbexob_maybe_remove_appearance_submenus() {

	/** Bail early if "Oxygen Theme Enabler" plugin may be active */
	if ( ddw_tbexob_is_oxygen_theme_enabler_active() ) {
		return;
	}

	/** Themes page */
	if ( ddw_tbexob_use_tweak_remove_submenu_themes() ) {

		remove_submenu_page(
			'themes.php',
			'themes.php'
		);

		remove_submenu_page(
			'themes.php',
			network_admin_url( 'theme-install.php?tab=tbex-upload' )
		);

	}  // end if

	/**
	 * Customizer
	 * @link https://stackoverflow.com/questions/25788511/remove-submenu-page-customize-php-in-wordpress-4-0
	 */
	if ( ddw_tbexob_use_tweak_remove_submenu_customizer() ) {

		$customize_url_arr   = array();
		$customize_url_arr[] = 'customize.php'; // 3.x
		$customize_url       = add_query_arg( 'return', urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ), 'customize.php' );
		$customize_url_arr[] = $customize_url; // 4.0 & 4.1

		if ( current_theme_supports( 'custom-header' ) && current_user_can( 'customize') ) {
			$customize_url_arr[] = add_query_arg( 'autofocus[control]', 'header_image', $customize_url ); // 4.1
			$customize_url_arr[] = 'custom-header'; // 4.0
		}

		if ( current_theme_supports( 'custom-background' ) && current_user_can( 'customize') ) {
			$customize_url_arr[] = add_query_arg( 'autofocus[control]', 'background_image', $customize_url ); // 4.1
			$customize_url_arr[] = 'custom-background'; // 4.0
		}

		foreach ( $customize_url_arr as $customize_url ) {
			remove_submenu_page( 'themes.php', $customize_url );
		}

	}  // end if

	/**
	 * Theme Editor
	 *
	 * Note: We only remove the submenu page here, not the "Editor" itself as
	 *       that would also disable the Plugin Editor. We won't do that, as
	 *       this should be a user decision. Some Oxygen community Add-Ons have
	 *       plugins with "Custom Function Files" that could be edited in the
	 *       Plugin Editor. (Users could set 'DISALLOW_FILE_EDIT' themselves.)
	 */
	if ( ddw_tbexob_use_tweak_remove_theme_editor() ) {

		remove_submenu_page(
			'themes.php',
			'theme-editor.php'
		);

	}  // end if

}  // end function


add_action( 'wp_head', 'ddw_tbexob_styles_oxygen_logo', 100 );
/**
 * For the Oxygen Logo icon add the needed CSS styles inline.
 *   Note: This is for frontend only.
 *
 * @since 1.0.0
 *
 * @return string CSS styling for selected Toolbar items.
 */
function ddw_tbexob_styles_oxygen_logo() {

	?>
		<style type="text/css">
			#wp-admin-bar-oxygen_admin_bar_menu .tbexob-oxygen-logo-svg {
				width: 15px;
				height: 15px;
			}
			.tbex-node-oxygen-logo.hover:hover .tbexob-oxygen-logo-svg {
				opacity: .6;
			}
			.tbex-node-oxygen-dashicon .dashicons-before:before {
				margin-top: 2px;
			}
		</style>
	<?php

}  // end function


/**
 * To get filterable hook priority for original Oxygen item.
 *   Default: 1000 - that means mostly at the right side of the left Toolbar
 *   "column".
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return int Hook priority for original Oxygen item.
 */
function ddw_tbexob_get_oxygen_item_priority() {

	return absint(
		apply_filters(
			'tbexob/filter/oxygen/item_priority',
			ddw_tbex_get_option( 'oxygen', 'oxygen_tl_priority' )	// 1000
		)
	);

}  // end function


remove_action( 'admin_bar_menu', 'ct_oxygen_admin_menu', 1000 );
add_action( 'admin_bar_menu', 'ct_oxygen_admin_menu', ddw_tbexob_get_oxygen_item_priority() );
add_filter( 'admin_bar_menu', 'ddw_tbexob_maybe_tweak_oxygen_toolbar_item', ddw_tbexob_get_oxygen_item_priority() );
/**
 * Based on settings render a logo/ and icon for the original "Oxygen" top-level
 *   item on the frontend.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_option()
 * @uses ddw_tbexob_string_oxygen()
 * @uses ddw_tbex_item_title_with_settings_icon()
 * @uses ddw_tbex_meta_target()
 *
 * @param object $wp_admin_bar Holds all nodes of the Toolbar.
 */
function ddw_tbexob_maybe_tweak_oxygen_toolbar_item( $wp_admin_bar ) {

	/** Bail early if not on the frontend! */
	if ( is_admin() ) {
		return;
	}

	$parent_side = sanitize_key( ddw_tbex_get_option( 'oxygen', 'oxygen_tl_parent' ) );

	$parent = ( 'right' === $parent_side ) ? 'top-secondary' : '';

	$use_icon = ddw_tbex_get_option( 'oxygen', 'oxygen_tl_use_icon' );

	$class = '';
	$icon  = '';
	$label = ddw_tbexob_string_oxygen();
	$title = $label;

	if ( 'oxygen' === $use_icon ) {

		$class = 'tbex-node-oxygen-logo';
		$icon  = TBEXOB_PLUGIN_URL . 'assets/images/oxygen-logo-icon.svg';

		$title = sprintf(
			'<span class="ab-icon tbex-settings-icon tbexob-oxygen-logo"><img class="tbexob-oxygen-logo-svg" src="%2$s" /></span><span class="ab-label">%1$s</span>',
			$label,
			$icon
		);

	} elseif ( 'dashicon' === $use_icon ) {

		$class = 'tbex-node-oxygen-dashicon';
		$title = ddw_tbex_item_title_with_settings_icon( $label, 'oxygen', 'oxygen_tl_icon' );

	}  // end if

	$title_attr = sprintf(
		/* translators: %s - Word "Oxygen" */
		esc_attr__( 'Current %s Builder Templates in use', 'toolbar-extras-oxygen' ),
		ddw_tbexob_string_oxygen()
	);

	$wp_admin_bar->add_node(
		array(
			'id'     => 'oxygen_admin_bar_menu',	// same as original!
			'parent' => $parent,
			'title'  => $title,
			'href'   => esc_url( admin_url( 'edit.php?post_type=ct_template' ) ),
			'meta'   => array(
				'class'  => $class,
				'target' => ddw_tbex_meta_target(),
				'title'  => $title_attr,
			)
		)
	);

}  // end function


add_filter( 'tbex_filter_unloading_textdomains', 'ddw_tbexob_tweak_unload_textdomain_oxygen_builder' );
/**
 * Unload textdomain(s) for "Oxygen Builder" plugin.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_use_tweak_unload_translations_oxygen()
 *
 * @param array $textdomains Array of textdomains.
 * @return array Modified array of textdomains for unloading.
 */
function ddw_tbexob_tweak_unload_textdomain_oxygen_builder( $textdomains ) {

	/** Bail early if tweak shouldn't be used */
	if ( ! ddw_tbexob_use_tweak_unload_translations_oxygen() ) {
		return $textdomains;
	}

	$oxygen_domains = array( 'oxygen', 'component-theme', 'oxygen-acf', 'oxygen-toolset' );

	return array_merge( $textdomains, $oxygen_domains );

}  // end function


add_action( 'admin_menu', 'ddw_tbexob_submenu_tweaks_oxygen', 999 );
/**
 * Necessary tweaks to set the Oxygen Templates submenu (post type) to the
 *   proper parent file which is Oxygen Dashboard page
 *   (hook: 'ct_dashboard_page' ).
 *
 * @since 1.0.0
 *
 * @uses remove_submenu_page()
 * @uses add_submenu_page()
 * @uses ddw_tbexob_is_oxygen_theme_enabler_active()
 *
 * @global string $GLOBALS[ 'submenu' ]
 */
function ddw_tbexob_submenu_tweaks_oxygen() {

	/** Firstly, remove from "wrong" hook place */	
	remove_submenu_page( 'ct_templates', 'edit.php?post_type=ct_template' );

	/** Secondly, add to the "right" hook place/ parent file */
	add_submenu_page(
		'ct_dashboard_page',
		esc_attr__( 'Templates', 'toolbar-extras-oxygen' ),
		esc_attr__( 'Templates', 'toolbar-extras-oxygen' ),
		'read',		// same as original!
		esc_url( admin_url( 'edit.php?post_type=ct_template' ) )
	);

	/** Thirdly, unset another "mystery occurrence" of Templates */
	if ( ! ddw_tbexob_is_oxygen_theme_enabler_active() ) {

		if ( isset( $GLOBALS[ 'submenu' ][ 'ct_dashboard_page' ][6] ) ) {
			$GLOBALS[ 'submenu' ][ 'ct_dashboard_page' ][6] = null;
		}

	} elseif ( ddw_tbexob_is_oxygen_theme_enabler_active() ) {

		if ( isset( $GLOBALS[ 'submenu' ][ 'ct_dashboard_page' ][7] ) ) {
			$GLOBALS[ 'submenu' ][ 'ct_dashboard_page' ][7] = null;
		}

	}  // end if

}  // end function


add_filter( 'parent_file', 'ddw_tbexob_parent_submenu_tweaks' );
/**
 * When editing an Oxygen template within the Admin, properly highlight it as
 *   the 'submenu' of Oxygen.
 *
 * @since 1.0.0
 *
 * @uses get_current_screen()
 *
 * @param string $parent_file The filename of the parent menu.
 * @return string $parent_file The tweaked filename of the parent menu.
 */
function ddw_tbexob_parent_submenu_tweaks( $parent_file ) {

	if ( 'ct_template' === get_current_screen()->id
		|| 'ct_template' === get_current_screen()->post_type
	) {

		$parent_file = 'ct_dashboard_page';

	}  // end if

	return $parent_file;

}  // end function


/**
 * Build link collection to add as additional items to the "Back to WP" section
 *   within the Oxygen Builder's interface.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_is_woocommerce_active()
 * @uses ddw_tbexob_is_oxygen_user_library_active()
 *
 * @return string Markup and translateable strings for the "Back to WP" section
 *                within the Oxygen Builder interface.
 */
function ddw_tbexob_oxygen_builder_backtowp_additions() {

	/** Set array of standard links */
	$links = array(
		'oxygen_templates' => array(
			'label'     => _x( 'Templates', 'Label in Oxygen Toolbar', 'toolbar-extras-oxygen' ),
			'admin_url' => 'edit.php?post_type=ct_template',
		),
		'pages' => array(
			'label'     => __( 'Pages', 'Label in Oxygen Toolbar', 'toolbar-extras-oxygen' ),
			'admin_url' => 'edit.php?post_type=page',
		),
	);

	/** Optional: WooCommerce products */
	if ( ddw_tbex_is_woocommerce_active() ) {
		
		$links[ 'products' ] = array(
			'label'     => __( 'Products', 'Label in Oxygen Toolbar', 'toolbar-extras-oxygen' ),
			'admin_url' => 'edit.php?post_type=product',
		);

	}  // end if

	/** Optional: Oxygen User Elements Library */
	if ( ddw_tbexob_is_oxygen_user_library_active() ) {
		
		$links[ 'user-library' ] = array(
			'label'     => __( 'Elements Library', 'Label in Oxygen Toolbar', 'toolbar-extras-oxygen' ),
			'admin_url' => 'edit.php?post_type=oxy_user_library',
		);

	}  // end if

	/** Make links array filterable */
	$links = apply_filters( 'tbexob/filter/oxygen_builder/backtowp_links', $links );

	$link_collection = '';

	/** Loop through each item of the array to build the link collection */
	foreach ( $links as $link_key => $link_data ) {

		$link_collection .= sprintf(
			'<a class="oxygen-toolbar-button-dropdown-option" href="%1$s">%2$s</a>',
			esc_url( admin_url( $link_data[ 'admin_url' ] ) ),
			esc_attr( $link_data[ 'label' ] )
		);

	}  // end foreach

	/** Output the markup/strings */
	return $link_collection;

}  // end function


add_action( 'oxygen_enqueue_ui_scripts', 'ddw_tbexob_oxygen_builder_toolbar_additions' );
/**
 * Register and enqueue the jQuery-based JavaScript to add/tweak the "Back to
 *   WP" links section.
 *
 *   Note: This only affects the Oxygen Builder interface itself. Therefore this
 *         also fires directly at the appropriate Oxygen hook (and not WP's).
 *
 * @since 1.0.0
 *
 * @uses wp_localize_script()
 * @uses ddw_tbexob_add_more_btwp_links()
 * @uses ddw_tbexob_oxygen_builder_backtowp_additions()
 * @uses ddw_tbexob_btwp_target()
 * @uses ddw_tbex_meta_rel()
 * @uses ddw_tbex_display_link_title_attributes()
 */
function ddw_tbexob_oxygen_builder_toolbar_additions() {

	/** Bail early if not in Builder context */
	if ( ! defined( 'SHOW_CT_BUILDER' ) ) {
		return;
	}

	/** Register script */
	wp_register_script(
		'tbexob-toolbar-additions',
		TBEXOB_PLUGIN_URL . 'assets/js/tbexob-toolbar.js',
		array( 'jquery' ),
		TBEXOB_PLUGIN_VERSION,
		TRUE
	);

	/** Optionally add additional links */
	if ( ddw_tbexob_add_more_btwp_links() ) {

		wp_localize_script(
			'tbexob-toolbar-additions',
			'oxylinks',
			ddw_tbexob_oxygen_builder_backtowp_additions()
		);

	}  // end if

	/** Link targets */
	wp_localize_script(
		'tbexob-toolbar-additions',
		'oxytarget',
		ddw_tbexob_btwp_target()
	);

	/** Link relation */
	wp_localize_script(
		'tbexob-toolbar-additions',
		'oxyrel',
		ddw_tbex_meta_rel()
	);

	/** Link title attribute */
	$title_attr   = ( '_blank' === ddw_tbexob_btwp_target() ) ? __( 'Opens in new tab/ window', 'toolbar-extras-oxygen' ) : __( 'Opens in same tab/ window', 'toolbar-extras-oxygen' );
	$oxytitleattr = ddw_tbex_display_link_title_attributes() ? esc_attr( $title_attr ) : ' ';

	wp_localize_script(
		'tbexob-toolbar-additions',
		'oxytitleattr',
		$oxytitleattr
	);

	/** Finally, enqueue the script */
	wp_enqueue_script( 'tbexob-toolbar-additions' );

}  // end function
