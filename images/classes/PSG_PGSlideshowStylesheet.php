<?php
/**
 * PGSlideshowStylesheet handles the loading of the slideshow's stylesheets.
 *
 * @since 2.2.8
 * @author Stefan Boonstra
 */
class PSG_PGSlideshowStylesheet
{
	/** @var bool $allStylesheetsRegistered */
	public static $allStylesheetsRegistered = false;

	/**
	 * Initializes the PGSlideshowStylesheet class
	 *
	 * @since 2.2.12
	 */
	public static function init()
	{
		add_action('wp_enqueue_scripts', array(__CLASS__, 'enqueueFrontendStylesheets'));
	}

	/**
	 * Enqueue stylesheet
	 */
	public static function enqueueFrontendStylesheets()
	{
		if (PSG_PGGeneralSettings::getStylesheetLocation() === 'head')
		{
			// Register functional stylesheet
			wp_enqueue_style(
				'portfolio-gallery-stylesheet_functional',
				PSG_PGMain::getPluginUrl() . '/style/PG/functional.css',
				array(),
				PSG_PGMain::$version
			);

			// Get default and custom stylesheets
			$stylesheets        = PSG_PGGeneralSettings::getStylesheets(true, true);
			$defaultStylesheets = $stylesheets['default'];
			$customStylesheets  = $stylesheets['custom'];

			// Clean the '.css' extension from the default stylesheets
			foreach ($defaultStylesheets as $defaultStylesheetKey => $defaultStylesheetValue)
			{
				$newDefaultStylesheetKey = str_replace('.css', '', $defaultStylesheetKey);

				$defaultStylesheets[$newDefaultStylesheetKey] = $defaultStylesheetValue;

				if ($defaultStylesheetKey !== $newDefaultStylesheetKey)
				{
					unset($defaultStylesheets[$defaultStylesheetKey]);
				}
			}

			// Enqueue stylesheets
			foreach (array_merge($defaultStylesheets, $customStylesheets) as $stylesheetKey => $stylesheetValue)
			{
				wp_enqueue_style(
					'portfolio-gallery-ajax-stylesheet_' . $stylesheetKey,
					admin_url('admin-ajax.php?action=portfolio_gallery_load_stylesheet&style=' . $stylesheetKey, 'admin'),
					array(),
					$stylesheetValue['version']
				);
			}

			self::$allStylesheetsRegistered = true;
		}
	}

	/**
	 * Enqueues a stylesheet based on the stylesheet's name. This can either be a default stylesheet or a custom one.
	 * If the name parameter is left unset, the default stylesheet will be used.
	 *
	 * Returns the name and version number of the stylesheet that's been enqueued, as this can be different from the
	 * name passed. This can be this case if a stylesheet does not exist and a default stylesheet is enqueued.
	 *
	 * @param string $name (optional, defaults to null)
	 * @return array [$name, $version]
	 */
	public static function enqueueStylesheet($name = null)
	{
		$enqueueDynamicStylesheet = true;
		$version                  = PSG_PGMain::$version;

		if (isset($name))
		{
			// Try to get the custom style's version
			$customStyle        = get_option($name, false);
			$customStyleVersion = false;

			if ($customStyle)
			{
				$customStyleVersion = get_option($name . '_version', false);
			}

			// Style name and version
			if ($customStyle && $customStyleVersion)
			{
				$version = $customStyleVersion;
			}
			else
			{
				$enqueueDynamicStylesheet = false;
				$name                     = str_replace('.css', '', $name);
			}
		}
		else
		{
			$enqueueDynamicStylesheet = false;
			$name                     = 'themeone';
		}

		// Enqueue stylesheet
		if ($enqueueDynamicStylesheet)
		{
			
			
			wp_enqueue_style(
				'portfolio-gallery-ajax-stylesheet_' . $name,
				admin_url('admin-ajax.php?action=portfolio_gallery_load_stylesheet&style=' . $name, 'admin'),
				array(),
				$version
			);
		}
		else
		{
			
		
			wp_enqueue_style(
				'portfolio-gallery-stylesheet_' . $name,
				PSG_PGMain::getPluginUrl() . '/css/' . $name . '.css',
				array(),
				$version
			);
		}

		return array($name, $version);
	}

	/**
	 * Called through WordPress' admin-ajax.php script, registered in the PGAJAX class. This function
	 * must not be called on itself.
	 *
	 * Uses the loadStylesheet function to load the stylesheet passed in the URL data. If no stylesheet name is set, all
	 * stylesheets will be loaded.
	 *
	 * Headers are set to allow file caching.
	 *
	 * @since 2.2.11
	 */
	public static function loadStylesheetByAJAX()
	{
		$styleName = filter_input(INPUT_GET, 'style', FILTER_SANITIZE_SPECIAL_CHARS);

		// If no style name is set, all stylesheets will be loaded.
		if (isset($styleName) &&
			!empty($styleName) &&
			strlen($styleName) > 0)
		{
			$stylesheet = self::getStylesheet($styleName);
		}
		else
		{
			return;
		}

		// Exit if headers have already been sent
		if (headers_sent())
		{
			return;
		}

		// Set header to CSS. Cache for a year (as WordPress does)
		header('Content-Type: text/css; charset=UTF-8');
		header('Expires: ' . gmdate("D, d M Y H:i:s", time() + 31556926) . ' GMT');
		header('Pragma: cache');
		header("Cache-Control: public, max-age=31556926");

		echo $stylesheet;

		die;
	}

	/**
	 * Gets the stylesheet with the parsed style name, then returns it.
	 *
	 * @since 2.2.8
	 * @param string $styleName
	 * @return string $stylesheet
	 */
	public static function getStylesheet($styleName)
	{
		// Get custom style keys
		$customStyleKeys = array_keys(get_option(PSG_PGGeneralSettings::$customStyles, array()));

		// Match $styleName against custom style keys
		if (in_array($styleName, $customStyleKeys))
		{
			// Get custom stylesheet
			$stylesheet = get_option($styleName, '');
		}
		else
		{
			$stylesheetFile = PSG_PGMain::getPluginPath() . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR .  $styleName . '.css';

			if (!file_exists($stylesheetFile))
			{
				$stylesheetFile = PSG_PGMain::getPluginPath() . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'themeone.css';
			}

			// Get contents of stylesheet
			ob_start();
			include($stylesheetFile);
			$stylesheet = ob_get_clean();
		}

		// Replace the URL placeholders with actual URLs and add a unique identifier to separate stylesheets
		$stylesheet = str_replace('%plugin-url%', PSG_PGMain::getPluginUrl(), $stylesheet);
		$stylesheet = str_replace('%site-url%', get_bloginfo('url'), $stylesheet);
		$stylesheet = str_replace('%stylesheet-url%', get_stylesheet_directory_uri(), $stylesheet);
		$stylesheet = str_replace('%template-url%', get_template_directory_uri(), $stylesheet);
		$stylesheet = str_replace('.slideshow_container', '.slideshow_container_' . $styleName, $stylesheet);

		return $stylesheet;
	}
}
