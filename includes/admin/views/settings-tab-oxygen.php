<?php

// includes/admin/views/settings-tab-oxygen

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * 1) All SECTION INFOS callbacks (rendering)
 * -----------------------------------------------------------------------------
 */

/**
 * Tab Oxygen - 1st settings section: Description.
 *
 * @since 1.0.0
 */
function ddw_tbexob_settings_section_info_oxygen() {

	?>
		<p>
			<?php _e( 'Set a few things regarding the Oxygen Builder and the Toolbar', 'toolbar-extras-oxygen' ); ?>
		</p>
	<?php

}  // end function


/**
 * Tab Oxygen - 2nd settings section: Description.
 *
 * @since 1.0.0
 */
function ddw_tbexob_settings_section_info_oxygen_builder_interface() {

	?>
		<p>
			<?php _e( 'Tweak the behavior of the Oxygen Builder Toolbar in the builder itself.', 'toolbar-extras-oxygen' ); ?>
		</p>
	<?php

}  // end function


/**
 * Tab Oxygen - 3rd settings section: Description.
 *
 * @since 1.0.0
 */
function ddw_tbexob_settings_section_info_oxygen_tweaks() {

	?>
		<p>
			<?php _e( 'Determine which menu items should be removed and set other additional tweaks.', 'toolbar-extras-oxygen' ); ?>
		</p>
	<?php

}  // end function



/**
 * 2) All SETTING FIELDS callbacks (rendering)
 * -----------------------------------------------------------------------------
 */

/**
 * 1st section: Oxygen name etc.:
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

/**
 * Setting (Input, Text): Oxygen Name
 *
 * @since 1.0.0
 */
function ddw_tbexob_settings_cb_oxygen_name() {

	$tbex_options = get_option( 'tbex-options-oxygen' );

	?>
		<input type="text" class="regular-text tbex-input" id="tbex-options-oxygen-oxygen_name" name="tbex-options-oxygen[oxygen_name]" value="<?php echo wp_filter_nohtml_kses( $tbex_options[ 'oxygen_name' ] ); ?>" />
		<label for="tbex-options-oxygen[oxygen_name]">
			<span class="description">
				<?php echo sprintf(
					__( 'Default: %s', 'toolbar-extras-oxygen' ),
					'<code>' . __( 'Oxygen', 'toolbar-extras-oxygen' ) . '</code>'
				); ?>
			</span>
		</label>
	<?php

}  // end function


/**
 * Setting (Select): Display Settings Customizer
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 */
function ddw_tbexob_settings_cb_oxygen_display_customizer() {

	$tbexob_options = get_option( 'tbex-options-oxygen' );

	?>
		<select name="tbex-options-oxygen[oxygen_display_customizer]" id="tbex-options-oxygen-oxygen_display_customizer">
			<option value="yes" <?php selected( sanitize_key( $tbexob_options[ 'oxygen_display_customizer' ] ), 'yes' ); ?>><?php ddw_tbex_string_yes( 'echo' ); ?></option>
			<option value="no" <?php selected( sanitize_key( $tbexob_options[ 'oxygen_display_customizer' ] ), 'no' ); ?>><?php ddw_tbex_string_no( 'echo' ); ?></option>
		</select>
		<label for="tbex-options-oxygen[oxygen_display_customizer]">
			<span class="description"><?php echo sprintf( __( 'Default: %s', 'toolbar-extras-oxygen' ), ddw_tbex_string_yes( 'return', 'code' ) ); ?></span>
		</label>
		<p class="description">
			<?php echo sprintf(
				'<strong>%1$s:</strong> %2$s',
				__( 'Note', 'toolbar-extras-oxygen' ),
				sprintf(
					/* translators: %s - label, "Build Group" */
					__( 'This only effects the Customizer links within the Toolbar\'s %s.', 'toolbar-extras-oxygen' ),
					'"' . __( 'Build Group', 'toolbar-extras-oxygen' ) . '"'
				)
			); ?>
			<br /><?php echo sprintf(
				'<strong>%1$s:</strong> %2$s',
				__( 'General info', 'toolbar-extras-oxygen' ),
				__( 'There\'s still no theme active. But keeping the Customizer accessable allows you to customize settings for Site Identity, Custom CSS and optionally for plugins that hook their regular settings into the Customizer interface. It can also be useful for plugin support in Toolbar Extras.', 'toolbar-extras-oxygen' )
			); ?>
		</p>
	<?php

}  // end function


