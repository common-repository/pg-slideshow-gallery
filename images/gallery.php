<?php
/*
 Plugin Name: PG Slideshow-Gallery
 Plugin URI: http://qcompsolutions.com
 Description: The PG Slideshow-Gallery plugin is easily deployable on your website as a Gallery or Slideshow. Add any image that has already been uploaded to add to your gallery, add text slides, or even add a Youtube video. Options and styles are customizable for every single gallery on your website.
 Version: 1.0.2
 Requires at least: 3.5
 Author: AminYasser
 Author URI: http://qcompsolutions.com/
 License: GPLv2
 Text Domain: portfolio-gallery
*/

/**
 * Class PSG_PGMain is the application plugin class that includes every other classes.
 * methods for the other classes to use like the auto-includer and the
 * base path/url returning method.
 *
 * @since 1.0.0
 * @author Amin Yasser
 */
class PSG_PGMain
{
	/** @var string $version */
	static $version = '1.0.0';

	/**
	 * Initialize the application by assigning the right functions to
	 * the right action hooks.
	 *
	 * @since 1.0.0
	 */
	static function stitchUp()
	{
		self::autoInclude();

		// Initialize localization on init
		add_action('init', array(__CLASS__, 'localize'));
add_action( 'init', 'portgal_slideshow_block_init' );

		// Enqueue hooks
		add_action('wp_enqueue_scripts'   , array(__CLASS__, 'enqueueFrontendScripts'));
		add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueueBackendScripts'));

		// Ajax requests
		PSG_PGAJAX::init();

		// Register slideshow post type
		PSG_PGPostType::init();

		// Add general settings page
		PSG_PGGeneralSettings::init();

		// Initialize stylesheet builder
		PSG_PGSlideshowStylesheet::init();

		// Deploy slideshow on do_action('gallery_show'); hook.
		add_action('gallery_show', array('PSG_PG', 'show'));

		// Initialize shortcode
		PSG_PGShortcode::init();

		// Register widget
		add_action('widgets_init', array('PSG_PGWidget', 'registerWidget'));

		// Initialize plugin updater
		PSG_PGInstaller::init();
	}

	/**
	 * Enqueues frontend scripts and styles.
	 *
	 * Should always be called on the wp_enqueue_scripts hook.
	 *
	 * @since 1.0.0
	 */
	static function enqueueFrontendScripts()
	{
		// Enqueue slideshow script if lazy loading is enabled
		if (PSG_PGGeneralSettings::getEnableLazyLoading())
		{
			wp_enqueue_script(
				'portfolio-gallery-script',
				self::getPluginUrl() . '/js/min/pg_frontend.js',
				array('jquery'),
				self::$version
			);


			wp_localize_script(
				'portfolio-gallery-script',
				'portfolio_gallery_script_adminURL',
				admin_url()
			);
		}
	}

	/**
	 * Enqueues backend scripts and styles.
	 *
	 * Should always be called on the admin_enqueue_scrips hook.
	 *
	 * @since 2.2.12
	 */
	static function enqueueBackendScripts()
	{
		// Function get_current_screen() should be defined, as this method is expected to fire at 'admin_enqueue_scripts'
		if (!function_exists('get_current_screen'))
		{
			return;
		}

		$currentScreen = get_current_screen();

		// Enqueue 3.5 uploader
		if ($currentScreen->post_type === 'portgal' &&
			function_exists('wp_enqueue_media'))
		{
			wp_enqueue_media();
		}

		wp_enqueue_script(
			'portfolio-gallery-backend-script',
			self::getPluginUrl() . '/js/min/pg_backend.js',
			array(
				'jquery',
				'jquery-ui-sortable',
				'wp-color-picker'
			),
			PSG_PGMain::$version
		);



		wp_enqueue_style(
			'portfolio-gallery-backend-style',
			self::getPluginUrl() . '/css/backend.css',
			array(
				'wp-color-picker'
			),
			PSG_PGMain::$version
		);
	}

