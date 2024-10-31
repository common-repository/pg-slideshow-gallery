<?php

if ($data instanceof stdClass) :

	$properties = $data->properties;

	$name = htmlspecialchars($data->name);
$title=$properties['title']; $description=$properties['description'];

	$videoId           = '';
	$showRelatedVideos = 'false';

	if (isset($properties['videoId']))
	{
		$videoId = htmlspecialchars($properties['videoId']);
	}

	if (isset($properties['showRelatedVideos']) &&
		$properties['showRelatedVideos'] === 'true')
	{
		$showRelatedVideos = 'true';
	}

	?>
			<div class="pg-list-item sortable-slides-list-item">
	<div class="slideshow-group slideshow-delete-slide">
				<span><a><?php _e('Delete', 'portfolio-gallery'); ?></a></span>
			</div>
	<div class="widefat  postbox closed">

		<div class="handlediv" title="<?php _e('Click to toggle'); ?>"><span class="toggle-indicator" aria-hidden="true"></span></div>

		<div class="hndle">
			<div class="slide-icon video-slide-icon"></div>
			<div class="slide-title">
				<?php _e(substr($title,0,100), 'portfolio-gallery'); ?>
			</div>
			<div class="clear"></div>
		</div>

		<div class="inside">
	
			<div class="slideshow-group">

				<div class="slideshow-label"><?php _e('Youtube Video ID', 'portfolio-gallery'); ?></div>
				<input type="text" name="<?php echo esc_html($name); ?>[videoId]" value="<?php echo esc_html($videoId); ?>" style="width: 100%;" />

			</div>
				<div class="slideshow-group">
<div class="slideshow-label"><?php _e('Title', 'portfolio-gallery'); ?></div>
	<input type="text" name="<?php echo esc_html($name); ?>[title]" value="<?php echo esc_html($title); ?>" style="width: 100%;" /><br />
</div>
				<div class="slideshow-group">
<div class="slideshow-label"><?php _e('Description', 'portfolio-gallery'); ?></div>
	<input type="text" name="<?php echo esc_html($name); ?>[description]" value="<?php echo wp_kses_post($description); ?>" style="width: 100%;" /><br />
</div>
			<div class="slideshow-group">

				<div class="slideshow-label"><?php _e('Show related videos', 'portfolio-gallery'); ?></div>
				<label><input type="radio" name="<?php echo esc_html($name); ?>[showRelatedVideos]" value="true" <?php checked('true', $showRelatedVideos); ?>><?php _e('Yes', 'portfolio-gallery'); ?></label>
				<label><input type="radio" name="<?php echo esc_html($name); ?>[showRelatedVideos]" value="false" <?php checked('false', $showRelatedVideos); ?>><?php _e('No', 'portfolio-gallery'); ?></label>

			</div>

	

			<input type="hidden" name="<?php echo esc_html($name); ?>[type]" value="video" />

		</div>

	</div></div>
<?php endif; ?>