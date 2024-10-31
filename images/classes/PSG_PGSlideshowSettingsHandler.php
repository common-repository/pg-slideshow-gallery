<?php
/**
 * Class PGSlideshowSettingsHandler handles all database/settings interactions for the Galleries.
 *
 * @since 1.0.0
 * @author Amin Yasser
 */
class PSG_PGSlideshowSettingsHandler
{
	/** @var string $nonceAction */
	static $nonceAction = 'portfolio-gallery-nonceAction';
	/** @var string $nonceName */
	static $nonceName = 'portfolio-gallery-nonceName';

	/** @var string $settingsKey */
	static $settingsKey = 'settings';
	/** @var string $styleSettingsKey */
	static $styleSettingsKey = 'styleSettings';
	/** @var string $slidesKey */
	static $slidesKey = 'slides';
static $slideFields = array('title','type','titleElementTagID','description','descriptionElementTagID','url','noFollow','postId','alternativeText','videoId','showRelatedVideos','color','textColor','urlTarget');
	/** @var array $settings      Used for caching by PG ID */
	static $settings = array();
	/** @var array $styleSettings Used for caching by PG ID */
	static $styleSettings = array();
	/** @var array $slides        Used for caching by PG ID */
	static $slides = array();

	/**
	 * Returns all settings that belong to the passed post ID retrieved from
	 * database, merged with default values from getDefaults(). Does not merge
	 * if mergeDefaults is false.
	 *
	 * If all data (including field information and description) is needed,
	 * set fullDefinition to true. See getDefaults() documentation for returned
	 * values. mergeDefaults must be true for this option to have any effect.
	 *
	 * If enableCache is set to true, results are saved into local storage for
	 * more efficient use. If data was already stored, cached data will be
	 * returned, unless $enableCache is set to false. Settings will not be
	 * cached.
	 *
	 * @since 2.1.20
	 * @param int $galleryId
	 * @param boolean $fullDefinition (optional, defaults to false)
	 * @param boolean $enableCache (optional, defaults to true)
	 * @param boolean $mergeDefaults (optional, defaults to true)
	 * @return mixed $settings
	 */
	static function getAllSettings($galleryId, $fullDefinition = false, $enableCache = true, $mergeDefaults = true)
	{
		$settings                          = array();
		$settings[self::$settingsKey]      = self::getSettings($galleryId, $fullDefinition, $enableCache,  $mergeDefaults);
		$settings[self::$styleSettingsKey] = self::getStyleSettings($galleryId, $fullDefinition, $enableCache,  $mergeDefaults);
		$settings[self::$slidesKey]        = self::getSlides($galleryId, $enableCache);

		return $settings;
	}

	/**
	 * Returns settings retrieved from database.
	 *
	 * For a full description of the parameters, see getAllSettings().
	 *
	 * @since 2.1.20
	
	 * @return mixed $settings
	 */
	static function getSettings($galleryId, $fullDefinition = false, $enableCache = true, $mergeDefaults = true)
	{
		if (!is_numeric($galleryId) ||
			empty($galleryId))
		{
			return array();
		}

		// Set caching to false and merging defaults to true when $fullDefinition is set to true
		if ($fullDefinition)
		{
			$enableCache   = false;
			$mergeDefaults = true;
		}

		// If no cache is set, or cache is disabled
		if (!isset(self::$settings[$galleryId]) ||
			empty(self::$settings[$galleryId]) ||
			!$enableCache)
		{
			// Meta data
			$settingsMeta = get_post_meta(
				$galleryId,
				self::$settingsKey,
				true
			);
		
			
		if (!$settingsMeta ||
				!is_array($settingsMeta))
			{
				$settingsMeta = array();
			}

			// If the settings should be merged with the defaults as a full definition, place each setting in an array referenced by 'value'.
			if ($fullDefinition)
			{
				foreach ($settingsMeta as $key => $value)
				{
					$settingsMeta[$key] = array('value' => $value);
				}
			}

			// Get defaults
			$defaults = array();

			if ($mergeDefaults)
			{
				$defaults = self::getDefaultSettings($fullDefinition);
			}

			// Merge with defaults, recursively if a the full definition is required
			if ($fullDefinition)
			{
				$settings = array_merge_recursive(
					$defaults,
					$settingsMeta
				);
			}
			else
			{
				$settings = array_merge(
					$defaults,
					$settingsMeta
				);
			}

			// Cache if cache is enabled
			if ($enableCache)
			{
				self::$settings[$galleryId] = $settings;
			}
		}
		else
		{
			// Get cached settings
			$settings = self::$settings[$galleryId];
		}

		// Return
		return $settings;
	}

