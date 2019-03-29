<?php # -*- coding: utf-8 -*-
/**
 * Main plugin file.
 * @package           Toolbar Extras for Oxygen Builder
 * @author            David Decker
 * @copyright         Copyright (c) 2019, David Decker - DECKERWEB
 * @license           GPL-2.0-or-later
 * @link              https://deckerweb.de/twitter
 * @link              https://www.facebook.com/groups/ToolbarExtras/
 *
 * @wordpress-plugin
 * Plugin Name:       Toolbar Extras for Oxygen Builder
 * Plugin URI:        https://toolbarextras.com/
 * Description:       A Toolbar Extras Add-On to enhance your workflow with the amazing Oxygen Builder and the WordPress Toolbar (Admin Bar). Also comes with some very useful and smart Oxygen tweaks.
 * Version:           1.0.0
 * Author:            David Decker - DECKERWEB
 * Author URI:        https://toolbarextras.com/
 * License:           GPL-2.0-or-later
 * License URI:       https://opensource.org/licenses/GPL-2.0
 * Text Domain:       toolbar-extras-oxygen
 * Domain Path:       /languages/
 * Requires WP:       4.7
 * Requires PHP:      5.6
 * GitHub Plugin URI: https://github.com/deckerweb/toolbar-extras-oxygen
 * GitHub Branch:     master
 *
 * Copyright (c) 2019 David Decker - DECKERWEB
 */

/**
 * Exit if called directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Setting constants.
 *
 * @since 1.0.0
 */
/** Plugin version */
define( 'TBEXOB_PLUGIN_VERSION', '1.0.0' );

/** Plugin directory */
define( 'TBEXOB_PLUGIN_DIR', trailingslashit( dirname( __FILE__ ) ) );

/** Plugin base directory */
define( 'TBEXOB_PLUGIN_BASEDIR', trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) );

