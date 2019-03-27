<?php

// includes/admin/tbexob-settings

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Default values of the plugin's Oxygen Add-On options.
 *   Note: Option key for the settings array is 'tbex-options-oxygen' - this is
 *         needed to be compatible with the function ddw_tbex_get_option() in
 *         Toolbar Extras (base plugin).
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_string_websites_with_counter()
 *
 * @return array strings Parsed args of default options.
 */
function ddw_tbexob_default_options_oxygen() {

	/** Set the default values - make them filterable */
	$tbexob_default_options = apply_filters(
		'tbexob/filter/options/default_oxygen',
		array(

			/** Oxygen components as Toolbar items */
			'oxygen_name'               => esc_attr_x( 'Oxygen', 'Toolbar item label', 'toolbar-extras-oxygen' ),	// "Oxygen"
			'oxygen_display_customizer' => 'yes',
			'oxygen_tl_use_icon'        => 'oxygen',
			'oxygen_tl_icon'            => 'dashicons-welcome-widgets-menus',
			'oxygen_tl_priority'        => 1000,		// Same as in Oxygen itself
			'oxygen_tl_parent'          => '',			// Same as in Oxygen itself, means "top-level"!
			'oxygen_row_actions'        => 'yes',
			'oxygen_post_state'         => 'yes',
			'oxygen_post_state_color'   => '#7046db',	// defaults to Oxygen blue

			/** Oxygen Builder "Back to WP" section */
			'oxygen_btwp_links'         => 'yes',		// yes, add additional links
			'oxygen_btwp_links_blank'   => 'yes',		// open those in a new tab/ window

			/** Various tweaks */
			'note_for_coloring'         => '',			// Only for user note/guidance, just a "virtual setting"
			'remove_submenu_themes'     => 'yes',		// It is really not needed, so it can go
			'remove_submenu_customizer' => 'no',		// Keep it by default, for Menus, Site Identity etc.
			'remove_theme_editor'       => 'no',		// Keep it by default
			'unload_td_oxygen'          => 'no',
			'unload_td_tbexob'          => 'no',

		)  // end of array
	);

	/** Parse settings default attributes */
	$tbexob_defaults = wp_parse_args(
		get_option( 'tbex-options-oxygen' ),
		$tbexob_default_options
	);

	/** Return the Oxygen settings defaults */
	return $tbexob_defaults;

}  // end function


add_action( 'admin_init', 'ddw_tbexob_register_settings_oxygen', 10 );
/**
 * Load plugin's settings for settings tab "Oxygen".
 *   Note: Option key for the settings array is 'tbex-options-oxygen' - this is
 *         needed to be compatible with the function ddw_tbex_get_option() in
 *         Toolbar Extras (base plugin).
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_default_options_oxygen()
 * @uses ddw_tbexob_string_backtowp()
 */