	/**
	 * Returns style settings retrieved from database.
	 *
	 * For a full description of the parameters, see getAllSettings().
	 *
	 * @return mixed $settings
	 */
	static function getStyleSettings($galleryId, $fullDefinition = false, $enableCache = true, $mergeDefaults = true)
	{
		if (!is_numeric($galleryId) ||
			empty($galleryId))
		{
			return array();
		}

		// Set caching to false and merging defaults to true when $fullDefinition is set to true
		if ($fullDefinition)
		{
			$enableCache   = false;
			$mergeDefaults = true;
		}

		// If no cache is set, or cache is disabled
		if (!isset(self::$styleSettings[$galleryId]) ||
			empty(self::$styleSettings[$galleryId]) ||
			!$enableCache)
		{
			// Meta data
			$styleSettingsMeta = get_post_meta(
				$galleryId,
				self::$styleSettingsKey,
				true
			);

			if (!$styleSettingsMeta ||
				!is_array($styleSettingsMeta))
			{
				$styleSettingsMeta = array();
			}

			// If the settings should be merged with the defaults as a full definition, place each setting in an array referenced by 'value'.
			if ($fullDefinition)
			{
				foreach ($styleSettingsMeta as $key => $value)
				{
					$styleSettingsMeta[$key] = array('value' => $value);
				}
			}

			// Get defaults
			$defaults = array();

			if ($mergeDefaults)
			{
				$defaults = self::getDefaultStyleSettings($fullDefinition);
			}

			// Merge with defaults, recursively if a the full definition is required
			if ($fullDefinition)
			{
				$styleSettings = array_merge_recursive(
					$defaults,
					$styleSettingsMeta
				);
			}
			else
			{
				$styleSettings = array_merge(
					$defaults,
					$styleSettingsMeta
				);
			}

			// Cache if cache is enabled
			if ($enableCache)
			{
				self::$styleSettings[$galleryId] = $styleSettings;
			}
		}
		else
		{
			// Get cached settings
			$styleSettings = self::$styleSettings[$galleryId];
		}

		// Return
		return $styleSettings;
	}

	/**
	 * Returns slides retrieved from database.
	 *
	 * For a full description of the parameters, see getAllSettings().
	 *
	 * @return mixed $settings
	 */
	static function getSlides($galleryId, $enableCache = true)
	{
		if (!is_numeric($galleryId) ||
			empty($galleryId))
		{
			return array();
		}

		// If no cache is set, or cache is disabled
		if (!isset(self::$slides[$galleryId]) ||
			empty(self::$slides[$galleryId]) ||
			!$enableCache)
		{
			// Meta data
			$slides = get_post_meta(
				$galleryId,
				self::$slidesKey,
				true
			);
		}
		else
		{
			// Get cached settings
			$slides = self::$slides[$galleryId];
		}

		// Sort slides by order ID
		if (is_array($slides))
		{
			ksort($slides);
		}
		else
		{
			$slides = array();
		}

		// Return
		return array_values($slides);
	}

