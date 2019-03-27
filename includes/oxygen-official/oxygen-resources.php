<?php

// includes/oxygen-official/oxygen-resources

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Collection of external resource links for Elementor (Pro).
 *   Note: This is the central place where to set/ change these links. They are
 *   then managed for displaying and using via ddw_tbex_get_resource_url().
 *
 * @since 1.0.0
 *
 * @see ddw_tbex_get_resource_url() in toolbar-extras/includes/functions-global.php
 *
 * @return array $oxygen_links Array of external resource links.
 */
function ddw_tbexob_resources_oxygen() {

	$oxygen_links = array(

		/** Official */
		'url_docs'             => 'https://oxygenbuilder.com/documentation/',
		'url_tutorials'        => 'https://oxygenbuilder.com/documentation/getting-started/getting-started-tutorial/',
		'url_support_contact'  => 'https://oxygenbuilder.com/support/',
		'url_github_issues'    => 'https://github.com/soflyy/oxygen-bugs-and-features/issues',
		'url_blog'             => 'https://oxygenbuilder.com/blog',
		'url_videos'           => 'https://www.youtube.com/c/OxygenBuilder',
		'url_fb_group'         => 'https://www.facebook.com/groups/1626639680763454/',
		'url_myaccount'        => 'https://oxygenbuilder.com/portal/',

		/** Community */
		'url_community'        => 'https://oxygenbuilder.com/forums/',
		'url_slack_chat'       => 'https://oxygenusers.slack.com/',
		'url_trello_resources' => 'https://trello.com/b/t048TPPM/oxygen-builder-resources',
		'url_blog_wpdd'        => 'https://wpdevdesign.com/',
		'url_blog_supa'        => 'https://oxygen4fun.supadezign.com',

	);  // end of array

	return $oxygen_links;

}  // end function