	/**
	 * Translates the plugin
	 *
	 * @since 1.0.0
	 */
	static function localize()
	{
		load_plugin_textdomain(
			'portfolio-gallery',
			false,
			dirname(plugin_basename(__FILE__)) . '/languages/'
		);
	}

	/**
	 * Returns url to the base directory of this plugin.
	 *
	 * @since 1.0.0
	 * @return string pluginUrl
	 */
	static function getPluginUrl()
	{
		return plugins_url('', __FILE__);
	}

	/**
	 * Returns path to the base directory of this plugin
	 *
	 * @since 1.0.0
	 * @return string pluginPath
	 */
	static function getPluginPath()
	{
		return dirname(__FILE__);
	}

	/**
	 * Outputs the passed view. It's good practice to pass an object like an stdClass to the $data variable, as it can
	 * be easily checked for validity in the view itself using "instanceof".
	 *
	 * @since 1.1.0
	 * @param string   $view
	 * @param stdClass $data (Optional, defaults to stdClass)
	 */
	static function outputView($view, $data = null)
	{
		
		
		if (!($data instanceof stdClass))
		{
			$data = new stdClass();
		}

		$file = self::getPluginPath() . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $view;
		


		if (file_exists($file))
		{
			

			include $file;

		}
	}

	/**
	 * Uses self::outputView to render the passed view. Returns the rendered view instead of outputting it.
	 *
	 * @since 1.1.0
	 * @param string   $view
	 * @param stdClass $data (Optional, defaults to null)
	 * @return string
	 */
	static function getView($view, $data = null)
	{
		
		ob_start();
	
		self::outputView($view, $data);
		
					

		return ob_get_clean();
	}

	/**
	 * This function will load classes automatically on-call inside classes folder.
	 *
	 * @since 1.0.0
	 */
	static function autoInclude()
	{
		if (!function_exists('spl_autoload_register'))
		{
			return;
		}

		function PGAutoLoader($name)
		{
			$name = str_replace('\\', DIRECTORY_SEPARATOR, $name);
			$file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $name . '.php';


			if (is_file($file))
			{
				require_once $file;
			}
		}

		spl_autoload_register('PGAutoLoader');
	}
}

function portfolio_gallery_render_slideshowgal_block ( $attributes ) {
	ob_start(); // start buffering to avoid the already-sent-headers error

	PSG_PG::show($attributes['selectedSlideshow'],$attributes['selectedType']);

	return ob_get_clean();
}
function portgal_slideshow_block_init() {
	$dir = dirname( __FILE__ );

	$script_asset_path = "$dir/block/index.asset.php";
	if ( ! file_exists( $script_asset_path ) ) {
		throw new Error(
			'You need to run `npm start` or `npm run build` for the "f1rehead/slideshow" block first.'
		);
	}
	$index_js     = 'block/index.js';
	$script_asset = require( $script_asset_path );
	wp_register_script(
		'portfolio-gallery-block-editor',
		plugins_url( $index_js, __FILE__ ),
		$script_asset['dependencies'],
		$script_asset['version']
	);

	$editor_css = 'block/index.css';
	wp_register_style(
		'portfolio-gallery-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'block/style-index.css';
	wp_register_style(
		'portfolio-gallery-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	// WP Localized globals. Use dynamic PHP stuff in JavaScript via `globals` object.
	wp_localize_script(
		'portfolio-gallery-block-editor',
		'globals', // Array containing dynamic data for a JS Global.
		[
			'pluginDirPath' => plugin_dir_path( __DIR__ ),
			'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
			// Add data here to access from `globals` object.
			'slideshows' => get_posts(['posts_per_page' => -1, 'post_type' => 'portgal']),
		]
	);	
	
	register_block_type( 'portfolio-gallery/slideshowgallery', array(
		'editor_script' => 'portfolio-gallery-block-editor',
		'editor_style'  => 'portfolio-gallery-block-editor',
		'style'         => 'portfolio-gallery-block',
		'render_callback' => 'portfolio_gallery_render_slideshowgal_block',
		) );
	}
/*
 * Activate the plugin
 */
PSG_PGMain::stitchUp();