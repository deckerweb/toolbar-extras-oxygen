<?php

// includes/string-switcher

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Allow for string switching of the "Oxygen" label.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return string String of Oxygen label, filterable.
 */
function ddw_tbexob_string_oxygen() {

	return esc_attr(
		apply_filters(
			'tbexob/filter/string/oxygen',
			ddw_tbex_get_option( 'oxygen', 'oxygen_name' )
		)
	);

}  // end function


/**
 * Build "Oxygen" Templates string.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_string_oxygen()
 *
 * @return string Filterable and translateable string for "Oxygen" Templates.
 */
function ddw_tbexob_string_oxygen_templates() {

	return esc_attr(
		apply_filters(
			'tbexob/filter/string/oxygen_templates',
			sprintf(
				/* translators: %s - Word Oxygen */
				__( '%s Templates', 'toolbar-extras-oxygen' ),
				ddw_tbexob_string_oxygen()
			)
		)
	);

}  // end function


/**
 * Build "Oxygen" Elements Library string.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_string_oxygen()
 *
 * @return string Filterable and translateable string for "Oxygen" Elements
 *                Library.
 */
function ddw_tbexob_string_oxygen_library() {

	return esc_attr(
		apply_filters(
			'tbexob/filter/string/oxygen_library',
			sprintf(
				/* translators: %s - Word Oxygen */
				__( '%s Elements Library', 'toolbar-extras-oxygen' ),
				ddw_tbexob_string_oxygen()
			)
		)
	);

}  // end function


/**
 * Build "Oxygen" settings string.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_string_oxygen()
 *
 * @return string Filterable and translateable string for "Oxygen" settings.
 */
function ddw_tbexob_string_oxygen_settings() {

	return esc_attr(
		apply_filters(
			'tbexob/filter/string/oxygen_settings',
			sprintf(
				/* translators: %s - Word Oxygen */
				__( '%s Settings', 'toolbar-extras-oxygen' ),
				ddw_tbexob_string_oxygen()
			)
		)
	);

}  // end function


/**
 * Build "Oxygen" resources string.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_string_oxygen()
 *
 * @return string Filterable and translateable string for "Oxygen" resources.
 */
function ddw_tbexob_string_oxygen_resources() {

	return esc_attr(
		apply_filters(
			'tbexob/filter/string/oxygen_resources',
			sprintf(
				/* translators: %s - Word Oxygen */
				__( '%s Resources', 'toolbar-extras-oxygen' ),
				ddw_tbexob_string_oxygen()
			)
		)
	);

}  // end function


/**
 * Build "Oxygen" community string.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_string_oxygen()
 *
 * @return string Filterable and translateable string for "Oxygen" community.
 */
function ddw_tbexob_string_oxygen_community() {

	return esc_attr(
		apply_filters(
			'tbexob/filter/string/oxygen_community',
			sprintf(
				/* translators: %s - Word Oxygen */
				__( '%s Community', 'toolbar-extras-oxygen' ),
				ddw_tbexob_string_oxygen()
			)
		)
	);

}  // end function


/**
 * Build "Edit with Oxygen" string.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexob_string_oxygen()
 *
 * @return string Filterable and translateable string for "Edith with Oxygen".
 */
function ddw_tbexob_string_edit_with_oxygen() {

	return esc_attr(
		apply_filters(
			'tbexob/filter/string/oxygen_edit_with',
			sprintf(
				/* translators: %s - Word Oxygen */
				_x( 'Edit with %s', 'Label for Row Action', 'toolbar-extras-oxygen' ),
				ddw_tbexob_string_oxygen()
			)
		)
	);

}  // end function


/**
 * Build "Back to WP" string.
 *
 * @since 1.0.0
 *
 * @return string Translateable string.
 */
function ddw_tbexob_string_backtowp() {

	return __( 'Back to WP', 'toolbar-extras-oxygen' );

}  // end function