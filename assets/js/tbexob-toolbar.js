/**
 * // assets/js/tbexob-toolbar
 * @package Toolbar Extras for Oxygen Builder - Assets
 * @since 1.0.0
 */

(function($) {
	
	$(".oxygen-back-to-wp-menu .oxygen-toolbar-button-dropdown-option").attr({
		target: oxytarget,
		rel: oxyrel,
		title: oxytitleattr
	});

	$(".oxygen-back-to-wp-menu .oxygen-toolbar-button-dropdown").append(
		oxylinks
	);

})(jQuery);