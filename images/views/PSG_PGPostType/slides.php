<?php if ($data instanceof stdClass) : ?>

	<p style="text-align: Left; font-style: italic"><?php _e('Addnew', 'portfolio-gallery'); ?>  :
	  
		<input type="image"  	title="Insert Image"   value='' border="0" class="slideshow-insert-image-slide" />
		<input type="image"  	title="Insert Text"    value='' border="0"  class="slideshow-insert-text-slide" />
		<input type="image"  	title="Insert YT Video"  value=''  border="0"  class="slideshow-insert-video-slide" />
	</p>

	<p style="text-align: right;">
		<a href="#" class="open-slides-button"><?php _e('Open all', 'portfolio-gallery'); ?></a> |
		<a href="#" class="close-slides-button"><?php _e('Close all', 'portfolio-gallery'); ?></a>
	</p>

	<?php if (count($data->slides) <= 0) : ?>
		<p><?php _e('Add slides to this slideshow by using one of the buttons above.', 'portfolio-gallery'); ?></p>
	<?php endif; ?>

	<div class="sortable-slides-list">
	<?php

		if (is_array($data->slides))
		{
			
			
			$i = 0;

			foreach ($data->slides as $slide)
			{
				
				$data             = new stdClass();
				$data->name       = PSG_PGSlideshowSettingsHandler::$slidesKey . '[' . $i . ']';
				$data->properties = $slide;
$data->index=$i;
				PSG_PGMain::outputView('PSG_PGSlideshowSlide' . DIRECTORY_SEPARATOR . 'backend_' . $slide['type'] . '.php', $data);

				$i++;
			}
		}

		?>

	</div>

	<?php PSG_PGMain::outputView('PSG_PGSlideshowSlide' . DIRECTORY_SEPARATOR . 'backend_templates.php'); ?>

<?php endif; ?>