	/**
	 * Get new settings from $_POST variable and merge them with
	 * the old and default settings.
	 * @param int $postId
	 * @return int $postId
	 */
	static function save($postId)
	{
		// Verify nonce, check if user has sufficient rights and return on auto-save.
		if (get_post_type($postId) != PSG_PGPostType::$postType ||
			(!isset($_POST[self::$nonceName]) || !wp_verify_nonce($_POST[self::$nonceName], self::$nonceAction)) ||
			!current_user_can('portfolio-gallery-edit-slideshows', $postId) ||
			(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE))
		{
			return $postId;
		}
$PTVAR=array();
$PTSTYLES=array();
$PTSETTINGS=array();
$sett[self::$settingsKey]=self::getDefaultSettings(true, false);
$stylesett[self::$styleSettingsKey]=self::getDefaultStyleSettings(false);
		// Old settings
		$oldSettings      = self::getSettings($postId);
		
		
		
		$oldStyleSettings = self::getStyleSettings($postId);

		// Get new settings from $_POST, making sure they're arrays
		$newPostSettings = $newPostStyleSettings = $newPostSlides = array();

		if (isset($_POST[self::$settingsKey]) &&
			is_array($_POST[self::$settingsKey]))
		{
			
				foreach($sett[self::$settingsKey] as $key=>$varr)
			{
			$PTSETTINGS[self::$settingsKey][$key]=sanitize_text_field($_POST[self::$settingsKey][$key]);
			}
			
			$newPostSettings = $PTSETTINGS[self::$settingsKey]; //$_POST[self::$settingsKey];
		}


		if (isset($_POST[self::$styleSettingsKey]) &&
			is_array($_POST[self::$styleSettingsKey]))
		{
			
			foreach($stylesett[self::$styleSettingsKey] as $key=>$varr)
			{
			$PTSTYLES[self::$styleSettingsKey][$key]=sanitize_text_field($_POST[self::$styleSettingsKey][$key]);
			}
			
			$newPostStyleSettings =$PTSTYLES[self::$styleSettingsKey]; ///$_POST[self::$styleSettingsKey];
		}

		if (isset($_POST[self::$slidesKey]) &&
			is_array($_POST[self::$slidesKey]))
		{
			
			
			//print_r($_POST[self::$slidesKey]);
			//echo "GGGG";
			foreach($_POST[self::$slidesKey] as $index=>$valarr){
			
			////////////////TODO AMI$N Escaping POST vars//////////////////
			foreach(self::$slideFields  as $key)
			{
//echo $key;
				
			switch($key)
			{
case "description":
$PTVAR[self::$slidesKey][$index][$key]=wp_filter_post_kses($_POST[self::$slidesKey][$index][$key]);
break;

			
case "url":
$PTVAR[self::$slidesKey][$index][$key]=esc_url_raw($_POST[self::$slidesKey][$index][$key]);
break;
			
case "alternativeText":
$PTVAR[self::$slidesKey][$index][$key]=sanitize_text_field($_POST[self::$slidesKey][$index][$key]);
break;
			
case "title":
$PTVAR[self::$slidesKey][$index][$key]=sanitize_text_field($_POST[self::$slidesKey][$index][$key]);
break;

default:
$PTVAR[self::$slidesKey][$index][$key]=sanitize_text_field($_POST[self::$slidesKey][$index][$key]);



			}				
				
			}
			
			}
			//use a switch case statement to store all post variables using safe wp escaping functions.
			$newPostSlides = $PTVAR[self::$slidesKey]; ///$_POST[self::$slidesKey];
		}






		// Merge new settings with its old values
		$newSettings = array_merge(
			$oldSettings,
			$newPostSettings
		);

		// Merge new style settings with its old values
		$newStyleSettings = array_merge(
			$oldStyleSettings,
			$newPostStyleSettings
		);


		// Save settings
		update_post_meta($postId, self::$settingsKey, $newSettings); //Storing the gallery settings
		update_post_meta($postId, self::$styleSettingsKey, $newStyleSettings); //Storing the gallery settings
		update_post_meta($postId, self::$slidesKey, $newPostSlides); //Storing individual slides/attachments

		// Return
		return $postId;
	}

