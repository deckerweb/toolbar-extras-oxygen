<?php

// includes/admin/admin-extras

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


//


//


/**
 * Add "Settings" and Custom Menu" links to Plugins page.
 *
 * @since 1.0.0
 * @since 1.2.0 Overall code improvements.
 *
 * @uses ddw_tbexob_is_toolbar_extras_active()
 * @uses ddw_tbexob_is_oxygen_active()
 *
 * @param array $action_links (Default) Array of plugin action links.
 * @return array Modified array of plugin action links.
 */
function ddw_tbexob_custom_settings_links( $action_links = [] ) {

	$tbexob_links = array();

	/** Add settings link only if user can 'manage_options' */
	if ( current_user_can( 'manage_options' ) ) {

		/** If environment is not ready point to plugin manager */
		if ( ( ddw_tbexob_is_toolbar_extras_active() && version_compare( TBEX_PLUGIN_VERSION, TBEXOB_REQUIRED_BASE_PLUGIN_VERSION, '>=' ) )
			&& ! ddw_tbexob_is_oxygen_active()
		) {

			$tbexob_links[ 'settings' ] = sprintf(
				'<a href="%s" title="%s"><span class="dashicons-before dashicons-admin-plugins"></span> %s</a>',
				esc_url( admin_url( 'plugins.php?page=toolbar-extras-suggested-plugins' ) ),
				esc_html__( 'First Step: Setup Environment to use the plugin', 'toolbar-extras-oxygen' ),
				esc_attr__( 'First Step: Setup Environment', 'toolbar-extras-oxygen' )
			);

		}  // end if

		/** Oxygen & Settings Page links */
		if ( ddw_tbexob_is_toolbar_extras_active() && ddw_tbexob_is_oxygen_active() ) {

			$tbexob_links[ 'oxygen' ] = sprintf(
				'<a href="%s" title="%s"><span class="dashicons-before dashicons-welcome-widgets-menus"></span> %s</a>',
				esc_url( admin_url( 'admin.php?page=ct_dashboard_page' ) ),
				esc_html__( 'Oxygen Builder', 'toolbar-extras-oxygen' ),
				esc_attr__( 'Oxygen', 'toolbar-extras-oxygen' )
			);

			$tbexob_links[ 'settings' ] = sprintf(
				'<a href="%s" title="%s"><span class="dashicons-before dashicons-admin-generic"></span> %s</a>',
				esc_url( admin_url( 'options-general.php?page=toolbar-extras&tab=oxygen' ) ),
				esc_html__( 'Toolbar Settings for Oxygen Builder', 'toolbar-extras-oxygen' ),
				esc_attr__( 'Toolbar Settings', 'toolbar-extras-oxygen' )
			);

		}  // end if

	}  // end if

	/** Display plugin settings links */
	return apply_filters(
		'tbexob/filter/plugins_page/settings_link',
		array_merge( $tbexob_links, $action_links ),
		$tbexob_links		// additional param
	);

}  // end function


add_filter( 'plugin_row_meta', 'ddw_tbexob_plugin_links', 10, 2 );
/**
 * Add various support links to Plugins page.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_info_link()
 *
 * @param array  $tbexob_links (Default) Array of plugin meta links
 * @param string $tbexob_file  Path of base plugin file
 * @return array $tbexob_links Array of plugin link strings to build HTML markup.
 */
