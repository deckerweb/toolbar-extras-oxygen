<?php

// includes/functions-global

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Setting internal plugin helper values.
 *
 * @since 1.0.0
 *
 * @return array $tbexob_info Array of info values.
 */
function ddw_tbexob_info_values() {

	$tbexob_info = array(

		'url_translate'     => 'https://translate.wordpress.org/projects/wp-plugins/toolbar-extras-oxygen',
		'url_wporg_faq'     => 'https://wordpress.org/plugins/toolbar-extras-oxygen/#faq',
		'url_wporg_forum'   => 'https://wordpress.org/support/plugin/toolbar-extras-oxygen',
		'url_wporg_review'  => 'https://wordpress.org/support/plugin/toolbar-extras-oxygen/reviews/?filter=5/#new-post',
		'url_fb_group'      => 'https://www.facebook.com/groups/ToolbarExtras/',
		'url_snippets'      => 'https://gist.github.com/deckerweb',
		'first_code'        => '2019',
		'url_plugin'        => 'https://toolbarextras.com/addon/oxygen-builder/',
		'url_plugin_docs'   => 'https://toolbarextras.com/docs-category/oxygen-builder-addon/',
		'url_plugin_faq'    => 'https://toolbarextras.com/docs-category/faqs/',
		'url_github'        => 'https://github.com/deckerweb/toolbar-extras-oxygen',
		'url_github_issues' => 'https://github.com/deckerweb/toolbar-extras-oxygen/issues',

	);  // end of array

	return $tbexob_info;

}  // end function


/**
 * Helper: URL Meta - Target Tag for "Back to WP" links in Oxygen Builder.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return string URL link target tag.
 */
function ddw_tbexob_btwp_target() {

	$target = ( 'yes' === ddw_tbex_get_option( 'oxygen', 'oxygen_btwp_links_blank' ) ) ? '_blank' : '_self';

	return strtolower(
		esc_attr(
			apply_filters(
				'tbexob/filter/oxygen_builder/btwp_target',
				$target
			)
		)
	);

}  // end function
