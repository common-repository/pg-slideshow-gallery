<?php

if ($data instanceof stdClass) :

	$properties = $data->properties;



	$name = htmlspecialchars($data->name);

	$title = $description = $textColor = $color = $url = $target = '';

	$titleElementTagID = $descriptionElementTagID = PSG_PGSlideInserter::getElementTag();

	$noFollow = false;

	if (isset($properties['title']))
	{
		$title = PSG_PGSecurity::htmlspecialchars_allow_exceptions($properties['title']);
	}

	if (isset($properties['titleElementTagID']))
	{
		$titleElementTag = $properties['titleElementTagID'];
	}

	if (isset($properties['description']))
	{
		$description = PSG_PGSecurity::htmlspecialchars_allow_exceptions($properties['description']);
	}

	if (isset($properties['descriptionElementTagID']))
	{
		$descriptionElementTag = $properties['descriptionElementTagID'];
	}

	if (isset($properties['textColor']))
	{
		$textColor = htmlspecialchars($properties['textColor']);
	}

	if (isset($properties['color']))
	{
		$color = htmlspecialchars($properties['color']);
	}

	if (isset($properties['url']))
	{
		$url = htmlspecialchars($properties['url']);
	}

	if (isset($properties['urlTarget']))
	{
		$target = $properties['urlTarget'];
	}

	if (isset($properties['noFollow']))
	{
	    $noFollow = true;
	}

	?>
			<div class="pg-list-item sortable-slides-list-item">
<div class="slideshow-group slideshow-delete-slide">
				<a><span><?php _e('Delete', 'portfolio-gallery'); ?></span></a>
			</div>
	<div class="widefat postbox closed">

		<div class="handlediv" title="<?php _e('Click to toggle'); ?>"><span class="toggle-indicator" aria-hidden="true"></span></div>

		<div class="hndle">
			<div class="slide-icon text-slide-icon"></div>
			<div class="slide-title">
				<?php if (strlen($title) > 0) : ?>

					<?php echo esc_html($title); ?>

				<?php else : ?>

					<?php _e('Text slide', 'portfolio-gallery'); ?>

				<?php endif; ?>
			</div>
			
			
			<div class="clear"></div>
		</div>

		<div class="inside">

			<div class="slideshow-group">

				<div class="slideshow-left slideshow-label"><?php _e('Title', 'portfolio-gallery'); ?></div>
		
				<div class="clear"></div>
				<input type="text" name="<?php echo esc_attr($name); ?>[title]" value="<?php echo esc_html($title); ?>" style="width: 100%;" /><br />

			</div>

			<div class="slideshow-group">

				<div class="slideshow-left slideshow-label"><?php _e('Description', 'portfolio-gallery'); ?></div>
		
				<div clear="clear"></div>
	<textarea name="<?php echo esc_attr($name); ?>[description]" rows="7" cols="" style="width: 100%;"><?php echo wp_kses_post($description); ?></textarea><br />
						<?php //wp_editor( $description, 'listingeditor'. $data->index, $settings = array('textarea_name' => $name.'[description]','media_buttons' => false,'editor_height' => 155) ); ?>
			</div>

			<div class="slideshow-group">
<div class="slideshow-label"><?php _e('Text color', 'portfolio-gallery'); ?></div>
				<input type="text" name="<?php echo $name; ?>[textColor]" value="<?php echo $textColor; ?>" class="wp-color-picker-field" />

				<div class="slideshow-label"><?php _e('Background color', 'portfolio-gallery'); ?></div>
				<input type="text" name="<?php echo esc_attr($name); ?>[color]" value="<?php echo esc_attr($color); ?>" class="wp-color-picker-field" />
				<div style="font-style: italic;"><?php _e('(Leave empty for a transparent background)', 'portfolio-gallery'); ?></div>

			</div>

			<div class="slideshow-group">

				<div class="slideshow-label"><?php _e('URL', 'portfolio-gallery'); ?></div>
				<input type="text" name="<?php echo esc_attr($name); ?>[url]" value="<?php echo esc_url($url); ?>" style="width: 100%;" />

				<div class="slideshow-label slideshow-left"><?php _e('Open URL in', 'portfolio-gallery'); ?></div>
				<select name="<?php echo esc_attr($name); ?>[urlTarget]" class="slideshow-right">
					<option value="_self" <?php selected('_self', $target); ?>><?php _e('Same window', 'portfolio-gallery'); ?></option>
					<option value="_blank" <?php selected('_blank', $target); ?>><?php _e('New window', 'portfolio-gallery'); ?></option>
				</select>
				<div class="clear"></div>

				<div class="slideshow-label slideshow-left"><?php _e('Don\'t let search engines follow link', 'portfolio-gallery'); ?></div>
				<input type="checkbox" name="<?php echo esc_attr($name); ?>[noFollow]" value="" <?php checked($noFollow); ?> class="slideshow-right" />
				<div class="clear"></div>

			</div>


			<input type="hidden" name="<?php echo esc_attr($name); ?>[type]" value="text" />

		</div>

	</div></div>
<?php endif; ?>