function ddw_tbexob_plugin_links( $tbexob_links, $tbexob_file ) {

	/** Capability check */
	if ( ! current_user_can( 'install_plugins' ) ) {
		return $tbexob_links;
	}

	/** List additional links only for this plugin */
	if ( $tbexob_file === TBEXOB_PLUGIN_BASEDIR . 'toolbar-extras-oxygen.php' ) {

		?>
			<style type="text/css">
				tr[data-plugin="<?php echo $tbexob_file; ?>"] .plugin-version-author-uri a.dashicons-before:before {
					font-size: 17px;
					margin-right: 2px;
					opacity: .85;
					vertical-align: sub;
				}
			</style>
		<?php

		/* translators: Plugins page listing */
		$tbexob_links[] = ddw_tbex_get_info_link(
			'url_wporg_forum',
			esc_html_x( 'Support', 'Plugins page listing', 'toolbar-extras-oxygen' ),
			'dashicons-before dashicons-sos',
			'oxygen'
		);

		/* translators: Plugins page listing */
		$tbexob_links[] = ddw_tbex_get_info_link(
			'url_fb_group',
			esc_html_x( 'Facebook Group', 'Plugins page listing', 'toolbar-extras-oxygen' ),
			'dashicons-before dashicons-facebook'
		);

		/* translators: Plugins page listing */
		$tbexob_links[] = ddw_tbex_get_info_link(
			'url_translate',
			esc_html_x( 'Translations', 'Plugins page listing', 'toolbar-extras-oxygen' ),
			'dashicons-before dashicons-translation',
			'oxygen'
		);

		/* translators: Plugins page listing */
		$tbexob_links[] = ddw_tbex_get_info_link(
			'url_donate',
			esc_html_x( 'Donate', 'Plugins page listing', 'toolbar-extras-oxygen' ),
			'button dashicons-before dashicons-thumbs-up'
		);

		/* translators: Plugins page listing */
		$tbexob_links[] = ddw_tbex_get_info_link(
			'url_newsletter',
			esc_html_x( 'Join our Newsletter', 'Plugins page listing', 'toolbar-extras-oxygen' ),
			'button-primary dashicons-before dashicons-awards'
		);

	}  // end if plugin links

	/** Output the links */
	return apply_filters(
		'tbexob/filter/plugins_page/more_links',
		$tbexob_links
	);

}  // end function


add_filter( 'admin_footer_text', 'ddw_tbexob_admin_footer_tweak' );
/**
 * On the "Oxygen" settings tab add footer text to invite for plugin review.
 *
 * @since 1.0.0
 *
 * @uses get_current_screen()
 *
 * @param string $footer_text The content that will be printed.
 * @return string The content that will be printed.
 */
function ddw_tbexob_admin_footer_tweak( $footer_text ) {

	/** Current screen logic */
	$current_screen = get_current_screen();
	$is_tbex_screen = array(
		'plugins_page_toolbar-extras-oxygen-suggested-plugins',
	);

	/** Active settings tab logic */
	$active_tab = isset( $_GET[ 'tab' ] ) ? sanitize_key( wp_unslash( $_GET[ 'tab' ] ) ) : '';

	/** Conditionally set footer text */
	if ( in_array( $current_screen->id, $is_tbex_screen )
		|| ( 'settings_page_toolbar-extras' === $current_screen->id && 'oxygen' === $active_tab )
	) {

		$rating = sprintf(
			/* translators: %s - 5 stars icons */
			'<a href="https://wordpress.org/support/plugin/toolbar-extras-oxygen/reviews/?filter=5#new-post" target="_blank" rel="noopener noreferrer">' . __( '%s rating', 'toolbar-extras-oxygen' ) . '</a>',
			'&#9733;&#9733;&#9733;&#9733;&#9733;'
		);

		$footer_text = sprintf(
			/* translators: 1 - Toolbar Extras for Oxygen Builder / 2 - label "5 star rating" */
			__( 'Enjoyed %1$s? Please leave us a %2$s. We really appreciate your support!', 'toolbar-extras-oxygen' ),
			'<strong>' . __( 'Toolbar Extras for Oxygen Builder', 'toolbar-extras-oxygen' ) . '</strong>',
			$rating
		);

	}  // end if

	/** Render footer text */
	return $footer_text;

}  // end function