	/**
	 * Returns an array of all defaults. The array will be returned
	 * like this:
	 * array([settingsKey] => array([settingName] => [settingValue]))
	 *
	 * If all default data (including field information and description)
	 * is needed, set fullDefinition to true. Data in the full definition is
	 * build up as follows:
	 * array([settingsKey] => array([settingName] => array('type' => [inputType], 'value' => [value], 'default' => [default], 'description' => [description], 'options' => array([options]), 'dependsOn' => array([dependsOn], [onValue]), 'group' => [groupName])))
	 *
	 * Finally, when you require the defaults as they were programmed in,
	 * set this parameter to false. When set to true, the database will
	 * first be consulted for user-customized defaults. Defaults to true.
	 *
	 * @since 1.0.0
	 * @param mixed $key (optional, defaults to null, getting all keys)
	 * @param boolean $fullDefinition (optional, defaults to false)
	 * @param boolean $fromDatabase (optional, defaults to true)
	 * @return mixed $data
	 */
	static function getAllDefaults($key = null, $fullDefinition = false, $fromDatabase = true)
	{
		$data                          = array();
		$data[self::$settingsKey]      = self::getDefaultSettings($fullDefinition, $fromDatabase);
		$data[self::$styleSettingsKey] = self::getDefaultStyleSettings($fullDefinition, $fromDatabase);

		return $data;
	}

