<?php if ($data instanceof stdClass) : ?>

	<div class="slideshow_container_<?php echo htmlspecialchars($data->styleName); ?>"  data-slideshow-id="<?php echo htmlspecialchars($data->post->ID); ?>" data-style-name="<?php echo htmlspecialchars($data->styleName); ?>" data-style-version="<?php echo htmlspecialchars($data->styleVersion); ?>" <?php if (PSG_PGGeneralSettings::getEnableLazyLoading()) : ?>data-settings="<?php echo htmlspecialchars(json_encode($data->settings)); ?>"<?php endif; ?>>



 <div class="skitter skitter-large<?php echo $data->post->ID;?>" id="bx<?php echo $data->post->ID;?>" >
<ul>
			<?php



			if (is_array($data->slides) && count($data->slides) > 0)
			{
				$i = 0;

			
					for ($i; $i < count($data->slides); $i++)
					{
						$slideData             = new stdClass();
						$slideData->properties = $data->slides[$i];
						$slideData->settings = $data->settings;
						PSG_PGMain::outputView('PSG_PGSlideshowSlide' . DIRECTORY_SEPARATOR . 'skitterfrontend_' . $data->slides[$i]['type'] . '.php', $slideData);

						
					}


			
				
			}

			?>
</ul>
		</div>


	
		<?php if(is_array($data->log) && count($data->log) > 0): ?>
		<!-- Error log
		<?php foreach($data->log as $logMessage): ?>
			- <?php echo htmlspecialchars($logMessage); ?>
		<?php endforeach; ?>
		-->
		<?php endif; ?>
	</div>

<?php endif; ?>