add_filter( 'debug_information', 'ddw_tbexob_site_health_add_debug_info', 6 );
/**
 * Add additional plugin related info to the Site Health Debug Info section.
 *   (Only relevant for WordPress 5.2 or higher)
 *
 * @link https://make.wordpress.org/core/2019/04/25/site-health-check-in-5-2/
 *
 * @since 1.1.0
 * @since 1.2.0 Added new options; tweaks & improvements.
 *
 * @uses ddw_tbex_string_debug_diagnostic()
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 * @uses ddw_tbex_string_uninstalled()
 * @uses ddw_tbexob_is_oxygen_user_library_active()
 *
 * @param array $debug_info Array holding all Debug Info items.
 * @return array Modified array of Debug Info.
 */
function ddw_tbexob_site_health_add_debug_info( $debug_info ) {

	/** Add our Debug info */
	$debug_info[ 'toolbar-extras-oxygen' ] = array(
		'label'       => esc_html__( 'Toolbar Extras for Oxygen Builder', 'toolbar-extras-oxygen' ) . ' (' . esc_html__( 'Add-On Plugin', 'toolbar-extras-oxygen' ) . ')',
		'description' => ddw_tbex_string_debug_diagnostic( 'oxygen' ),
		'fields'      => array(

			/** Add-On values etc. */
			'tbexob_plugin_version' => array(
				'label' => __( 'Add-On Plugin version', 'toolbar-extras-oxygen' ),
				'value' => TBEXOB_PLUGIN_VERSION,
			),
			'tbexob_required_base_plugin_version' => array(
				'label' => __( 'Required Base Plugin version', 'toolbar-extras-oxygen' ),
				'value' => TBEXOB_REQUIRED_BASE_PLUGIN_VERSION,
			),
			'tbexob_oxygen_display_customizer' => array(
				'label' => __( 'Display Settings Customizer', 'toolbar-extras-oxygen' ),
				'value' => get_option( 'tbex-options-oxygen', ddw_tbex_string_yes( 'return' ) )[ 'oxygen_display_customizer' ],
			),
			'tbexob_oxygen_tl_priority' => array(
				'label' => __( 'Oxygen item priority', 'toolbar-extras-oxygen' ),
				'value' => get_option( 'tbex-options-oxygen', '1000' )[ 'oxygen_tl_priority' ],
			),
			'tbexob_oxygen_row_actions' => array(
				'label' => __( 'Use Row Action', 'toolbar-extras-oxygen' ),
				'value' => get_option( 'tbex-options-oxygen', ddw_tbex_string_yes( 'return' ) )[ 'oxygen_row_actions' ],
			),
			'tbexob_oxygen_post_state' => array(
				'label' => __( 'Use Post State', 'toolbar-extras-oxygen' ),
				'value' => get_option( 'tbex-options-oxygen', ddw_tbex_string_yes( 'return' ) )[ 'oxygen_post_state' ],
			),
			'tbexob_oxygen_btwp_links' => array(
				'label' => __( 'Additional links Back to WP section', 'toolbar-extras-oxygen' ),
				'value' => get_option( 'tbex-options-oxygen', ddw_tbex_string_yes( 'return' ) )[ 'oxygen_btwp_links' ],
			),
			'tbexob_oxygen_btwp_links_blank' => array(
				'label' => __( 'Open additional links in new tab', 'toolbar-extras-oxygen' ),
				'value' => get_option( 'tbex-options-oxygen', ddw_tbex_string_yes( 'return' ) )[ 'oxygen_btwp_links_blank' ],
			),

			/** Oxygen specific */
			'CT_VERSION' => array(
				'label' => 'Oxygen Builder: CT_VERSION',
				'value' => ( ! defined( 'CT_VERSION' ) ? ddw_tbex_string_uninstalled() : CT_VERSION ),
			),
			'tbexob_user_library_active' => array(
				'label' => __( 'User Library active', 'toolbar-extras-oxygen' ),
				'value' => ( ddw_tbexob_is_oxygen_user_library_active() ? ddw_tbex_string_yes( 'return' ) : ddw_tbex_string_no( 'return' ) ),
			),

		),  // end array
	);

	/** Return modified Debug Info array */
	return $debug_info;

}  // end function


/**
 * Inline CSS fix for Plugins page update messages.
 *
 * @since 1.0.0
 *
 * @see ddw_tbex_plugin_update_message()
 * @see ddw_tbex_multisite_subsite_plugin_update_message()
 */