/** Plugin base URL */
define( 'TBEXOB_PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );


add_action( 'init', 'ddw_tbexob_load_translations', 1 );
/**
 * Load the text domain for translation of the plugin.
 *
 * @since 1.0.0
 *
 * @uses get_user_locale()
 * @uses load_textdomain() To load translations first from WP_LANG_DIR sub folder.
 * @uses load_plugin_textdomain() To additionally load default translations from plugin folder (default).
 */
function ddw_tbexob_load_translations() {

	/** Set unique textdomain string */
	$tbexob_textdomain = 'toolbar-extras-oxygen';

	/**
	 * The 'plugin_locale' filter is also used by default in
	 *   load_plugin_textdomain()
	 */
	$locale = esc_attr(
		apply_filters(
			'plugin_locale',
			get_user_locale(),
			$tbexob_textdomain
		)
	);

	/**
	 * WordPress languages directory
	 *   Will default to:
	 *   wp-content/languages/toolbar-extras-oxygen/toolbar-extras-oxygen-{locale}.mo
	 */
	$tbexob_wp_lang_dir = trailingslashit( WP_LANG_DIR ) . trailingslashit( $tbexob_textdomain ) . $tbexob_textdomain . '-' . $locale . '.mo';

	/**
	 * Translations: Firstly, look in WordPress' "languages" folder = custom and
	 *   update-safe!
	 */
	load_textdomain(
		$tbexob_textdomain,
		$tbexob_wp_lang_dir
	);

	/**
	 * Translations: Secondly, look in 'wp-content/languages/plugins/' for the
	 *   proper .mo file (= default)
	 */
	load_plugin_textdomain(
		$tbexob_textdomain,
		FALSE,
		TBEXOB_PLUGIN_BASEDIR . 'languages'
	);

}  // end function


/**
 * Check for a plugin path if plugin is installed.
 *
 * @since 1.0.0
 *
 * @uses get_plugins()
 *
 * @param string $plugin Unique handle of plugin to check for.
 * @return bool TRUE if checked plugin is in the list of installed plugins,
 *              FALSE otherwise.
 */
function ddw_tbexob_is_plugin_installed( $plugin = '' ) {

	$file_path = '';

	if ( 'tbex' === sanitize_key( $plugin ) ) {
		$file_path = 'toolbar-extras/toolbar-extras.php';
	}

	if ( 'oxygen' === sanitize_key( $plugin ) ) {
		$file_path = 'oxygen/functions.php';
	}

	$installed_plugins = get_plugins();

	return isset( $installed_plugins[ $file_path ] );

}  // end function


add_action( 'plugins_loaded', 'ddw_tbexob_check_plugin_enviroment' );
/**
 * Check the environment for required base plugin Toolbar Extras (available for
 *   free on the official plugin directory at WordPress.org).
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_load_translations()
 */
function ddw_tbexob_check_plugin_enviroment() {

	/** Load translations first. Just to be sure. */
	ddw_tbexob_load_translations();

	/** 1st case: Plugin is not installed or not activated yet */
	if ( ! defined( 'TBEX_PLUGIN_VERSION' ) ) {

		add_action( 'admin_notices', 'ddw_tbexob_activation_missing_toolbar_extras' );
		return;

	}  // end if

	/** 2nd case: Plugin is installed & active but needs an update */
	$tbex_version_required = '1.4.1';

	if ( version_compare( TBEX_PLUGIN_VERSION, $tbex_version_required, '<' ) ) {

		add_action( 'admin_notices', 'ddw_tbexob_activation_needs_update_toolbar_extras' );
		return;

	}  // end if

}  // end function


/**
 * Styling tweak for our admin notices.
 *
 * @since 1.0.0
 *
 * @return string Echoing inline CSS styles.
 */
function ddw_tbexob_activation_style_tweaks() {

	?>
		<style type="text/css">
			.tbexob-notice .dashicons-before:before {
				clear: left;
				color: #f15959;
				display: block;
				float: left;
				font-size: 60px;
				padding: 5px 60px 5px 10px;
			}
			.tbex-notice-button {
				display: inline-block;
				font-weight: 500;
			}
		</style>
	<?php

}  // end function


/**
 * Activation Logic: Show an admin (error) notice if the Toolbar Extras plugin
 *   is either not installed or not activated yet.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_is_plugin_installed()
 *
 * @return string Echoing markup and string of admin notice message.
 */
function ddw_tbexob_activation_missing_toolbar_extras() {

	/** Bail early if in Network Admin in Multisite */
	if ( is_network_admin() ) {
		return;
	}

	/** Avoid doublicated notices on plugin update screen */
	$screen = get_current_screen();

	if ( isset( $screen->parent_file )
		&& 'plugins.php' === $screen->parent_file
		&& 'update' === $screen->id
	) {
		return;
	}

	/** Set main file path of base plugin */
	$plugin = 'toolbar-extras/toolbar-extras.php';
	$slug   = 'toolbar-extras';

	if ( ddw_tbexob_is_plugin_installed( 'tbex' ) ) {

		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$activation_link = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );

		$message = sprintf(
			'<p class="dashicons-before dashicons-info">' . __( 'The needed base plugin %s is already installed but not activated. (Toolbar Extras for Oxygen Builder is an Add-On plugin which DEPENDS on Toolbar Extras.)', 'toolbar-extras-oxygen' ) . '</p>',
			'<strong>' . esc_html__( 'Toolbar Extras', 'toolbar-extras-oxygen' ) . '</strong>'
		);
		$message .= sprintf(
			'<p class="tbex-notice-button"><a href="%s" class="button-primary">&rarr; %s</a></p>',
			$activation_link,
			esc_html__( 'Activate Toolbar Extras Now', 'toolbar-extras-oxygen' )
		);

	} else {

		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		$install_link = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=toolbar-extras' ), 'install-plugin_toolbar-extras' );

		$message = sprintf(
			'<p class="dashicons-before dashicons-info">' . __( 'Toolbar Extras for Oxygen Builder is an Add-On plugin which DEPENDS on the (free) %s plugin in version 1.4.2 or higher to be installed and activated.', 'toolbar-extras-oxygen' ) . '</p>',
			'<strong>' . esc_html__( 'Toolbar Extras', 'toolbar-extras-oxygen' ) . '</strong>'
		);
		$message .= sprintf(
			'<p class="tbex-notice-button"><a href="%s" class="button-primary">&rarr; %s</a></p>',
			$install_link,
			esc_html__( 'Install Toolbar Extras Now', 'toolbar-extras-oxygen' )
		);

	}  // end if

	/** Setup HTML notice message and echo it */
	$html_message = sprintf(
		'<div class="notice error is-dismissible tbexob-notice">%s</div>',
		wpautop( $message )
	);

	ddw_tbexob_activation_style_tweaks();

	echo wp_kses_post( $html_message );

}  // end function