function ddw_tbexob_register_settings_oxygen() {

	/** If options do not exist (on first run), update them with default values */
	if ( ! get_option( 'tbex-options-oxygen' ) ) {
		update_option( 'tbex-options-oxygen', ddw_tbexob_default_options_oxygen() );
	}

	/** Prepare conditional settings */
	$plugin_inactive = ' plugin-inactive';

	/** Status for "Oxygen Theme Enabler" plugin "dependency" */
	$status_oxygen_theme_enabler = ! ddw_tbexob_is_oxygen_theme_enabler_active() ? ' plugin-oxygen-theme-enabler' : $plugin_inactive;

	/** Settings args */
	$tbexob_settings_args = array( 'sanitize_callback' => 'ddw_tbexob_validate_settings_oxygen' );

	/** Register options group for Oxygen Add-On tab */
	register_setting(
		'tbexob_group_oxygen',
		'tbex-options-oxygen',
		$tbexob_settings_args
	);

		/** Oxygen: 1st section (for Oxygen Builder) */
		add_settings_section(
			'tbexob-section-oxygen',
			'<h3 class="tbex-settings-section first">' . __( 'For Oxygen Builder', 'toolbar-extras-oxygen' ) . '</h3>',
			'ddw_tbexob_settings_section_info_oxygen',
			'tbexob_group_oxygen'
		);

			add_settings_field(
				'oxygen_name',
				__( 'Name of Oxygen', 'toolbar-extras-oxygen' ),
				'ddw_tbexob_settings_cb_oxygen_name',
				'tbexob_group_oxygen',
				'tbexob-section-oxygen',
				array( 'class' => 'tbexob-setting-oxygen-name' )
			);

			add_settings_field(
				'oxygen_display_customizer',
				/* translators: %s - label, "Build Group" */
				sprintf( __( 'Display Settings Customizer in %s?', 'toolbar-extras-oxygen' ), '<em>' . __( 'Build Group', 'toolbar-extras-oxygen' ) . '</em>' ),
				'ddw_tbexob_settings_cb_oxygen_display_customizer',
				'tbexob_group_oxygen',
				'tbexob-section-oxygen',
				array( 'class' => 'tbexob-setting-oxygen-display-customizer tbex-setting-conditional' . $status_oxygen_theme_enabler )
			);

			add_settings_field(
				'oxygen_tl_use_icon',
				__( 'Which icon to use for the original Oxygen item?', 'toolbar-extras-oxygen' ),
				'ddw_tbexob_settings_cb_oxygen_tl_use_icon',
				'tbexob_group_oxygen',
				'tbexob-section-oxygen',
				array( 'class' => 'tbexob-setting-oxygen-tl-use-icon' )
			);

			add_settings_field(
				'oxygen_tl_icon',
				__( 'Pick a Dashicon Icon for the original Oxygen item', 'toolbar-extras-oxygen' ),
				'ddw_tbexob_settings_cb_oxygen_tl_icon',
				'tbexob_group_oxygen',
				'tbexob-section-oxygen',
				array( 'class' => 'tbexob-setting-oxygen-tl-icon' )
			);

			add_settings_field(
				'oxygen_tl_priority',
				__( 'Priority of original Oxygen top-level item', 'toolbar-extras-oxygen' ),
				'ddw_tbexob_settings_cb_oxygen_tl_priority',
				'tbexob_group_oxygen',
				'tbexob-section-oxygen',
				array( 'class' => 'tbexob-setting-oxygen-tl-priority' )
			);

			add_settings_field(
				'oxygen_tl_parent',
				__( 'Parent hook place of original Oxygen top-level item', 'toolbar-extras-oxygen' ),
				'ddw_tbexob_settings_cb_oxygen_tl_parent',
				'tbexob_group_oxygen',
				'tbexob-section-oxygen',
				array( 'class' => 'tbexob-setting-oxygen-tl-parent' )
			);

			$settings_title_row_action = sprintf(
				__( 'Add post type Row Action %s?', 'toolbar-extras-oxygen' ),
				'<em>' . ddw_tbexob_string_edit_with_oxygen() . '</em>'
			);

			add_settings_field(
				'oxygen_row_actions',
				$settings_title_row_action,
				'ddw_tbexob_settings_cb_oxygen_row_actions',
				'tbexob_group_oxygen',
				'tbexob-section-oxygen',
				array( 'class' => 'tbexob-setting-oxygen-row-actions' )
			);

			add_settings_field(
				'oxygen_post_state',
				__( 'Add post type Post State for Oxygen?', 'toolbar-extras-oxygen' ),
				'ddw_tbexob_settings_cb_oxygen_post_state',
				'tbexob_group_oxygen',
				'tbexob-section-oxygen',
				array( 'class' => 'tbexob-setting-oxygen-post-state' )
			);

			add_settings_field(
				'oxygen_post_state_color',
				__( 'Set color for Post State label', 'toolbar-extras-oxygen' ),
				'ddw_tbexob_settings_cb_oxygen_post_state_color',
				'tbexob_group_oxygen',
				'tbexob-section-oxygen',
				array( 'class' => 'tbexob-setting-oxygen-post-state-color' )
			);


		/** Oxygen: 2nd section (Oxygen Builder interface) */
		add_settings_section(
			'tbexob-section-builder',
			'<h3 class="tbex-settings-section">' . __( 'Oxygen Builder Interface', 'toolbar-extras-oxygen' ) . '</h3>',
			'ddw_tbexob_settings_section_info_oxygen_builder_interface',
			'tbexob_group_oxygen'
		);

			add_settings_field(
				'oxygen_btwp_links',
				/* translators: %s - label, "Back to WP" */
				sprintf( __( 'Enable additional links for %s section?', 'toolbar-extras-oxygen' ), '<em>' . ddw_tbexob_string_backtowp() . '</em>' ),
				'ddw_tbexob_settings_cb_oxygen_btwp_links',
				'tbexob_group_oxygen',
				'tbexob-section-builder',
				array( 'class' => 'tbexob-setting-oxygen-btwp-links' )
			);

			add_settings_field(
				'oxygen_btwp_links_blank',
				/* translators: %s - label, "Back to WP" */
				sprintf( __( 'Open those %s links in a New Tab/ Window?', 'toolbar-extras-oxygen' ), '<em>' . ddw_tbexob_string_backtowp() . '</em>' ),
				'ddw_tbexob_settings_cb_oxygen_btwp_links_blank',
				'tbexob_group_oxygen',
				'tbexob-section-builder',
				array( 'class' => 'tbexob-setting-oxygen-btwp-links-blank' )
			);



		/** Oxygen: 3rd section (various tweaks) */
		add_settings_section(
			'tbexob-section-tweaks',
			'<h3 class="tbex-settings-section">' . __( 'Various Tweaks', 'toolbar-extras-oxygen' ) . '</h3>',
			'ddw_tbexob_settings_section_info_oxygen_tweaks',
			'tbexob_group_oxygen'
		);

			add_settings_field(
				'note_for_coloring',
				__( 'Set background color, icon and special text for Toolbar', 'toolbar-extras-oxygen' ),
				'ddw_tbex_addon_settings_cb_note_for_coloring',		// via base plugin!
				'tbexob_group_oxygen',
				'tbexob-section-tweaks',
				array( 'class' => 'tbexob-setting-note-for-coloring' )
			);

			add_settings_field(
				'remove_submenu_themes',
				__( 'Remove Themes Submenu from Appearance Admin Menu?', 'toolbar-extras-oxygen' ),
				'ddw_tbexob_settings_cb_remove_submenu_themes',
				'tbexob_group_oxygen',
				'tbexob-section-tweaks',
				array( 'class' => 'tbexob-setting-remove-submenu-themes tbex-setting-conditional' . $status_oxygen_theme_enabler )
			);

			add_settings_field(
				'remove_submenu_customizer',
				__( 'Remove Customizer Submenu from Appearance Admin Menu?', 'toolbar-extras-oxygen' ),
				'ddw_tbexob_settings_cb_remove_submenu_customizer',
				'tbexob_group_oxygen',
				'tbexob-section-tweaks',
				array( 'class' => 'tbexob-setting-remove-submenu-customizer tbex-setting-conditional' . $status_oxygen_theme_enabler )
			);

			add_settings_field(
				'remove_theme_editor',
				__( 'Remove Theme Editor Submenu from Appearance Admin Menu, plus Disable this Editor?', 'toolbar-extras-oxygen' ),
				'ddw_tbexob_settings_cb_remove_theme_editor',
				'tbexob_group_oxygen',
				'tbexob-section-tweaks',
				array( 'class' => 'tbexob-setting-remove-theme-editor tbex-setting-conditional' . $status_oxygen_theme_enabler )
			);

			add_settings_field(
				'unload_td_oxygen',
				__( 'Unload all Oxygen Translations?', 'toolbar-extras-oxygen' ),
				'ddw_tbexob_settings_cb_unload_td_oxygen',
				'tbexob_group_oxygen',
				'tbexob-section-tweaks',
				array( 'class' => 'tbexob-setting-unload-td-oxygen' )
			);

			add_settings_field(
				'unload_td_tbexob',
				__( 'Unload Toolbar Extras for Oxygen Add-On Translations?', 'toolbar-extras-oxygen' ),
				'ddw_tbexob_settings_cb_unload_td_tbexob',
				'tbexob_group_oxygen',
				'tbexob-section-tweaks',
				array( 'class' => 'tbexob-setting-unload-td-tbexob' )
			);

}  // end function


