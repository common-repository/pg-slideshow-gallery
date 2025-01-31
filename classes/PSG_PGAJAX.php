<?php
/**
 * Class SlideshowAJAX is used to register AJAX functions
 * as soon as possible, so they only leave a light footprint.
 *
 * @since 2.0.0
 * @author: Stefan Boonstra
 */
class PSG_PGAJAX
{
	/**
	 * Called as early as possible to be able to have as light as possible AJAX requests. Hooks can be added here as to
	 * have early execution.
	 *
	 * @since 2.0.0
	 */
	static function init()
	{
		add_action('wp_ajax_portfolio_gallery_load_stylesheet', array('PSG_PGSlideshowStylesheet', 'loadStylesheetByAJAX'));
		add_action('wp_ajax_nopriv_portfolio_gallery_load_stylesheet', array('PSG_PGSlideshowStylesheet', 'loadStylesheetByAJAX'));
	}
}