/**
 * Activation Logic: Show an admin (error) notice if the Toolbar Extras plugin
 *   is active but still on an older version (below v1.4.0).
 *
 * @since 1.0.0
 *
 * @return string Echoing markup and string of admin notice message.
 */
function ddw_tbexob_activation_needs_update_toolbar_extras() {

	/** Bail early if current user cannot update plugins */
	if ( ! current_user_can( 'update_plugins' ) ) {
		return;
	}

	/** Set main file path of base plugin */
	$file_path = 'toolbar-extras/toolbar-extras.php';

	$upgrade_link = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file_path, 'upgrade-plugin_' . $file_path );

	$message = sprintf(
		'<p class="dashicons-before dashicons-info">' . __( 'Toolbar Extras for Oxygen Builder is not working yet because you are using an old version of the base plugin %s.', 'toolbar-extras-oxygen' ) . '</p>',
		'<strong>' . esc_html__( 'Toolbar Extras', 'toolbar-extras-oxygen' ) . '</strong>'
	);
	$message .= sprintf(
		'<p class="tbex-notice-button"><a href="%s" class="button-primary">&rarr; %s</a></p>',
		$upgrade_link,
		esc_html__( 'Update Toolbar Extras Now', 'toolbar-extras-oxygen' )
	);

	/** Setup HTML notice message and echo it */
	$html_message = sprintf(
		'<div class="notice error is-dismissible tbexob-notice">%s</div>',
		wpautop( $message )
	);

	ddw_tbexob_activation_style_tweaks();

	echo wp_kses_post( $html_message );

}  // end function


/** Include global functions */
require_once TBEXOB_PLUGIN_DIR . 'includes/functions-global.php';

/** Include (global) conditionals functions */
require_once TBEXOB_PLUGIN_DIR . 'includes/functions-conditionals.php';

/** Include string functions */
require_once TBEXOB_PLUGIN_DIR . 'includes/string-switcher.php';


/**
 * Steps of the plugin activation routine.
 *
 * @since 1.0.0
 *
 * @see includes/admin/tbexob-settings.php
 *
 * @uses ddw_tbexob_register_settings_oxygen()
 */
function ddw_tbexob_addon_activation_routine() {

	/** Bail early if permissions are not in place */
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	/**
	 * During run of the activation hook no other hooks and functions are
	 *   available, so we need to load them temporarily.
	 * @link https://premium.wpmudev.org/blog/activate-deactivate-uninstall-hooks/
	 */
	ddw_tbexob_load_translations();
	require_once TBEXOB_PLUGIN_DIR . 'includes/admin/tbexob-settings.php';

	/** Register our settings and save the defaults */
	ddw_tbexob_register_settings_oxygen();

}  // end function


register_activation_hook( __FILE__, 'ddw_tbexob_run_addon_activation', 10, 1 );
/**
 * On plugin activation register the plugin's options and save their defaults.
 *
 * @since 1.0.0
 *
 * @link https://leaves-and-love.net/blog/making-plugin-multisite-compatible/
 *
 * @uses ddw_tbexob_addon_activation_routine()
 */
function ddw_tbexob_run_addon_activation( $network_wide ) {

	/** 1st case: Network-wide activation in a Multisite Network */
    if ( is_multisite() && $network_wide ) {

    	$site_ids = get_sites( array( 'fields' => 'ids', 'network_id' => get_current_network_id() ) );

        foreach ( $site_ids as $site_id ) {

        	/** Run Site after Site */
            switch_to_blog( $site_id );

            ddw_tbexob_addon_activation_routine();

            restore_current_blog();

        }  // end foreach

    }

    /** 2nd case: Activation on a regular single site install */
    else {

        ddw_tbexob_addon_activation_routine();

    }  // end if

}  // end function