/**
 * Validate Oxygen settings callback.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_default_options_general()
 *
 * @param mixed $input User entered value of settings field key.
 * @return string(s) Sanitized user inputs ("parsed").
 */
function ddw_tbexob_validate_settings_oxygen( $input ) {

	$tbexob_default_options = ddw_tbexob_default_options_oxygen();

	$parsed = wp_parse_args( $input, $tbexob_default_options );

	/** Save empty text fields with default options */
	$textfields = array(
		'oxygen_name',
	);

	foreach( $textfields as $textfield ) {
		$parsed[ $textfield ] = wp_filter_nohtml_kses( $input[ $textfield ] );
	}

	/** Save URL fields */
	$url_fields = array(
	);

	foreach( $url_fields as $url ) {
		$parsed[ $url ] = esc_url( $input[ $url ] );
	}

	/** Save CSS classes sanitized */
	$cssclasses_fields = array(
	);

	foreach( $cssclasses_fields as $cssclass ) {
		$parsed[ $cssclass ] = strtolower( sanitize_html_class( $input[ $cssclass ] ) );
	}

	/** Save integer fields */
	$integer_fields = array(
		'oxygen_tl_priority',
	);

	foreach ( $integer_fields as $integer ) {
		$parsed[ $integer ] = absint( $input[ $integer ] );
	}

	/** Save HEX color fields */
	$hexcolor_fields = array(
		'oxygen_post_state_color',
	);

	foreach ( $hexcolor_fields as $hexcolor ) {
		$parsed[ $hexcolor ] = sanitize_hex_color( $input[ $hexcolor ] );
	}

	/** Save select & key fields */
	$select_fields = array(
		'oxygen_display_customizer',
		'oxygen_tl_use_icon',
		'oxygen_tl_icon',
		'oxygen_tl_parent',
		'oxygen_row_actions',
		'oxygen_post_state',
		'oxygen_btwp_links',
		'oxygen_btwp_links_blank',
		'note_for_coloring',
		'remove_submenu_themes',
		'remove_submenu_customizer',
		'remove_theme_editor',
		'unload_td_oxygen',
		'unload_td_tbexob',
	);

	foreach( $select_fields as $select ) {
		$parsed[ $select ] = sanitize_key( $input[ $select ] );
	}

	/** Return the sanitized user input value(s) */
	return $parsed;

}  // end function