function ddw_tbexob_plugin_update_message_style_tweak() {

	?>
		<style type="text/css">
			.tbexob-update-message p:before,
			.update-message.notice p:empty {
				display: none !important;
			}
		</style>
	<?php

}  // end function


add_action( 'in_plugin_update_message-' . TBEXOB_PLUGIN_BASEDIR . 'toolbar-extras-oxygen.php', 'ddw_tbexob_plugin_update_message', 10, 2 );
/**
 * On Plugins page add visible upgrade/update notice in the overview table.
 *   Note: This action fires for regular single site installs, and for Multisite
 *         installs where the plugin is activated Network-wide.
 *
 * @since 1.0.0
 *
 * @param object $data
 * @param object $response
 * @return string Echoed string and markup for the plugin's upgrade/update
 *                notice.
 */
function ddw_tbexob_plugin_update_message( $data, $response ) {

	if ( isset( $data[ 'upgrade_notice' ] ) ) {

		ddw_tbexob_plugin_update_message_style_tweak();

		printf(
			'<div class="update-message tbexob-update-message">%s</div>',
			wpautop( $data[ 'upgrade_notice' ] )
		);

	}  // end if

}  // end function


add_action( 'after_plugin_row_wp-' . TBEXOB_PLUGIN_BASEDIR . 'toolbar-extras-oxygen.php', 'ddw_tbexob_multisite_subsite_plugin_update_message', 10, 2 );
/**
 * On Plugins page add visible upgrade/update notice in the overview table.
 *   Note: This action fires for Multisite installs where the plugin is
 *         activated on a per site basis.
 *
 * @since 1.0.0
 *
 * @param string $file
 * @param object $plugin
 * @return string Echoed string and markup for the plugin's upgrade/update
 *                notice.
 */
function ddw_tbexob_multisite_subsite_plugin_update_message( $file, $plugin ) {

	if ( is_multisite() && version_compare( $plugin[ 'Version' ], $plugin[ 'new_version' ], '<' ) ) {

		$wp_list_table = _get_list_table( 'WP_Plugins_List_Table' );

		ddw_tbexob_plugin_update_message_style_tweak();

		printf(
			'<tr class="plugin-update-tr"><td colspan="%s" class="plugin-update update-message notice inline notice-warning notice-alt"><div class="update-message tbexob-update-message"><h4 style="margin: 0; font-size: 14px;">%s</h4>%s</div></td></tr>',
			$wp_list_table->get_column_count(),
			$plugin[ 'Name' ],
			wpautop( $plugin[ 'upgrade_notice' ] )
		);

	}  // end if

}  // end function


/**
 * Optionally tweaking Plugin API results to make more useful recommendations to
 *   the user.
 *
 * @since 1.0.0
 */

add_filter( 'ddwlib_plir/filter/plugins', 'ddw_tbexob_register_extra_plugin_recommendations_oxygen' );
/**
 * Register specific plugins for the class "DDWlib Plugin Installer
 *   Recommendations".
 *   Note: The top-level array keys are plugin slugs from the WordPress.org
 *         Plugin Directory.
 *
 * @since 1.0.0
 *
 * @param array $plugins Array holding all plugin recommendations, coming from
 *                       the class and the filter.
 * @return array Filtered and merged array of all plugin recommendations.
 */
function ddw_tbexob_register_extra_plugin_recommendations_oxygen( array $plugins ) {

	/** Remove our own slug when we are already active :) */
	if ( isset( $plugins[ 'toolbar-extras-oxygen' ] ) ) {
		$plugins[ 'toolbar-extras-oxygen' ] = null;
	}

	/** Add new keys to recommendations */
	$plugins[ 'wp-asset-clean-up' ] = array(
		'featured'    => 'yes',
		'recommended' => 'yes',
		'popular'     => 'no',
	);

	/** Return tweaked array of plugins */
	return $plugins;

}  // end function