/**
 * Setting (Select): Which icon to use for the original Oxygen Item
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 */
function ddw_tbexob_settings_cb_oxygen_tl_use_icon() {

	$tbexob_options = get_option( 'tbex-options-oxygen' );

	?>
		<select name="tbex-options-oxygen[oxygen_tl_use_icon]" id="tbex-options-oxygen-oxygen_tl_use_icon">
			<option value="none" <?php selected( sanitize_key( $tbexob_options[ 'oxygen_tl_use_icon' ] ), 'none' ); ?>><?php _e( 'None', 'toolbar-extras-oxygen' ); ?></option>
			<option value="oxygen" <?php selected( sanitize_key( $tbexob_options[ 'oxygen_tl_use_icon' ] ), 'oxygen' ); ?>><?php _e( 'Oxygen Logo Icon', 'toolbar-extras-oxygen' ); ?></option>
			<option value="dashicon" <?php selected( sanitize_key( $tbexob_options[ 'oxygen_tl_use_icon' ] ), 'dashicon' ); ?>><?php _e( 'Dashicon Icon', 'toolbar-extras-oxygen' ); ?></option>
		</select>
		<label for="tbex-options-oxygen[oxygen_tl_use_icon]">
			<span class="description"><?php echo sprintf( __( 'Default: %s', 'toolbar-extras-oxygen' ), '<code>' . __( 'Oxygen Logo Icon', 'toolbar-extras-oxygen' ) . '</code>' ); ?></span>
		</label>
	<?php

}  // end function


/**
 * Setting (Dashicon picker): Original Oxygen Item Icon
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_choose_icon()
 */
function ddw_tbexob_settings_cb_oxygen_tl_icon() {

	$tbex_options = get_option( 'tbex-options-oxygen' );

	?>
		<input class="regular-text tbex-input" type="text" id="tbex-options-oxygen-oxygen_tl_icon" name="tbex-options-oxygen[oxygen_tl_icon]" value="<?php echo strtolower( sanitize_html_class( $tbex_options[ 'oxygen_tl_icon' ] ) ); ?>" />
		<button class="button dashicons-picker" type="button" data-target="#tbex-options-oxygen-oxygen_tl_icon"><span class="dashicons-before dashicons-plus-alt"></span> <?php ddw_tbex_string_choose_icon( 'echo' ); ?></button>
		<br />
		<label for="tbex-options-oxygen[oxygen_tl_icon]">
			<p class="description">
				<?php
					$current = sprintf(
						'<code><span class="dashicons-before %1$s"></span> %1$s</code>',
						$tbex_options[ 'oxygen_tl_icon' ]
					);

					echo sprintf(
						/* translators: %s - a Dashicons CSS class name */
						__( 'Current: %s', 'toolbar-extras-oxygen' ),
						$current
					);
					echo '<br />';
					echo sprintf(
						/* translators: %s - a Dashicons CSS class name */
						__( 'Default: %s', 'toolbar-extras-oxygen' ),
						'<code><span class="dashicons-before dashicons-welcome-widgets-menus"></span> dashicons-welcome-widgets-menus</code>'
					);
				?>
			</p>
		</label>
	<?php

}  // end function


/**
 * Setting (Number): Original Oxygen Item Priority
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_explanation_toolbar_structure()
 */
