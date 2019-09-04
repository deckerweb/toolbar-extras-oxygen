<?php

// includes/oxygen-official/items-oxygen-templates

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * To get filterable hook priority for Templates Group item.
 *   Default: 1000 - that means mostly at the right side of the left Toolbar
 *   "column".
 *
 * @since 1.2.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return int Hook priority for Template Group item.
 */
function ddw_tbexob_get_template_group_item_priority() {

	return absint(
		apply_filters(
			'tbexob/filter/oxygen_templates/item_priority',
			ddw_tbex_get_option( 'oxygen', 'display_tpl_priority' )	// 1000
		)
	);

}  // end function


add_action( 'admin_head', 'ddw_tbexob_styles_oxygen_logo', 100 );
add_action( 'admin_bar_menu', 'ddw_tbexob_items_template_group', ddw_tbexob_get_template_group_item_priority() );
/**
 * Based on settings display additional top-level group for Oxygen Templates
 *   (templates post type) in the Toolbar within Admin and on frontend.
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
function ddw_tbexob_items_template_group( $admin_bar ) {

	/** Bail early if in Builder context */
	if ( defined( 'SHOW_CT_BUILDER' ) ) {
		return $admin_bar;
	}

	/** Bail early if display not wanted */
	if ( ! ddw_tbexob_current_user_can_access_oxygen() ) {
		//return $admin_bar;
	}

	/** Parent item & Post type */
	$parent_type = sanitize_key( ddw_tbex_get_option( 'oxygen', 'display_tpl_parent' ) );
	$post_type   = 'ct_template';

	/** Which icon type to use */
	$use_icon = ( 'build-group' === $parent_type ) ? 'none' : ddw_tbex_get_option( 'oxygen', 'display_tpl_use_icon' );

	$class = '';
	$icon  = '';
	$label = esc_attr_x( 'Templates', 'Toolbar top-level item title', 'toolbar-extras-oxygen' );
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
		$title = ddw_tbex_item_title_with_settings_icon( $label, 'oxygen', 'display_tpl_icon' );

	}  // end if

	$title_attr = sprintf(
		/* translators: %s - Word "Oxygen" */
		esc_attr__( 'List of %s Builder Templates (published status only)', 'toolbar-extras-oxygen' ),
		ddw_tbexob_string_oxygen()
	);

	/** Optionally, set main item for listing group */
	if ( 'build-group' !== $parent_type ) {

		$admin_bar->add_node(
			array(
				'id'     => 'tbexob-oxygen-templates',
				'parent' => '',
				'title'  => $title,
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $post_type ) ),
				'meta'   => array(
					'class'  => $class,
					'target' => '',		//ddw_tbex_meta_target(),
					'title'  => $title_attr,
				)
			)
		);

	}  // end if

		/** How many templates to show */
		$count = ddw_tbex_get_option( 'oxygen', 'display_tpl_count' );

		/**
		 * Add each individual form as an item.
		 *   Forms are saved as a post type therefore a query necessary.
		 * @since 1.2.0
		 */
		$args = apply_filters(
			'tbexob/filter/oxygen_templates/group_args',
			array(
				'post_type'      => $post_type,
				'posts_per_page' => intval( $count ),
				'post_status'    => array( 'publish', 'draft', 'private', 'future' ),
			)
		);

		$templates = get_posts( $args );

		/** Proceed only if there are any forms */
		if ( $templates ) {

			//$parent = ( 'top-level' === $parent_type ) ? 'tbexob-oxygen-templates' : 'oxygen-template-library';

			/** Add group */
			$admin_bar->add_group(
				array(
					'id'     => 'group-oxygen-edit-templates',
					'parent' => ( 'top-level' === $parent_type ) ? 'tbexob-oxygen-templates' : 'oxygen-template-library',
					'meta'   => array( 'class' => 'oxygen-cptlist-group' ),
				)
			);

			foreach ( $templates as $template ) {

				$template_id   = absint( $template->ID );
				$template_name = esc_attr( $template->post_title );

				/** Check for Oxygen Shortcodes */
				$shortcodes = get_post_meta( $template_id, 'ct_builder_shortcodes', TRUE );

				$contains_inner_content = FALSE;

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

				$builder_edit_url = add_query_arg(
					$query_params,
					get_permalink( $template_id )
				);

				$template_title = sprintf(
					'<span class="oxygen-cptlist-title">%s</span><span class="oxygen-cptlist-status">%s</span>',
					$template_name,
					get_post_status( $template_id )
				);

				/** Add item per template */
				$admin_bar->add_node(
					array(
						'id'     => 'oxygen-templates-template-' . $template_id,
						'parent' => 'group-oxygen-edit-templates',
						'title'  => $template_title,	// $template_name,
						'href'   => esc_url( $builder_edit_url ),
						'meta'   => array(
							'class'  => 'oxygen-cptlist-item',
							'target' => ddw_tbex_meta_target( 'builder' ),
							'title'  => esc_attr__( 'Edit Template in Oxygen Builder', 'toolbar-extras' ) . ': ' . $template_name,
						)
					)
				);

					$admin_bar->add_node(
						array(
							'id'     => 'oxygen-templates-template-' . $template_id . '-builder',
							'parent' => 'oxygen-templates-template-' . $template_id,
							'title'  => esc_attr__( 'Oxygen Builder', 'toolbar-extras-oxygen' ),
							'href'   => esc_url( $builder_edit_url ),
							'meta'   => array(
								'target' => ddw_tbex_meta_target( 'builder' ),
								'title'  => esc_attr__( 'Edit Template in Oxygen Builder', 'toolbar-extras-oxygen' ),
							)
						)
					);

					$admin_bar->add_node(
						array(
							'id'     => 'oxygen-templates-template-' . $template_id . '-admin',
							'parent' => 'oxygen-templates-template-' . $template_id,
							'title'  => esc_attr__( 'Settings in Admin', 'toolbar-extras-oxygen' ),
							'href'   => esc_url( admin_url( 'post.php?post=' . $template_id . '&action=edit' ) ),
							'meta'   => array(
								'target' => ddw_tbex_meta_target(),
								'title'  => esc_attr__( 'Template Settings in WP-Admin', 'toolbar-extras-oxygen' ),
							)
						)
					);

			}  // end foreach

		}  // end if

}  // end function