add_filter( 'tbex_filter_settings_toggles', 'ddw_tbexob_pass_toggable_settings_oxygen' );
/**
 * Via TBEX Core 'tbex_filter_settings_toggles' filter telling the TBEX admin JS
 *   which from our settings are toggable (to reveal more sub settings).
 *
 * @since 1.0.0
 *
 * @param array $toggles Array that holds all current registered toggles.
 * @return array Modified array of toggles.
 */
function ddw_tbexob_pass_toggable_settings_oxygen( array $toggles ) {

	/** Merge our settings IDs with the TBEX core array */
	$toggles = array_merge(
		(array) $toggles,
		array(
			'oxygen_icon' => array( '#tbex-options-oxygen-oxygen_tl_use_icon', '.tbexob-setting-oxygen-tl-icon', 'dashicon' ),

			//'builder_target' => array( '#tbex-options-oxygen-oxygen_btwp_links', '.tbexob-setting-oxygen-btwp-links-blank', 'yes' ),

			'oxygen_post_state' => array( '#tbex-options-oxygen-oxygen_post_state', '.tbexob-setting-oxygen-post-state-color', 'yes' ),
		)
	);

	/** Return the merged array */
	return $toggles;

}  // end function


add_action( 'tbex_settings_tab_addons', 'ddw_tbexob_settings_tab_title_oxygen', 10, 1 );
/**
 * Build markup and logic for the "Oxygen" settings tab title.
 *
 * @since 1.0.0
 *
 * @param string $active_tab ID string of current active settings tab.
 * @return string Echoing HTML/ CSS markup, plus strings of settings tab title.
 */
function ddw_tbexob_settings_tab_title_oxygen( $active_tab ) {

	$url_oxygen = esc_url(
		add_query_arg(
			array(
				'page' => 'toolbar-extras',
				'tab'  => 'oxygen'
			),
			admin_url( 'options-general.php' )
		)
	);

	?>
		<a href="<?php echo $url_oxygen; ?>" class="dashicons-before dashicons-welcome-widgets-menus nav-tab <?php echo ( 'oxygen' === $active_tab ) ? 'nav-tab-active' : ''; ?>">
			<?php
				/* translators: Settings tab title in WP-Admin */
				_ex( 'Oxygen', 'Plugin settings tab title', 'toolbar-extras-oxygen' );
			?>
		</a>
	<?php

}  // end function


add_action( 'tbex_settings_tab_addon_oxygen', 'ddw_tbexob_render_settings_tab_oxygen' );
/**
 * Render the "Oxygen" settings tab on the Toolbar Extras settings page.
 *   This will setup all settings sections, settings fields, save button.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_save_changes()
 */
function ddw_tbexob_render_settings_tab_oxygen() {

	do_action( 'tbexob/oxygen_settings/before_view' );

	require_once TBEXOB_PLUGIN_DIR . 'includes/admin/views/settings-tab-oxygen.php';

	settings_fields( 'tbexob_group_oxygen' );
	do_settings_sections( 'tbexob_group_oxygen' );

	do_action( 'tbexob/oxygen_settings/after_view' );

	submit_button( ddw_tbex_string_save_changes() );

}  // end function


add_action( 'tbexob/oxygen_settings/before_view', 'ddw_tbexob_settings_before_view_oxygen' );
/**
 * Add-On description and info on settings tab page.
 *
 * @since 1.0.0
 */