function ddw_tbexob_settings_cb_oxygen_tl_priority() {

	$tbex_options = get_option( 'tbex-options-oxygen' );

	?>
		<input type="number" class="small-text tbex-input" id="tbex-options-oxygen-oxygen_tl_priority" name="tbex-options-oxygen[oxygen_tl_priority]" value="<?php echo absint( $tbex_options[ 'oxygen_tl_priority' ] ); ?>" step="1" min="0" />
		<label for="tbex-options-oxygen[oxygen_tl_priority]">
			<span class="description"><?php echo sprintf( __( 'Default: %s', 'toolbar-extras-oxygen' ), '<code>1000</code>' ); ?></span>
		</label>
		<p class="description tbex-align-middle">
			<?php _e( 'The default value means display at far right of the left Toolbar section/ column.', 'toolbar-extras-oxygen' ); ?> <?php _e( 'The smaller the value gets the more on the left the item will be displayed.', 'toolbar-extras-oxygen' ); ?> <?php ddw_tbex_explanation_toolbar_structure(); ?>
		</p>
	<?php

}  // end function


/**
 * Setting (Select): Original Oxygen Item Parent
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 */
function ddw_tbexob_settings_cb_oxygen_tl_parent() {

	$tbexob_options = get_option( 'tbex-options-oxygen' );

	?>
		<select name="tbex-options-oxygen[oxygen_tl_parent]" id="tbex-options-oxygen-oxygen_tl_parent">
			<option value="left" <?php selected( sanitize_key( $tbexob_options[ 'oxygen_tl_parent' ] ), 'left' ); ?>><?php _e( 'Keep on left side', 'toolbar-extras-oxygen' ); ?></option>
			<option value="right" <?php selected( sanitize_key( $tbexob_options[ 'oxygen_tl_parent' ] ), 'right' ); ?>><?php _e( 'Move to the right side', 'toolbar-extras-oxygen' ); ?></option>
		</select>
		<label for="tbex-options-oxygen[oxygen_tl_parent]">
			<span class="description"><?php echo sprintf( __( 'Default: %s', 'toolbar-extras-oxygen' ), '<code>' . __( 'Keep on left side', 'toolbar-extras-oxygen' ) . '</code>' ); ?></span>
		</label>
	<?php

}  // end function


/**
 * Setting (Select): Display row actions?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 */
function ddw_tbexob_settings_cb_oxygen_row_actions() {

	$tbexob_options = get_option( 'tbex-options-oxygen' );

	?>
		<select name="tbex-options-oxygen[oxygen_row_actions]" id="tbex-options-oxygen-oxygen_row_actions">
			<option value="yes" <?php selected( sanitize_key( $tbexob_options[ 'oxygen_row_actions' ] ), 'yes' ); ?>><?php ddw_tbex_string_yes( 'echo' ); ?></option>
			<option value="no" <?php selected( sanitize_key( $tbexob_options[ 'oxygen_row_actions' ] ), 'no' ); ?>><?php ddw_tbex_string_no( 'echo' ); ?></option>
		</select>
		<label for="tbex-options-oxygen[oxygen_row_actions]">
			<span class="description"><?php echo sprintf( __( 'Default: %s', 'toolbar-extras-oxygen' ), ddw_tbex_string_yes( 'return', 'code' ) ); ?></span>
		</label>
		<p class="description">
			<?php echo sprintf(
				/* translators: %s - label, "Action Link" */
				__( 'This %s will be added to any post type item that has Oxygen support and contains at least one Oxygen element already (means it was edited in Oxygen).', 'toolbar-extras-oxygen' ),
				__( 'Action Link', 'toolbar-extras-oxygen' )
			); ?>
		</p>
	<?php

}  // end function


/**
 * Setting (Select): Display post state?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 */
