<?php
/**
 * Class PG is called whenever a slideshow do_action tag is come across.
 * Responsible for outputting the slideshow's HTML, CSS and Javascript.
 *
 * @since 1.0.0
 * @author: Stefan Boonstra, Amin
 */
class PSG_PG
{
	/**
	 * Function deploy prints out the prepared html
	 *
	 * @since 1.2.0
	 * @param int $postId
	 */
	static function show($postId = null,$type="slideshow")
	{
		
		
		echo self::prepare($postId,$type);
	}

	/**
	 * Function prepare returns the required html and enqueues
	 * the scripts and stylesheets necessary for displaying the slideshow
	 *
	 * Passing this function no parameter or passing it a negative one will
	 * result in a random pick of slideshow
	 *
	 * @since 2.1.0
	 * @param int $postId
	 * @return String $output
	 */
	static function prepare($postId = null,$type="slideshow")
	{
		$post = null;

		// Get post by its ID, if the ID is not a negative value
		if (is_numeric($postId) &&
			$postId >= 0)
		{
			$post = get_post($postId);
		}

		// Get slideshow by slug when it's a non-empty string
		if ($post === null &&
			is_string($postId) &&
			!is_numeric($postId) &&
			!empty($postId))
		{
			$query = new WP_Query(array(
				'post_type'        => PSG_PGPostType::$postType,
				'name'             => $postId,
				'orderby'          => 'post_date',
				'order'            => 'DESC',
				'suppress_filters' => true
			));

			if($query->have_posts())
			{
				$post = $query->next_post();
			}
		}

		// When no slideshow is found, get one at random
		if ($post === null)
		{
			$post = get_posts(array(
				'numberposts'      => 1,
				'offset'           => 0,
				'orderby'          => 'rand',
				'post_type'        => PSG_PGPostType::$postType,
				'suppress_filters' => true
			));

			if(is_array($post))
			{
				$post = $post[0];
			}
		}

		// Exit on error
		if($post === null)
		{
			return '<!-- Portfolio Slideshow/Gallery - No items available -->';
		}

		// Log slideshow's problems to be able to track them on the page.
		$log = array();

		// Get slides
		$slides = PSG_PGSlideshowSettingsHandler::getSlides($post->ID);

		if (!is_array($slides) ||
			count($slides) <= 0)
		{
			$log[] = 'No slides were found';
		}

		// Get settings
		$settings      = PSG_PGSlideshowSettingsHandler::getSettings($post->ID);
		$styleSettings = PSG_PGSlideshowSettingsHandler::getStyleSettings($post->ID);


		// Only enqueue the functional stylesheet when the 'allStylesheetsRegistered' flag is false
		if (!PSG_PGSlideshowStylesheet::$allStylesheetsRegistered)
		{
			wp_enqueue_style(
				'portfolio-gallery-stylesheet_functional',
				PSG_PGMain::getPluginUrl() . '/css/functional.css',
				array(),
				PSG_PGMain::$version
			);
		}


		// Check if requested style is available. If not, use the default
		list($styleName, $styleVersion) = PSG_PGSlideshowStylesheet::enqueueStylesheet($styleSettings['style']);

		$data               = new stdClass();
		$data->log          = $log;
		$data->post         = $post;
		$data->slides       = $slides;
		$data->settings     = $settings;
		$data->styleName    = $styleName;
		$data->styleVersion = $styleVersion;



if($type=="slideshow")
{
		// Include output file to store output in $output.
		$output = PSG_PGMain::getView(__CLASS__ . DIRECTORY_SEPARATOR . 'slideshow.php', $data);
}elseif($type=="gallery")
{
			// Include output file to store output in $output.
		$output = PSG_PGMain::getView(__CLASS__ . DIRECTORY_SEPARATOR . 'gallery.php', $data);	
		
}elseif($type=="skitter")
{
		$output = PSG_PGMain::getView(__CLASS__ . DIRECTORY_SEPARATOR . 'skitter.php', $data);	
}

if($type=="slideshow")
{
	wp_enqueue_style(
			'portfolio-gallery-qtip-style',
			PSG_PGMain::getPluginUrl() . '/css/jquery.bxslider.css',
			array(

			),
		PSG_PGMain::$version
		);
		
			wp_enqueue_script(
			'portfolio-gallery-script',
			PSG_PGMain::getPluginUrl() . '/js/min/jquery.bxslider.js',
			array('jquery'),
			PSG_PGMain::$version
		);
		
		
		if($settings['video'])
{
			wp_enqueue_script(
			'portfolio-video-script',
			PSG_PGMain::getPluginUrl() . '/js/fit_video.js',
			array('jquery'),
			PSG_PGMain::$version
		);
}


		$outputscript1 = PSG_PGMain::getView('PSG_PGSCRIPTS' . DIRECTORY_SEPARATOR . 'bxslider.php', $data);
		
}elseif($type=="gallery"){
//gallery with or without lightbox

		
				wp_enqueue_style(
			'portfolio-gallery-glight-style',
			PSG_PGMain::getPluginUrl() . '/css/glightbox.css',
			array(

			),
		PSG_PGMain::$version
		);
			wp_enqueue_script(
			'portfolio-gallery-glight-script',
			PSG_PGMain::getPluginUrl() . '/js/min/glight/glightbox.js',
			array('jquery'),
			PSG_PGMain::$version
		);
		
		$outputscript2 = PSG_PGMain::getView('PSG_PGSCRIPTS' . DIRECTORY_SEPARATOR . 'glightbox.php', $data);

		
}elseif($type=="skitter")
{
	
	wp_enqueue_style(
			'portfolio-gallery-skitter-style',
			PSG_PGMain::getPluginUrl() . '/css/skitter.css',
			array(

			),
		PSG_PGMain::$version
		);
		
			wp_enqueue_script(
			'portfolio-gallery-skitter-script',
			PSG_PGMain::getPluginUrl() . '/js/min/jquery.skitter.js',
			array('jquery'),
			PSG_PGMain::$version
		);
		wp_enqueue_script(
			'portfolio-easing-script',
			PSG_PGMain::getPluginUrl() . '/js/min/jquery.easing.1.3.js',
			array('jquery'),
			PSG_PGMain::$version
		);
	
			$outputscript3 = PSG_PGMain::getView('PSG_PGSCRIPTS' . DIRECTORY_SEPARATOR . 'skitter.php', $data);

}

		
			wp_enqueue_script(
			'portfolio-gallery-frontendscript',
			PSG_PGMain::getPluginUrl() . '/js/min/pg_frontend.js',
			array('jquery'),
			PSG_PGMain::$version
		);

		
		
		// Set dimensionWidth and dimensionHeight if dimensions should be preserved
		if (isset($settings['preserveSlideshowDimensions']) &&
			$settings['preserveSlideshowDimensions'] == 'true')
		{
			$aspectRatio = explode(':', $settings['aspectRatio']);

			// Width
			if (isset($aspectRatio[0]) &&
				is_numeric($aspectRatio[0]))
			{
				$settings['dimensionWidth'] = $aspectRatio[0];
			}
			else
			{
				$settings['dimensionWidth'] = 1;
			}

			// Height
			if (isset($aspectRatio[1]) &&
				is_numeric($aspectRatio[1]))
			{
				$settings['dimensionHeight'] = $aspectRatio[1];
			}
			else
			{
				$settings['dimensionHeight'] = 1;
			}
		}

		//if (!PGGeneralSettings::getEnableLazyLoading())
		//{
			// Include slideshow settings by localizing them
			wp_localize_script(
				'portfolio-gallery-script',
				'PGSettings_' . $post->ID,
				$settings
			);


if(isset($outputscript2))
wp_add_inline_script( 'portfolio-gallery-glight-script', $outputscript2);

if(isset($outputscript1))
wp_add_inline_script( 'portfolio-gallery-script', $outputscript1);


if(isset($outputscript3))
wp_add_inline_script( 'portfolio-gallery-skitter-script', $outputscript3);

			// Include the location of the admin-ajax.php file
			wp_localize_script(
				'portfolio-gallery-script',
				'portfolio_gallery_script_adminURL',
			   array( 
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            )
			);
		//}

		// Return output
		return $output;
	}
}