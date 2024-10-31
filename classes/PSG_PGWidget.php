<?php
/**
 * Class PGWidget allows showing one of your slideshows in your widget area.
 *
 * @since 1.2.0
 * @author: Stefan Boonstra
 */
class PSG_PGWidget extends WP_Widget
{
	/** @var string $widgetName */
	static $widgetName = 'Portfolio Gallery';

	/**
	 * Initializes the widget
	 *
	 * @since 1.2.0
	 */
	function __construct()
	{
		// Settings
		$options = array(
			'classname'   => 'PGWidget',
			'description' => __('Enables you to show your slideshows in the widget area of your website.', 'portfolio-gallery')
		);

		// Create the widget.
		parent::__construct(
			'PGWidget',
			__('Portfolio Gallery', 'portfolio-gallery'),
			$options
		);
	}

	/**
	 * The widget as shown to the user.
	 *
	 * @since 1.2.0
	 * @param mixed array $args
	 * @param mixed array $instance
	 */
	function widget($args, $instance)
	{
		// Get PGId
		$PGId = '';
		if (isset($instance['PGId']))
		{
			$PGId = $instance['PGId'];
		}

		// Get title
		$title = '';
		if (isset($instance['title']))
		{
			$title = $instance['title'];
		}

		// Prepare slideshow for output to website.
		$output = PSG_PG::prepare($PGId);

		$beforeWidget = $afterWidget = $beforeTitle = $afterTitle = '';
		if (isset($args['before_widget']))
		{
			$beforeWidget = $args['before_widget'];
		}

		if (isset($args['after_widget']))
		{
			$afterWidget = $args['after_widget'];
		}

		if (isset($args['before_title']))
		{
			$beforeTitle = $args['before_title'];
		}

		if (isset($args['after_title']))
		{
			$afterTitle = $args['after_title'];
		}

		// Output widget
		echo $beforeWidget . (!empty($title) ? $beforeTitle . $title . $afterTitle : '') . $output . $afterWidget;
	}

	/**
	 * The form shown on the admins widget page. Here settings can be changed.
	 *
	 * @since 1.2.0
	 * @param mixed array $instance
	 * @return string
	 */
	function form($instance)
	{
		// Defaults
		$defaults = array(
			'title'       => __(self::$widgetName, 'portfolio-gallery'),
			'PGId' => -1
		);

		// Merge database settings with defaults
		$instance = wp_parse_args((array) $instance, $defaults);

		// Get slideshows
		$slideshows = get_posts(array(
			'numberposts' => -1,
			'offset'      => 0,
			'post_type'   => PSG_PGPostType::$postType
		));

		$data              = new stdClass();
		$data->widget      = $this;
		$data->instance   = $instance;
		$data->slideshows = $slideshows;

		// Include form
		PSG_PGMain::outputView(__CLASS__ . DIRECTORY_SEPARATOR . 'form.php', $data);
	}

	/**
	 * Updates widget's settings.
	 *
	 * @since 1.2.0
	 * @param mixed array $newInstance
	 * @param mixed array $instance
	 * @return mixed array $instance
	 */
	function update($newInstance, $instance)
	{
		// Update title
		if (isset($newInstance['title']))
		{
			$instance['title'] = $newInstance['title'];
		}

		// Update PGId
		if (isset($newInstance['PGId']) &&
			!empty($newInstance['PGId']))
		{
			$instance['PGId'] = $newInstance['PGId'];
		}

		// Save
		return $instance;
	}

	/**
	 * Registers this widget (should be called upon widget_init action hook)
	 *
	 * @since 1.2.0
	 */
	static function registerWidget()
	{
		register_widget(__CLASS__);
	}
}