function ddw_tbexob_settings_cb_oxygen_post_state() {

	$tbexob_options = get_option( 'tbex-options-oxygen' );

	?>
		<select name="tbex-options-oxygen[oxygen_post_state]" id="tbex-options-oxygen-oxygen_post_state">
			<option value="yes" <?php selected( sanitize_key( $tbexob_options[ 'oxygen_post_state' ] ), 'yes' ); ?>><?php ddw_tbex_string_yes( 'echo' ); ?></option>
			<option value="no" <?php selected( sanitize_key( $tbexob_options[ 'oxygen_post_state' ] ), 'no' ); ?>><?php ddw_tbex_string_no( 'echo' ); ?></option>
		</select>
		<label for="tbex-options-oxygen[oxygen_post_state]">
			<span class="description"><?php echo sprintf( __( 'Default: %s', 'toolbar-extras-oxygen' ), ddw_tbex_string_yes( 'return', 'code' ) ); ?></span>
		</label>
		<p class="description">
			<?php echo sprintf(
				/* translators: %s - label, "Post State label" */
				__( 'This %s will be added to any post type item that has Oxygen support and contains at least one Oxygen element already (means it was edited in Oxygen).', 'toolbar-extras-oxygen' ),
				__( 'Post State label', 'toolbar-extras-oxygen' )
			); ?>
		</p>
	<?php

}  // end function


/**
 * Setting (Color Picker): Post state label color
 *
 * @since 1.0.0
 */
function ddw_tbexob_settings_cb_oxygen_post_state_color() {

	$tbex_options = get_option( 'tbex-options-oxygen' );

	?>
		<input type="text" class="tbex-color-picker tbex-input" id="tbex-options-oxygen-oxygen_post_state_color" name="tbex-options-oxygen[oxygen_post_state_color]" value="<?php echo sanitize_hex_color( $tbex_options[ 'oxygen_post_state_color' ] ); ?>" data-default-color="#7046db" />
		<?php
			do_action( 'tbex_settings_color_picker_items' );
		?>
	<?php

}  // end function


/**
 * 2nd section: Builder interface:
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

/**
 * Setting (Select): Enable additional BtWP links?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 */
function ddw_tbexob_settings_cb_oxygen_btwp_links() {

	$tbexob_options = get_option( 'tbex-options-oxygen' );

	?>
		<select name="tbex-options-oxygen[oxygen_btwp_links]" id="tbex-options-oxygen-oxygen_btwp_links">
			<option value="yes" <?php selected( sanitize_key( $tbexob_options[ 'oxygen_btwp_links' ] ), 'yes' ); ?>><?php ddw_tbex_string_yes( 'echo' ); ?></option>
			<option value="no" <?php selected( sanitize_key( $tbexob_options[ 'oxygen_btwp_links' ] ), 'no' ); ?>><?php ddw_tbex_string_no( 'echo' ); ?></option>
		</select>
		<label for="tbex-options-oxygen[oxygen_btwp_links]">
			<span class="description"><?php echo sprintf( __( 'Default: %s', 'toolbar-extras-oxygen' ), ddw_tbex_string_yes( 'return', 'code' ) ); ?></span>
		</label>
		<p class="description">
			<?php _e( 'By default this will add quick jump links to Oxygen Templates overview, plus the regular WordPress pages overview. If WooCommerce is active and/or the Oxygen User Elements Library, then those links are added as well.', 'toolbar-extras-oxygen' ); ?>
		</p>
	<?php

}  // end function


/**
 * Setting (Select): BtWP links _blank target?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 * @uses ddw_tbex_string_link_target_description()
 */
function ddw_tbexob_settings_cb_oxygen_btwp_links_blank() {

	$tbexob_options = get_option( 'tbex-options-oxygen' );

	?>
		<select name="tbex-options-oxygen[oxygen_btwp_links_blank]" id="tbex-options-oxygen-oxygen_btwp_links_blank">
			<option value="yes" <?php selected( sanitize_key( $tbexob_options[ 'oxygen_btwp_links_blank' ] ), 'yes' ); ?>><?php ddw_tbex_string_yes( 'echo' ); ?></option>
			<option value="no" <?php selected( sanitize_key( $tbexob_options[ 'oxygen_btwp_links_blank' ] ), 'no' ); ?>><?php ddw_tbex_string_no( 'echo' ); ?></option>
		</select>
		<label for="tbex-options-oxygen[oxygen_btwp_links_blank]">
			<span class="description"><?php echo sprintf( __( 'Default: %s', 'toolbar-extras-oxygen' ), ddw_tbex_string_yes( 'return', 'code' ) ); ?></span>
		</label>
		<p class="description">
			<?php ddw_tbex_string_link_target_description(); ?>
		</p>
		<p class="description">
			<?php echo sprintf(
				/* translators: %s - label, "Back to WP" */
				__( 'This also affects the existing links in the %s section if the above would be disabled.', 'toolbar-extras-oxygen' ),
				ddw_tbexob_string_backtowp()
			); ?>
		</p>
	<?php

}  // end function


