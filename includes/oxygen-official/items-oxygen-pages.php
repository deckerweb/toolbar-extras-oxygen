<?php

// includes/oxygen-official/items-oxygen-pages

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * To get filterable hook priority for Pages Group item.
 *   Default: 1000 - that means mostly at the right side of the left Toolbar
 *   "column".
 *
 * @since 1.2.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return int Hook priority for Pages Group item.
 */
function ddw_tbexob_get_pages_group_item_priority() {

	return absint(
		apply_filters(
			'tbexob/filter/oxygen_pages/item_priority',
			ddw_tbex_get_option( 'oxygen', 'display_pages_priority' )	// 1000
		)
	);

}  // end function


add_action( 'admin_head', 'ddw_tbexob_styles_oxygen_logo', 100 );
add_action( 'admin_bar_menu', 'ddw_tbexob_items_pages_group', ddw_tbexob_get_pages_group_item_priority() );
/**
 * Based on settings display additional top-level group for Oxygen editable
 *   Pages (pages post type) in the Toolbar within Admin and on frontend.
 *
 * @since 1.2.0
 *
 * @uses ddw_tbexob_current_user_can_access_oxygen()
 * @uses ddw_tbex_get_option()
 * @uses ddw_tbexob_string_oxygen()
 * @uses ddw_tbex_item_title_with_settings_icon()
 * @uses ddw_tbex_meta_target()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexob_items_pages_group( $admin_bar ) {

	/** Bail early if in Builder context */
	if ( defined( 'SHOW_CT_BUILDER' ) ) {
		return $admin_bar;
	}

	/** Bail early if display not wanted */
	if ( ! ddw_tbexob_current_user_can_access_oxygen()
		|| ! function_exists( 'ct_get_archives_template' )
		|| ! function_exists( 'ct_get_posts_template' )
	) {
		//return $admin_bar;
	}

	/** Parent item & Post type */
	$parent_type = sanitize_key( ddw_tbex_get_option( 'oxygen', 'display_pages_parent' ) );
	$post_type   = 'page';

	/** Which icon type to use */
	$use_icon = ( 'build-group' === $parent_type ) ? 'none' : ddw_tbex_get_option( 'oxygen', 'display_pages_use_icon' );

	$class = '';
	$icon  = '';
	$label = esc_attr_x( 'Pages', 'Toolbar top-level item title', 'toolbar-extras-oxygen' );
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
		$title = ddw_tbex_item_title_with_settings_icon( $label, 'oxygen', 'display_pages_icon' );

	}  // end if

	/** Set main item for listing group */
	$admin_bar->add_node(
		array(
			'id'     => 'tbexob-oxygen-pages',
			'parent' => ( 'top-level' === $parent_type ) ? '' : 'group-creative-content',
			'title'  => $title,
			'href'   => esc_url( admin_url( 'edit.php?post_type=' . $post_type ) ),
			'meta'   => array(
				'class'  => $class,
				'target' => '',		//ddw_tbex_meta_target(),
				'title'  => esc_attr__( 'List of Oxygen-edited WordPress Pages', 'toolbar-extras-oxygen' ),
			)
		)
	);

		/** How many pages to show */
		$count = ddw_tbex_get_option( 'oxygen', 'display_pages_count' );

		/**
		 * Add each individual Page as an item.
		 *   Forms are saved as a post type therefore a query necessary.
		 * @since 1.2.0
		 */
		$args = apply_filters(
			'tbexob/filter/oxygen_pages/group_args',
			array(
				'post_type'      => $post_type,
				'posts_per_page' => intval( $count ),
				'post_status'    => array( 'publish', 'draft', 'private', 'future' ),
				'orderby'        => 'title',
				'order'          => 'ASC',
			)
		);

		$pages = get_posts( $args );

		/** Proceed only if there are any Pages */
		if ( $pages ) {

			/** Add group */
			$admin_bar->add_group(
				array(
					'id'     => 'group-oxygen-edit-pages',
					'parent' => 'tbexob-oxygen-pages',
					'meta'   => array( 'class' => 'oxygen-cptlist-group' ),
				)
			);

			foreach ( $pages as $page ) {

				$page_id   = absint( $page->ID );
				$page_name = esc_attr( $page->post_title );

				if ( get_option( 'page_for_posts' ) === $page_id || get_option( 'page_on_front' ) === $page_id ) {

					$generic_view = ct_get_archives_template( $page_id ); 	// true, for exclude templates of type inner_content

					if ( ! $generic_view ) {  	// if not template is set to apply to front page or blog posts page, then use the generic page template, as these are pages
						$generic_view = ct_get_posts_template( $page_id );
					}

				} else {

					$generic_view = ct_get_posts_template( $page_id ); 	// true, exclude templates of type inner_content

				}  // end if

				$ct_other_template = get_post_meta( $page_id, 'ct_other_template', TRUE );

				// check if the other template contains ct_inner_content
				$shortcodes = FALSE;

				if ( $ct_other_template && $ct_other_template > 0 ) {
					$shortcodes = get_post_meta( $ct_other_template, 'ct_builder_shortcodes', TRUE );
				} elseif ( $generic_view && -1 !== $ct_other_template ) {
					$shortcodes = get_post_meta( $generic_view->ID, 'ct_builder_shortcodes', TRUE );
				}

				/** Set query arg params */
				$query_params = array(
					'ct_builder' => 'true',
				);

				if ( ( $shortcodes && strpos( $shortcodes, '[ct_inner_content') !== false ) && -1 !== intval( $ct_other_template ) ) {

					$query_params = array(
						'ct_builder' => 'true',
						'ct_inner'   => 'true',
					);

				}  // end if

				$builder_edit_url = add_query_arg(
					$query_params,
					get_permalink( $page_id )
				);

				$page_title = sprintf(
					'<span class="oxygen-cptlist-title">%s</span><span class="oxygen-cptlist-status">%s</span>',
					$page_name,
					get_post_status( $page_id )
				);

				/** Add item per page */
				if ( ddw_tbexob_is_builder( $page_id ) ) {

					$admin_bar->add_node(
						array(
							'id'     => 'oxygen-pages-page-' . $page_id,
							'parent' => 'group-oxygen-edit-pages',
							'title'  => $page_title,		// $page_name,
							'href'   => esc_url( $builder_edit_url ),
							'meta'   => array(
								'class'  => 'oxygen-cptlist-item',
								'target' => ddw_tbex_meta_target( 'builder' ),
								'title'  => esc_attr__( 'Edit Page in Oxygen Builder', 'toolbar-extras' ) . ': ' . $page_name,
							)
						)
					);

						$admin_bar->add_node(
							array(
								'id'     => 'oxygen-pages-page-' . $page_id . '-builder',
								'parent' => 'oxygen-pages-page-' . $page_id,
								'title'  => esc_attr__( 'Oxygen Builder', 'toolbar-extras-oxygen' ),
								'href'   => esc_url( $builder_edit_url ),
								'meta'   => array(
									'target' => ddw_tbex_meta_target( 'builder' ),
									'title'  => esc_attr__( 'Edit Page in Oxygen Builder', 'toolbar-extras-oxygen' ),
								)
							)
						);

						$admin_bar->add_node(
							array(
								'id'     => 'oxygen-pages-page-' . $page_id . '-admin',
								'parent' => 'oxygen-pages-page-' . $page_id,
								'title'  => esc_attr__( 'Settings in Admin', 'toolbar-extras-oxygen' ),
								'href'   => esc_url( admin_url( 'post.php?post=' . $page_id . '&action=edit' ) ),
								'meta'   => array(
									'target' => ddw_tbex_meta_target(),
									'title'  => esc_attr__( 'Page Settings in WP-Admin', 'toolbar-extras-oxygen' ),
								)
							)
						);

						$admin_bar->add_node(
							array(
								'id'     => 'oxygen-pages-page-' . $page_id . '-frontend',
								'parent' => 'oxygen-pages-page-' . $page_id,
								'title'  => esc_attr__( 'View on Frontend', 'toolbar-extras-oxygen' ),
								'href'   => esc_url( get_permalink( $page_id ) ),
								'meta'   => array(
									'target' => ddw_tbex_meta_target(),
									'title'  => esc_attr__( 'Page Live View on Frontend', 'toolbar-extras-oxygen' ),
								)
							)
						);

				}  // end if

			}  // end foreach

		}  // end if

}  // end function