	/**
	 * Returns an array of setting defaults.
	 *
	 * For a full description of the parameters, see getAllDefaults().
	 *
	 * @since 1.0.0
	 * @param boolean $fullDefinition (optional, defaults to false)
	 * @param boolean $fromDatabase (optional, defaults to true)
	 * @return mixed $data
	 */
static function getDefaultSettings($fullDefinition = false, $fromDatabase = true)
	{
		// Much used data for translation
		$yes = __('Yes', 'portfolio-gallery');
		$no  = __('No', 'portfolio-gallery');

		// Default values
		$data = array(
			'mode' => 'horizontal',
			'speed' => '2000',
			'startSlide' => '0',
			'infiniteLoop' => true,
			'hideControlOnEnd' => false,
			'captions' => '0',
			'adaptiveHeight' => false,
			'video' => false,
			'responsive' => true,
			'preloadImages' => 'visible',
			'touchEnabled' => true,
			'pager' => false,
			'pagerType' => true,
			'controls' => true,
			'auto' => true,
			//'stopAutoOnClick' => true,
			'pause' => '2000',
			//'minSlides' => '1',
			//'maxSlides' => '1',
			'slideWidth' => '0',
			'autoStart' => true,
			'galleryTitle' => true,'galleryDesc' => false,'glightbox' => true,'gpaddingSpace' => 2,'galignment' => 'centre','gtheme' => 'themeone','vwidth' => '300','vheight' => '300',
			'sw_velocity'=>'1.1',
			'sw_interval'=>'2000',
			'sw_animation'=>'',
			'sw_numbers'=>true,
			'sw_label'=>true,

			'sw_navigation'=>true,
			'sw_thumbs'=>true,
			'sw_hide_tools'=>true,
			'sw_fullscreen'=>false,
			
			'sw_dots'=>true,
			'sw_show_randomly'=>true,
			'sw_numbers_align'=>'left',
			'sw_preview'=>false,
			'sw_controls'=>true,
			'sw_controls_position'=>'center',
			'sw_enable_navigation_keys'=>'true',
			'sw_with_animations'=>"paralell,cube,blind,upBars",
			'sw_stop_over'=>false,
			'sw_auto_play'=>true,
			'sw_theme'=>'round'

			
	
			
			
			
		);
		
		
		// Read defaults from database and merge with $data, when $fromDatabase is set to true
		if ($fromDatabase)
		{
			$data = array_merge(
				$data,
				$customData = get_option(PSG_PGGeneralSettings::$defaultSettings, array())
			);
		}

		// Full definition
		if ($fullDefinition)
		{
			$descriptions = array(
			'mode' => 'Type of transition between slides',
			'speed' => 'Slide transition duration (in ms)',
			'startSlide' => 'Starting slide index (zero-based)',
			'infiniteLoop' => 'If true, clicking "Next" while on the last slide will transition to the first slide and vice-versa',
			'hideControlOnEnd' => 'If true, "Prev" and "Next" controls will be hidden at start and end.',
			'captions' => 'Include image captions. ',
			'adaptiveHeight' => 'Dynamically adjust slider height based on each slider width',
			'video' => 'If any slides contain video, set this to true.',
			'responsive' => 'Enable or disable auto resize of the slider. ',
			'preloadImages' => 'Preload only visible or all or none.',
			'touchEnabled' => 'If true, slider will allow touch swipe transitions',
			'pager' => 'If true, a pager will be added',
			'pagerType' => 'Short or Full Pager Type',
			'controls' => 'If true, "Next" / "Prev" controls will be added',
			'auto' => 'Slides will automatically transition if set to true',
			//'stopAutoOnClick' => 'Auto will stop on interaction with controls',
			'pause' => 'The amount of time (in ms) between each auto transition',
			//'minSlides' => 'Carousel: The minimum number of slides to be shown',
			//'maxSlides' => 'Carousel: The maximum number of slides to be shown',
			'slideWidth' => 'The width of each slide',
			'vheight' => 'Height of Youtube Video',
			'vwidth' => 'Width of Youtube Video',
			'autoStart' => 'Auto show starts playing on load',
			'galleryTitle' => 'Show Title',	'galleryDesc' => 'Show Description',
			'glightbox' => 'Lightbox popup','gpaddingSpace' => 'Thumbnail Gallery padding space in px','galignment' => 'Content alignement in gallery',
			
			'sw_velocity'=>'Speed',
			'sw_interval'=>'Interval',
			'sw_animation'=>'Default Animation',
			'sw_numbers'=>'Show Numbers',
			'sw_label'=>'Show Label',
			'sw_navigation'=>'Show Navigation?',
			'sw_thumbs'=>'Show Thumbs?',
			'sw_hide_tools'=>'Hide Tools?',
			'sw_fullscreen'=>'Full Screen?',
			'sw_dots'=>'Dots',
			'sw_show_randomly'=>'Show Random',
			'sw_numbers_align'=>'Numbers Alignment',
			'sw_preview'=>'Show Preview',
			'sw_controls'=>'Controls',
			'sw_controls_position'=>'Controls Position',
			'sw_enable_navigation_keys'=>'Enable Nav Keys',
			'sw_with_animations'=>'With Animations(comma separated list)',
			'sw_stop_over'=>'Stop On Mouseover',
			'sw_auto_play'=>'Auto Play',
			'sw_theme'=>'Nav Theme'

	
			);

			$data = array(
				'mode' => array('type' => 'select', 'default' => $data['mode'], 'description' => $descriptions['mode'], 'group' => __('Slideshow', 'portfolio-gallery')    , 	'options' => array('horizontal' => __('Horizontal', 'portfolio-gallery'), 'vertical' => __('Vertical', 'portfolio-gallery'), 'fade' => __('Fade', 'portfolio-gallery'))),
				'speed'                  => array('type' => 'text'  , 'default' => $data['speed']                 , 'description' => $descriptions['speed']                 , 'group' => __('Slideshow', 'portfolio-gallery')),
				'startSlide'            => array('type' => 'text'  , 'default' => $data['startSlide']           , 'description' => $descriptions['startSlide']           , 'group' => __('Slideshow', 'portfolio-gallery')),
				'infiniteLoop'               => array('type' => 'radio'  , 'default' => $data['infiniteLoop']              , 'description' => $descriptions['infiniteLoop']              , 'group' => __('Slideshow', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
				'hideControlOnEnd'               => array('type' => 'radio'  , 'default' => $data['hideControlOnEnd']              , 'description' => $descriptions['hideControlOnEnd']              , 'group' => __('Slideshow', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
				'captions'               => array('type' => 'radio'  , 'default' => $data['captions']              , 'description' => $descriptions['captions']              , 'group' => __('Slideshow', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
				'adaptiveHeight'               => array('type' => 'radio'  , 'default' => $data['adaptiveHeight']              , 'description' => $descriptions['adaptiveHeight']              , 'group' => __('Slideshow', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
				'video'               => array('type' => 'radio'  , 'default' => $data['video']              , 'description' => $descriptions['video']              , 'group' => __('Slideshow', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
				'responsive'               => array('type' => 'radio'  , 'default' => $data['responsive']              , 'description' => $descriptions['responsive']              , 'group' => __('Slideshow', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
				'preloadImages'               => array('type' => 'select'  , 'default' => $data['preloadImages']              , 'description' => $descriptions['preloadImages']              , 'group' => __('Slideshow', 'portfolio-gallery'),'options' => array('visible' => 'Visible', 'all' => 'All', 'none' =>'None')),
				'touchEnabled'               => array('type' => 'radio'  , 'default' => $data['touchEnabled']              , 'description' => $descriptions['touchEnabled']              , 'group' => __('Slideshow', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),	
				'pager'               => array('type' => 'radio'  , 'default' => $data['pager']              , 'description' => $descriptions['pager']              , 'group' => __('Slideshow', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
				'pagerType'               => array('type' => 'select'  , 'default' => $data['pagerType']              , 'description' => $descriptions['pagerType']              , 'group' => __('Slideshow', 'portfolio-gallery'),'options' => array('short' => 'Short', 'full' => 'Full')),
				'controls'               => array('type' => 'radio'  , 'default' => $data['controls']              , 'description' => $descriptions['controls']              , 'group' => __('Slideshow', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
				'auto'               => array('type' => 'radio'  , 'default' => $data['auto']              , 'description' => $descriptions['auto']              , 'group' => __('Slideshow', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),

				/*'stopAutoOnClick'               => array('type' => 'radio'  , 'default' => $data['stopAutoOnClick']              , 'description' => $descriptions['stopAutoOnClick']              , 'group' => __('Slideshow', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),*/

				'pause'            => array('type' => 'text'  , 'default' => $data['pause']           , 'description' => $descriptions['pause']           , 'group' => __('Slideshow', 'portfolio-gallery')),
				/*'minSlides'            => array('type' => 'text'  , 'default' => $data['minSlides']           , 'description' => $descriptions['minSlides']           , 'group' => __('Slideshow', 'portfolio-gallery')),
				'maxSlides'            => array('type' => 'text'  , 'default' => $data['maxSlides']           , 'description' => $descriptions['maxSlides']           , 'group' => __('Slideshow', 'portfolio-gallery')),*/
				
				'slideWidth'            => array('type' => 'text'  , 'default' => $data['slideWidth']           , 'description' => $descriptions['slideWidth']           , 'group' => __('Slideshow', 'portfolio-gallery')),
			
				'vheight'            => array('type' => 'text'  , 'default' => $data['vheight']           , 'description' => $descriptions['vheight']           , 'group' => __('Slideshow', 'portfolio-gallery')),
		
				'vwidth'            => array('type' => 'text'  , 'default' => $data['vwidth']           , 'description' => $descriptions['vwidth']           , 'group' => __('Slideshow', 'portfolio-gallery')),
				
				'galleryTitle'            => array('type' => 'radio'  , 'default' => $data['galleryTitle']           , 'description' => $descriptions['galleryTitle']           , 'group' => __('Gallery', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
				'galleryDesc'            => array('type' => 'radio'  , 'default' => $data['galleryDesc']           , 'description' => $descriptions['galleryDesc']           , 'group' => __('Gallery', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
				'glightbox'            => array('type' => 'radio'  , 'default' => $data['glightbox']           , 'description' => $descriptions['glightbox']           , 'group' => __('Gallery', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
				'gpaddingSpace'            => array('type' => 'text'  , 'default' => $data['gpaddingSpace']           , 'description' => $descriptions['gpaddingSpace']           , 'group' => __('Gallery', 'portfolio-gallery')),
				'galignment'            => array('type' => 'select'  , 'default' => $data['galignment']           , 'description' => $descriptions['galignment']           , 'group' => __('Gallery', 'portfolio-gallery'),'options' => array('centre' => __('Centre', 'portfolio-gallery'), 'Left' => __('Left', 'portfolio-gallery'))),
				
				
			'sw_velocity'=>array('type' => 'text'  , 'default' => $data['sw_velocity']           , 'description' => $descriptions['sw_velocity']           , 'group' => __('Skitter', 'portfolio-gallery'),'grouphelper' => __('(Only Work for Images Type)', 'portfolio-gallery')),
			'sw_interval'=>array('type' => 'text'  , 'default' => $data['sw_interval']           , 'description' => $descriptions['sw_interval']           , 'group' => __('Skitter', 'portfolio-gallery')),
			'sw_animation'=> array('type' => 'select'  , 'default' => $data['sw_animation']              , 'description' => $descriptions['sw_animation']              , 'group' => __('Skitter', 'portfolio-gallery'),'options' => array('cube' => 'Short', 'block' => 'Full','horizontal' => 'Full','tube' => 'Tube','fade' => 'Fade','circles' => 'Circles','cut' => 'Cut','upBars' => 'Up Bars','swapBars' => 'Swap Bars','cubeRandom' => 'Cube Random','block' => 'Block')),
			'sw_numbers'=> array('type' => 'radio'  , 'default' => $data['sw_numbers']           , 'description' => $descriptions['sw_numbers']           , 'group' => __('Skitter', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
						'sw_label'=> array('type' => 'radio'  , 'default' => $data['sw_label']           , 'description' => $descriptions['sw_label']           , 'group' => __('Skitter', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
			'sw_navigation'=> array('type' => 'radio'  , 'default' => $data['sw_navigation']           , 'description' => $descriptions['sw_navigation']           , 'group' => __('Skitter', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
			'sw_thumbs'=> array('type' => 'radio'  , 'default' => $data['sw_thumbs']           , 'description' => $descriptions['sw_thumbs']           , 'group' => __('Skitter', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
			'sw_hide_tools'=>array('type' => 'radio'  , 'default' => $data['sw_hide_tools']           , 'description' => $descriptions['sw_hide_tools']           , 'group' => __('Skitter', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
			'sw_fullscreen'=>array('type' => 'radio'  , 'default' => $data['sw_fullscreen']           , 'description' => $descriptions['sw_fullscreen']           , 'group' => __('Skitter', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
			
			'sw_dots'=>array('type' => 'radio'  , 'default' => $data['sw_dots']           , 'description' => $descriptions['sw_dots']           , 'group' => __('Skitter', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
			'sw_show_randomly'=>array('type' => 'radio'  , 'default' => $data['sw_show_randomly']           , 'description' => $descriptions['sw_show_randomly']           , 'group' => __('Skitter', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
			'sw_numbers_align'=>array('type' => 'text'  , 'default' => $data['sw_numbers_align']           , 'description' => $descriptions['sw_numbers_align']           , 'group' => __('Skitter', 'portfolio-gallery')),
			
			'sw_preview'=>array('type' => 'radio'  , 'default' => $data['sw_preview']           , 'description' => $descriptions['sw_preview']           , 'group' => __('Skitter', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
			'sw_controls'=>array('type' => 'radio'  , 'default' => $data['sw_controls']           , 'description' => $descriptions['sw_controls']           , 'group' => __('Skitter', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
			
			'sw_controls_position'=>array('type' => 'text'  , 'default' => $data['sw_controls_position']           , 'description' => $descriptions['sw_controls_position']           , 'group' => __('Skitter', 'portfolio-gallery')),
			
			'sw_enable_navigation_keys'=>array('type' => 'radio'  , 'default' => $data['sw_enable_navigation_keys']           , 'description' => $descriptions['sw_enable_navigation_keys']           , 'group' => __('Skitter', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
			'sw_with_animations'=>array('type' => 'text'  , 'default' => $data['sw_with_animations']           , 'description' => $descriptions['sw_with_animations']           , 'group' => __('Skitter', 'portfolio-gallery')),
			'sw_stop_over'=>array('type' => 'radio'  , 'default' => $data['sw_stop_over']           , 'description' => $descriptions['sw_stop_over']           , 'group' => __('Skitter', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
			'sw_auto_play'=>array('type' => 'radio'  , 'default' => $data['sw_auto_play']           , 'description' => $descriptions['sw_auto_play']           , 'group' => __('Skitter', 'portfolio-gallery'),'options' => array(true => $yes, false => $no)),
			'sw_theme'=>array('type' => 'select'  , 'default' => $data['sw_theme']              , 'description' => $descriptions['sw_theme']              , 'group' => __('Skitter', 'portfolio-gallery'),'options' => array('minimalist' => 'Minimalist', 'round' => 'Round','square'=>'Square')),


			
				

				);	
								
				

		}


		// Return
		return $data;
	}
	
	
	/**
	 * Returns an array of style setting defaults.
	 *
	 * For a full description of the parameters, see getAllDefaults().
	 *
	 * @since 1.0.0
	 * @param boolean $fullDefinition (optional, defaults to false)
	 * @param boolean $fromDatabase (optional, defaults to true)
	 * @return mixed $data
	 */
	static function getDefaultStyleSettings($fullDefinition = false, $fromDatabase = true)
	{
		// Default style settings
		$data = array(
			'style' => 'themeone.css'
		);

		// Read defaults from database and merge with $data, when $fromDatabase is set to true
		if ($fromDatabase)
		{
			$data = array_merge(
				$data,
				$customData = get_option(PSG_PGGeneralSettings::$defaultStyleSettings, array())
			);
		}


		// Full definition
		if ($fullDefinition)
		{
			$data = array(
				'style' => array('type' => 'select', 'default' => $data['style'], 'description' => __('The style used for this gallery', 'portfolio-gallery'), 'options' => PSG_PGGeneralSettings::getStylesheets()),
			);
		}

		// Return
		return $data;
	}

	/**
	 * Returns an HTML inputField of the input setting.
	 *
	 * This function expects the setting to be in the 'fullDefinition'
	 * format that the getDefaults() and getSettings() methods both
	 * return.
	 *
	 * @since 2.1.20
	 * @param string $settingsKey
	 * @param string $settingsName
	 * @param mixed $settings
	 * @param bool $hideDependentValues (optional, defaults to true)
	 * @return mixed $inputField
	 */
	static function getInputField($settingsKey, $settingsName, $settings, $hideDependentValues = true)
	{
		if (!is_array($settings) ||
			empty($settings) ||
			empty($settingsName))
		{
			return null;
		}

		$inputField   = '';
		$name         = $settingsKey . '[' . $settingsName . ']';
		$displayValue = (!isset($settings['value']) || (empty($settings['value']) && !is_numeric($settings['value'])) ? $settings['default'] : $settings['value']);
		$class        = ((isset($settings['dependsOn']) && $hideDependentValues)? 'depends-on-field-value ' . $settings['dependsOn'][0] . ' ' . $settings['dependsOn'][1] . ' ': '') . $settingsKey . '-' . $settingsName;

		switch($settings['type'])
		{
			case 'text':

				$inputField .= '<input
					type="text"
					name="' . $name . '"
					class="' . $class . '"
					value="' . $displayValue . '"
				/>';

				break;

			case 'textarea':

				$inputField .= '<textarea
					name="' . $name . '"
					class="' . $class . '"
					rows="20"
					cols="60"
				>' . $displayValue . '</textarea>';

				break;

			case 'select':

				$inputField .= '<select name="' . $name . '" class="' . $class . '">';

				foreach ($settings['options'] as $optionKey => $optionValue)
				{
					$inputField .= '<option value="' . $optionKey . '" ' . selected($displayValue, $optionKey, false) . '>
						' . $optionValue . '
					</option>';
				}

				$inputField .= '</select>';

				break;

			case 'radio':

				foreach ($settings['options'] as $radioKey => $radioValue)
				{
					
					//if($displayValue===false){echo "false";  $displayValue=0;}
					$inputField .= '<label style="padding-right: 10px;"><input
						type="radio"
						name="' . $name . '"
						class="' . $class . '"
						value="' . $radioKey . '" ' .
						checked($displayValue, $radioKey, false) .
						' />' . $radioValue . '</label>';
				}

				break;

			default:

				$inputField = null;

				break;
		};

		// Return
		return $inputField;
	}
}