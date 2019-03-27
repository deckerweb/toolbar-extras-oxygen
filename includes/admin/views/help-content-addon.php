<?php

// includes/admin/views/help-content-addon

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * View: Content of the help tab.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_string_backtowp()
 * @uses ddw_tbex_info_values()
 * @uses ddw_tbex_get_info_link()
 */
function ddw_tbexob_help_tab_content() {

	$tbex_info   = (array) ddw_tbex_info_values();

	$tbexob_space_helper = '<div style="height: 10px;"></div>';

	/** Content: Toolbar Extras for Oxygen addon plugin */
	echo '<h3>' . __( 'Add-On', 'toolbar-extras-oxygen' ) . ': ' . __( 'Toolbar Extras for Oxygen', 'toolbar-extras-oxygen' ) . ' <small class="tbexob-help-version">v' . TBEXOB_PLUGIN_VERSION . '</small></h3>';


	/** Oxygen Name */
	echo '<h5>' . __( 'Setting Oxygen Name', 'toolbar-extras-oxygen' ) . '</h5>';
	echo '<p class="tbex-help-info">' . __( 'This affects the Oxygen name in various instances of the Toolbar and the Admin area.', 'toolbar-extras-oxygen' ) . '</p>';


	/** Back to WP Links */
	echo sprintf(
		/* translators: %s - label, "Back to WP" */
		'<h5>' . __( 'What links are added to the %s section?', 'toolbar-extras-oxygen' ) . '</h5>',
		'<em>' . ddw_tbexob_string_backtowp() . '</em>'
	);
	echo '<ul class="tbex-help-info">
    		<li>' . __( 'Oxygen Templates', 'toolbar-extras-oxygen' ) . '</li>
			<li>' . __( 'WordPress Pages', 'toolbar-extras-oxygen' ) . '</li>
			<li>' . __( 'WooCommerce Products (only if plugin active)', 'toolbar-extras-oxygen' ) . '</li>
			<li>' . __( 'Oxygen User Elements Library (only if enabled in Oxygen settings)', 'toolbar-extras-oxygen' ) . '</li>
		</ul>
		<p class="tbex-help-info description">' . __( 'Note: Each of these links always goes to the post type list table, which is the overview table.', 'toolbar-extras-oxygen' ) . '</p>';


	/** Tooltips */
	$links_url = sprintf(
		'<a href="%1$s" target="%3$s" rel="%4$s">%2$s</a>',
		esc_url( admin_url( 'options-general.php?page=toolbar-extras&tab=general#tbex-settings-link-behavior' ) ),
		__( 'Settings > Toolbar Extras > Tab: General > Section: Links Behavior', 'toolbar-extras-oxygen' ),
		ddw_tbex_meta_target(),
		ddw_tbex_meta_rel()
	);

	echo '<h5>' . __( 'How can I disable the link attributes (tooltips)?', 'toolbar-extras-oxygen' ) . '</h5>';
	echo sprintf(
		'<p class="tbex-help-info"><strong>%1$s:</strong> <code style="font-size: 90%;">%2$s</code></p>',
		__( 'Go to', 'toolbar-extras-oxygen' ),
		$links_url
	);
	echo sprintf(
		/* translators: %s - label, "Back to WP" */
		'<p class="tbex-help-info description">' . __( 'Important note, this setting also applies to the %s section in Oxygen Builder interface itself.', 'toolbar-extras-oxygen' ) . '</p>',
		'<em class="noitalic">' . ddw_tbexob_string_backtowp() . '</em>'
	);


	/** Support notice */
	echo '<h5>' . __( 'Add-On Support Info', 'toolbar-extras-oxygen' ) . '</h5>';
	echo sprintf(
		/* translators: %1$s - plugin name, "Toolbar Extras for Oxygen Builder" / %2$s - company name, "Oxygen/ Soflyy" / %3$s - product name, "Oxygen Builder" */
		'<p class="tbex-help-info description">' . __( 'Please note, the %1$s Add-On plugin is not officially endorsed by %2$s. It is an independently developed solution by the community for the community. Therefore our support is connected to the Add-On itself, to the Toolbar and the things around it, not the inner meanings of %3$s.', 'toolbar-extras-oxygen' ) . '</p>',
		'<span class="noitalic">' . __( 'Toolbar Extras for Oxygen Builder', 'toolbar-extras-oxygen' ) . '</span>',
		'<span class="noitalic">' . __( 'Oxygen/ Soflyy', 'toolbar-extras-oxygen' ) . '</span>',
		'<span class="noitalic">' . __( 'Oxygen Builder', 'toolbar-extras-oxygen' ) . '</span>'
	);


	/** Further help content */
	echo $tbexob_space_helper . '<p><h4 style="font-size: 1.1em;">' . __( 'Important plugin links:', 'toolbar-extras-oxygen' ) . '</h4>' .

		ddw_tbex_get_info_link( 'url_plugin', esc_html__( 'Plugin website', 'toolbar-extras-oxygen' ), 'button', 'oxygen' ) .

		'&nbsp;&nbsp;' . ddw_tbex_get_info_link( 'url_plugin_faq', esc_html_x( 'FAQ', 'Help tab info', 'toolbar-extras-oxygen' ), 'button', 'oxygen' ) .

		'&nbsp;&nbsp;' . ddw_tbex_get_info_link( 'url_wporg_forum', esc_html_x( 'Support', 'Help tab info', 'toolbar-extras-oxygen' ), 'button', 'oxygen' ) .

		'&nbsp;&nbsp;' . ddw_tbex_get_info_link( 'url_fb_group', esc_html_x( 'Facebook Group', 'Help tab info', 'toolbar-extras-oxygen' ), 'button' ) .

		'&nbsp;&nbsp;' . ddw_tbex_get_info_link( 'url_translate', esc_html_x( 'Translations', 'Help tab info', 'toolbar-extras-oxygen' ), 'button', 'oxygen' ) .

		'&nbsp;&nbsp;' . ddw_tbex_get_info_link( 'url_donate', esc_html_x( 'Donate', 'Help tab info', 'toolbar-extras-oxygen' ), 'button tbex' ) .

		'&nbsp;&nbsp;' . ddw_tbex_get_info_link( 'url_newsletter', esc_html_x( 'Join our Newsletter', 'Help tab info', 'toolbar-extras-oxygen' ), 'button button-primary tbex' ) .

		sprintf(
			'<p><a href="%1$s" target="_blank" rel="nofollow noopener noreferrer" title="%2$s">%2$s</a> &#x000A9; %3$s <a href="%4$s" target="_blank" rel="noopener noreferrer" title="%5$s">%5$s</a></p>',
			ddw_tbex_get_info_url( 'url_license' ),
			esc_attr( $tbex_info[ 'license' ] ),
			ddw_tbex_coding_years( '', 'oxygen' ),
			esc_url( $tbex_info[ 'author_uri' ] ),
			esc_html( $tbex_info[ 'author' ] )
		);

}  // end function