function ddw_tbexob_settings_before_view_oxygen() {

	?>
		<div class="tbex-addon-header dashicons-before dashicons-welcome-widgets-menus">
			<h3 class="tbex-addon-title">
				<?php _e( 'Add-On', 'toolbar-extras-oxygen' ); ?>: <?php _e( 'Toolbar Extras for Oxygen Builder', 'toolbar-extras-oxygen' ); ?>
				<span class="tbex-version"><?php echo ( defined( 'TBEXOB_PLUGIN_VERSION' ) ) ? 'v' . TBEXOB_PLUGIN_VERSION : ''; ?></span>
			</h3>
			<p class="description">
				<?php echo sprintf(
					__( 'This Add-On brings the settings and items of the %s to your Toolbar, including current active Oxygen Add-Ons.', 'toolbar-extras-oxygen' ),
					'<a href="' . esc_url( admin_url( 'admin.php?page=ct_dashboard_page' ) ) . '">' . __( 'Oxygen Builder', 'toolbar-extras-oxygen' ) . '</a>'
				); ?>
				<br /><?php _e( 'Below you will find lots of settings to customize your experience for building websites with Oxygen even faster.', 'toolbar-extras-oxygen' ); ?>
			</p>
		</div>
	<?php

}  // end function


add_action( 'tbex_plugins_settings_addons', 'ddw_tbexob_add_settings_tab_item_oxygen' );
/**
 * This will add the Oxygen settings tab link item to Toolbar Extras' own
 *   settings group within the "Site Group".
 *
 * @since 1.0.0
 *
 * @global mixed $GLOBALS[ 'wp_admin_bar' ]
 */
function ddw_tbexob_add_settings_tab_item_oxygen() {

	$GLOBALS[ 'wp_admin_bar' ]->add_node(
		array(
			'id'     => 'tbex-settings-oxygen',
			'parent' => 'tbex-settings',
			'title'  => esc_attr_x( 'Oxygen Add-On', 'For Toolbar Extras Plugin', 'toolbar-extras-oxygen' ),
			'href'   => esc_url( admin_url( 'options-general.php?page=toolbar-extras&tab=oxygen' ) ),
			'meta'   => array(
				'target' => '',
				/* translators: Title attribute for Toolbar Extras "Oxygen Builder Add-On" settings link */
				'title'  => esc_attr_x( 'Oxygen Builder Add-On for Toolbar Extras', 'For Toolbar Extras Plugin', 'toolbar-extras-oxygen' )
			)
		)
	);

}  // end function


add_filter( 'tbex_filter_user_profile_buttons', 'ddw_tbexob_user_profile_button_oxygen' );
/**
 * Add own "Oxygen" button to the Toolbar Extras section on the user profile page.
 *
 * @since 1.0.0
 *
 * @param array $settings_buttons Array of settings buttons.
 * @return array Modified array of settings buttons. 
 */
function ddw_tbexob_user_profile_button_oxygen( $settings_buttons ) {

	$settings_buttons[ 'oxygen' ] = array(
		'title_attr' => esc_attr__( 'Go to the Toolbar Extras Oxygen Add-On settings tab', 'toolbar-extras-oxygen' ),
		'label'      => _x( 'Oxygen', 'Plugin settings tab title', 'toolbar-extras-oxygen' ),
		'dashicon'   => 'welcome-widgets-menus',
	);

	return $settings_buttons;

}  // end function


add_action( 'admin_menu', 'ddw_tbexob_add_submenu_for_oxygen', 100 );
/**
 * Add additional admin menu items to make Toolbar settings more accessable.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_is_oxygen_active()
 * @uses add_submenu_page()
 */
function ddw_tbexob_add_submenu_for_oxygen() {

	/** Bail early if Oxygen Builder not active */
	if ( ! ddw_tbexob_is_oxygen_active() ) {
		return;
	}

	/** Add to Oxygen's regular left-hand admin menu */
	$menu_title = esc_html_x( 'Oxygen Toolbar', 'Admin menu title', 'toolbar-extras-oxygen' );

	add_submenu_page(
		'ct_dashboard_page',
		$menu_title,
		$menu_title,
		'manage_options',
		esc_url( admin_url( 'options-general.php?page=toolbar-extras&tab=oxygen' ) )
	);

}  // end function


add_filter( 'tbex_filter_color_items', 'ddw_tbexob_add_color_item_wordpress', 100 );
/**
 * Add additional MainWP color item to the color palette of "Local Development
 *   environment".
 *
 * @since 1.0.0
 *
 * @param array $color_items Array holding all color items.
 * @return array Modified array of color items.
 */
function ddw_tbexob_add_color_item_wordpress( $color_items ) {

	$color_items[ 'wp-black' ] = array(
		'color' => '#555',
		'name'  => __( 'WordPress Black', 'toolbar-extras-oxygen' ),
	);

	return $color_items;

}  // end function