/**
 * 3rd section: Tweaks:
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

/**
 * Setting (Select): Remove "Themes" Submenu?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 */
function ddw_tbexob_settings_cb_remove_submenu_themes() {

	$tbexob_options = get_option( 'tbex-options-oxygen' );

	?>
		<select name="tbex-options-oxygen[remove_submenu_themes]" id="tbex-options-oxygen-remove_submenu_themes">
			<option value="yes" <?php selected( sanitize_key( $tbexob_options[ 'remove_submenu_themes' ] ), 'yes' ); ?>><?php ddw_tbex_string_yes( 'echo' ); ?></option>
			<option value="no" <?php selected( sanitize_key( $tbexob_options[ 'remove_submenu_themes' ] ), 'no' ); ?>><?php ddw_tbex_string_no( 'echo' ); ?></option>
		</select>
		<label for="tbex-options-oxygen[remove_submenu_themes]">
			<span class="description"><?php echo sprintf( __( 'Default: %s', 'toolbar-extras-oxygen' ), ddw_tbex_string_yes( 'return', 'code' ) ); ?></span>
		</label>
		<p class="description">
			<?php _e( 'As Oxygen Builder replaces the theme completely it is not needed any longer, therefore the whole submenu for it makes no real sense.', 'toolbar-extras-oxygen' ); ?>
		</p>
	<?php

}  // end function


/**
 * Setting (Select): Remove "Customizer" Submenu?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 */
function ddw_tbexob_settings_cb_remove_submenu_customizer() {

	$tbexob_options = get_option( 'tbex-options-oxygen' );

	?>
		<select name="tbex-options-oxygen[remove_submenu_customizer]" id="tbex-options-oxygen-remove_submenu_customizer">
			<option value="yes" <?php selected( sanitize_key( $tbexob_options[ 'remove_submenu_customizer' ] ), 'yes' ); ?>><?php ddw_tbex_string_yes( 'echo' ); ?></option>
			<option value="no" <?php selected( sanitize_key( $tbexob_options[ 'remove_submenu_customizer' ] ), 'no' ); ?>><?php ddw_tbex_string_no( 'echo' ); ?></option>
		</select>
		<label for="tbex-options-oxygen[remove_submenu_customizer]">
			<span class="description"><?php echo sprintf( __( 'Default: %s', 'toolbar-extras-oxygen' ), ddw_tbex_string_no( 'return', 'code' ) ); ?></span>
		</label>
		<p class="description">
			<?php _e( 'As Oxygen Builder does not need a theme it also is not dependend on the Customizer as well. Therefore you are free to remove its submenu item as well.', 'toolbar-extras-oxygen' ); ?>
		</p>
	<?php

}  // end function


/**
 * Setting (Select): Remove "Theme Editor" Submenu?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 */