add_action( 'wpmu_new_blog', 'ddw_tbexob_network_new_site_run_addon_activation', 10, 6 );
/**
 * When creating a new Site within a Multisite Network run the plugin activation
 *   routine - if Toolbar Extras is activated Network-wide.
 *   Note: The 'wpmu_new_blog' hook fires only in Multisite.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_addon_activation_routine()
 */
function ddw_tbexob_network_new_site_run_addon_activation( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {

    if ( is_plugin_active_for_network( TBEX_PLUGIN_BASEDIR . 'toolbar-extras.php' )					// base plugin
    	&& is_plugin_active_for_network( TBEXOB_PLUGIN_BASEDIR . 'toolbar-extras-oxygen.php' )		// add-on plugin
	) {

        switch_to_blog( $blog_id );

        ddw_tbexob_addon_activation_routine();

        restore_current_blog();

    }  // end if

}  // end function


add_action( 'plugins_loaded', 'ddw_tbexob_setup_plugin', 50 );
/**
 * Finally setup the plugin for the main tasks.
 *   Note: The setup fires after all activation checks and routines.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_is_toolbar_extras_active()
 * @uses ddw_tbexob_is_oxygen_active()
 */
function ddw_tbexob_setup_plugin() {

	/** Bail early if no TBEX */
	if ( ! ddw_tbexob_is_toolbar_extras_active() ) {
		return;
	}

	/** Include admin helper functions */
	if ( is_admin() ) {

		if ( ddw_tbexob_is_toolbar_extras_active()
			&& version_compare( TBEX_PLUGIN_VERSION, '1.4.1', '>=' )
		) {
			require_once TBEXOB_PLUGIN_DIR . 'includes/plugin-manager.php';
		}

		require_once TBEXOB_PLUGIN_DIR . 'includes/admin/admin-help.php';
		require_once TBEXOB_PLUGIN_DIR . 'includes/admin/admin-extras.php';

	}  // end if

	/** Load plugin's settings */
	require_once TBEXOB_PLUGIN_DIR . 'includes/admin/tbexob-settings.php';

	/** Include items for Oxygen Builder plugin support */
	if ( ddw_tbexob_is_oxygen_active() ) {

		/** Include basic/core stuff for free Elementor plugin */
		if ( ! defined( 'SHOW_CT_BUILDER' ) ) {
			require_once TBEXOB_PLUGIN_DIR . 'includes/oxygen-official/oxygen-resources.php';
			require_once TBEXOB_PLUGIN_DIR . 'includes/oxygen-official/items-oxygen-core.php';
		}
		require_once TBEXOB_PLUGIN_DIR . 'includes/tweaks.php';

	}  // end if

	/** Conditionally load items for Oxygen-specific Add-On plugins */
	if ( ddw_tbex_display_items_addons() && ddw_tbexob_is_oxygen_active() ) {
		require_once TBEXOB_PLUGIN_DIR . 'includes/items-plugins-oxygen-addons.php';
	}

	/** Add links to Settings and Menu pages to Plugins page */
	if ( ( is_admin() || is_network_admin() )
		&& ( current_user_can( 'manage_options' ) )
	) {

		add_filter(
			'plugin_action_links_' . plugin_basename( __FILE__ ),
			'ddw_tbexob_custom_settings_links'
		);

		add_filter(
			'network_admin_plugin_action_links_' . plugin_basename( __FILE__ ),
			'ddw_tbexob_custom_settings_links'
		);

	}  // end if

}  // end function


add_filter( 'tbex_filter_unloading_textdomains', 'ddw_tbexob_tweak_unload_textdomain_toolbar_extras_oxygen' );
/**
 * Unload Textdomain for "Toolbar Extras for Oxygen Builder" plugin.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_use_tweak_unload_translations_tbexob()
 *
 * @param array $textdomains Array of textdomains.
 * @return array Modified array of textdomains for unloading.
 */
function ddw_tbexob_tweak_unload_textdomain_toolbar_extras_oxygen( $textdomains ) {

	/** Bail early if tweak shouldn't be used */
	if ( ! ddw_tbexob_use_tweak_unload_translations_tbexob() ) {
		return $textdomains;
	}

	$tbexob_domains = array( 'toolbar-extras-oxygen' );

	return array_merge( $textdomains, $tbexob_domains );

}  // end function
