<?php

if ($data instanceof stdClass) :

	$properties = $data->properties;

	// The attachment should always be there
	$attachment = get_post($properties['postId']);

	if (isset($attachment)):

		$name = htmlspecialchars($data->name);

		$title = $titleElementTagID = $description = $descriptionElementTagID = $url = $target = $alternativeText = '';

	    $noFollow = false;

	    if (isset($properties['title']))
		{
			$title = PSG_PGSecurity::htmlspecialchars_allow_exceptions($properties['title']);
		}

		if (isset($properties['titleElementTagID']))
		{
			$titleElementTagID = $properties['titleElementTagID'];
		}

		if (isset($properties['description']))
		{
			$description = PSG_PGSecurity::htmlspecialchars_allow_exceptions($properties['description']);
		}

		if (isset($properties['descriptionElementTagID']))
		{
			$descriptionElementTagID = $properties['descriptionElementTagID'];
		}

		if (isset($properties['url']))
		{
			$url = $properties['url'];
		}

		if (isset($properties['urlTarget']))
		{
			$target = $properties['urlTarget'];
		}

	    if (isset($properties['noFollow']))
	    {
	        $noFollow = true;
	    }

		if (isset($properties['alternativeText']))
		{
			$alternativeText = htmlspecialchars($properties['alternativeText']);
		}
		else
		{
			$alternativeText = $title;
		}

		// Prepare image
		$image        = wp_get_attachment_image_src($attachment->ID);
		$imageSrc     = '';
		$displaySlide = true;

		if (!is_array($image) ||
			!$image)
		{
			if (!empty($attachment->guid))
			{
				$imageSrc = $attachment->guid;
			}
			else
			{
				$displaySlide = false;
			}
		}
		else
		{
			$imageSrc = $image[0];
		}

		if (!$imageSrc ||
			empty($imageSrc))
		{
			$imageSrc = PSG_PGMain::getPluginUrl() . '/images/' . __CLASS__ . '/no-img.png';
		}

		$editUrl = admin_url() . '/media.php?attachment_id=' . (int)$attachment->ID . '&amp;action=edit';

		if ($displaySlide): ?>
		<div class="pg-list-item sortable-slides-list-item">
	<div class="slideshow-group slideshow-delete-slide">
						<span><a><?php _e('Delete', 'portfolio-gallery'); ?></a></span>
					</div>
			<div id="<?php echo esc_attr($data->index);?>" class="widefat  postbox closed">

				<div class="handlediv" title="<?php _e('Click to toggle'); ?>"><span class="toggle-indicator" aria-hidden="true"></span></div>

				<div class="hndle">
					<div class="slide-icon image-slide-icon"></div>
					<div class="slide-title">
						<?php if (strlen($title) > 0) : ?>

							<?php echo esc_html($title); ?>

						<?php else : ?>

							<?php _e('Image', 'portfolio-gallery'); ?>

						<?php endif; ?>
						
					
					</div>
					<div class="clear"></div>
				</div>

				<div class="inside">

					<div class="slideshow-group">

						<a href="<?php echo esc_url($editUrl); ?>" title="<?php _e('Edit', 'portfolio-gallery'); ?> &#34;<?php echo esc_attr($attachment->post_title); ?>&#34;">
							<img width="80"  src="<?php echo esc_url($imageSrc); ?>" class="attachment attachment-80x60" alt="<?php echo esc_attr($attachment->post_title); ?>" title="<?php echo esc_html($attachment->post_title); ?>" />
						</a><br>
	<input type="button" class="mediachange" id="<?php echo esc_attr($data->index);?>" Value="Change Image">
					</div>
<div class="clear"></div>
					<div class="slideshow-group">

						<div class="slideshow-left slideshow-label"><?php _e('Title', 'portfolio-gallery'); ?></div>

						<div class="clear"></div>
						<input class="title" type="text" name="<?php echo esc_attr($name); ?>[title]" value="<?php echo esc_html($title); ?>" style="width: 100%;" />

					</div>

					<div class="slideshow-group">

						<div class="slideshow-left slideshow-label"><?php _e('Description', 'portfolio-gallery'); ?></div>
						<div class="slideshow-right">

						</div>
						<div clear="clear"></div>
						<?php wp_editor( $description, 'listingeditor'. $attachment->ID, $settings = array('textarea_name' => $name.'[description]','media_buttons' => false,'editor_height' => 155) ); ?>


					</div>

					<div class="slideshow-group">

						<div class="slideshow-label"><?php _e('URL', 'portfolio-gallery'); ?></div>
						<input type="text" name="<?php echo esc_attr($name); ?>[url]" value="<?php echo esc_url($url); ?>" style="width: 100%;" />

						<div class="slideshow-label slideshow-left"><?php _e('Open URL in', 'portfolio-gallery'); ?></div>
						<select name="<?php echo esc_attr($name); ?>[urlTarget]" class="urlTarget  slideshow-right">
							<option value="_self" <?php selected('_self', $target); ?>><?php _e('Same window', 'portfolio-gallery'); ?></option>
							<option value="_blank" <?php selected('_blank', $target); ?>><?php _e('New window', 'portfolio-gallery'); ?></option>
						</select>
						<div class="clear"></div>

						<div class="slideshow-label slideshow-left"><?php _e('Don\'t let search engines follow link', 'portfolio-gallery'); ?></div>
		                <input type="checkbox" name="<?php echo esc_attr($name); ?>[noFollow]" value="" <?php checked($noFollow); ?> class="slideshow-right" />
						<div class="clear"></div>

		            </div>

					<div class="slideshow-group">

						<div class="slideshow-label"><?php _e('Alternative text', 'portfolio-gallery'); ?></div>
						<input class='alternativeText' type="text" name="<?php echo esc_attr($name); ?>[alternativeText]" value="<?php echo esc_html($alternativeText); ?>" style="width: 100%;" />

					</div>

				

					<input class="type" type="hidden" name="<?php echo esc_attr($name); ?>[type]" value="attachment" />
					<input class="postId" type="hidden" name="<?php echo esc_attr($name); ?>[postId]" value="<?php echo esc_attr($attachment->ID); ?>" />

				</div>

			</div>
			</div>

		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>