function ddw_tbexob_settings_cb_remove_theme_editor() {

	$tbexob_options = get_option( 'tbex-options-oxygen' );

	?>
		<select name="tbex-options-oxygen[remove_theme_editor]" id="tbex-options-oxygen-remove_theme_editor">
			<option value="yes" <?php selected( sanitize_key( $tbexob_options[ 'remove_theme_editor' ] ), 'yes' ); ?>><?php ddw_tbex_string_yes( 'echo' ); ?></option>
			<option value="no" <?php selected( sanitize_key( $tbexob_options[ 'remove_theme_editor' ] ), 'no' ); ?>><?php ddw_tbex_string_no( 'echo' ); ?></option>
		</select>
		<label for="tbex-options-oxygen[remove_theme_editor]">
			<span class="description"><?php echo sprintf( __( 'Default: %s', 'toolbar-extras-oxygen' ), ddw_tbex_string_no( 'return', 'code' ) ); ?></span>
		</label>
		<p class="description">
			<?php _e( 'Since Oxygen Builder has no dependency of the theme the Theme Editor submenu, plus the Editor functionality itself, can optionally be removed as well.', 'toolbar-extras-oxygen' ); ?>
		</p>
	<?php

}  // end function


/**
 * Setting (Select): Unload the Oxygen Builder translations?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 */
function ddw_tbexob_settings_cb_unload_td_oxygen() {

	$tbexob_options = get_option( 'tbex-options-oxygen' );

	?>
		<select name="tbex-options-oxygen[unload_td_oxygen]" id="tbex-options-oxygen-unload_td_oxygen">
			<option value="yes" <?php selected( sanitize_key( $tbexob_options[ 'unload_td_oxygen' ] ), 'yes' ); ?>><?php ddw_tbex_string_yes( 'echo' ); ?></option>
			<option value="no" <?php selected( sanitize_key( $tbexob_options[ 'unload_td_oxygen' ] ), 'no' ); ?>><?php ddw_tbex_string_no( 'echo' ); ?></option>
		</select>
		<label for="tbex-options-oxygen[unload_td_oxygen]">
			<span class="description"><?php echo sprintf( __( 'Default: %s', 'toolbar-extras-oxygen' ), ddw_tbex_string_no( 'return', 'code' ) ); ?></span>
		</label>
		<p class="description">
			<?php _e( 'This tweak unloads the translations for Oxygen Builder. So all strings fall back to their English default strings.', 'toolbar-extras-oxygen' ); ?>
		</p>
		<p class="description">
			<?php echo sprintf(
				/* translators: %s - text domain strings, for example 'oxygen' */
				__( 'Effected text domains: %s', 'toolbar-extras-oxygen' ),
				'<code>oxygen</code>'
			); ?>
		</p>
	<?php

}  // end function


/**
 * Setting (Select): Unload the Toolbar Extras for Oxygen Builder translations?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 */
function ddw_tbexob_settings_cb_unload_td_tbexob() {

	$tbexob_options = get_option( 'tbex-options-oxygen' );

	?>
		<select name="tbex-options-oxygen[unload_td_tbexob]" id="tbex-options-oxygen-unload_td_tbexob">
			<option value="yes" <?php selected( sanitize_key( $tbexob_options[ 'unload_td_tbexob' ] ), 'yes' ); ?>><?php ddw_tbex_string_yes( 'echo' ); ?></option>
			<option value="no" <?php selected( sanitize_key( $tbexob_options[ 'unload_td_tbexob' ] ), 'no' ); ?>><?php ddw_tbex_string_no( 'echo' ); ?></option>
		</select>
		<label for="tbex-options-oxygen[unload_td_tbexob]">
			<span class="description"><?php echo sprintf( __( 'Default: %s', 'toolbar-extras-oxygen' ), ddw_tbex_string_no( 'return', 'code' ) ); ?></span>
		</label>
		<p class="description">
			<?php _e( 'This tweak unloads the translations for Toolbar Extras for Oxygen Builder Add-On, so it falls back to the English default strings.', 'toolbar-extras-oxygen' ); ?>
		</p>
		<p class="description">
			<?php echo sprintf(
				/* translators: %s - a text domain string, 'toolbar-extras-oxygen' */
				__( 'Effected text domain: %s', 'toolbar-extras-oxygen' ),
				'<code>toolbar-extras-oxygen</code>'
			); ?>
		</p>
	<?php

}  // end function
