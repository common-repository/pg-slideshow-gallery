<?php if ($data instanceof stdClass) : ?>

<div id="pgssubtabs">

<nav class="nav-tab-wrapper">
      <a href="#pgs-slideshow"  id="pgntpgs-slideshow" class="nav-tab nav-tab-active" onclick="ShowPGSubTab('pgs-slideshow');">As Slideshow</a>
      <a href="#pgs-gallery" id="pgntpgs-gallery" class="nav-tab" onclick="ShowPGSubTab('pgs-gallery');">As Gallery</a>
   <a href="#pgs-skitter"  id="pgntpgs-skitter" class="nav-tab" onclick="ShowPGSubTab('pgs-skitter');">As Animated Slideshow</a>
 <a href="#pgs-theme"  id="pgntpgs-theme" class="nav-tab" onclick="ShowPGSubTab('pgs-theme');">Theme Options </a>
    </nav>


    <div id="pgs-slideshow" class="PGsubtab-content PGActiveTab">
	
		<p><?php _e('To use this slideshow in your website, add these shortcode to your posts or pages', 'portfolio-gallery'); ?>:</p>
	<p style="font-style: italic;"><?php echo esc_html($data->shortCode); ?>(bxSlider Slideshow)<br>
	<?php echo esc_html($data->shortCode1); ?>(bxSlider Slideshow)<br>
	<p><?php _e('Or insert Slideshow-Gallery block in the Gutenberg editor and select its type.', 'portfolio-gallery'); ?>:</p>
</p>

	<table>
		<?php $groups = array(); ?>
		<?php if(count($data->settings) > 0): ?>
		<?php foreach($data->settings as $key => $value): ?>

		<?php if($value['group']!="Slideshow") continue;  if( !isset($value, $value['type'], $value['default'], $value['description']) || !is_array($value)) continue; ?>

		<?php if(!empty($value['group']) && !isset($groups[$value['group']]) ): $groups[$value['group']] = true; ?>
		<tr>
			<td colspan="3" style="border-bottom: 1px solid #e5e5e5; text-align: center;">
				<span style="display: inline-block; position: relative; top: 14px; padding: 0 12px;   background-color:#BCCDEF;">
					<?php echo esc_html($value['group']); ?> <?php _e('settings', 'portfolio-gallery'); ?>
				</span>
			</td>
		</tr>
		<tr>
			<td colspan="3"></td>
		</tr>
		<?php endif; ?>
		<tr
			<?php echo !empty($value['group'])? 'class="group-' . strtolower(str_replace(' ', '-', $value['group'])) . '"': ''; ?>
			<?php echo !empty($value['dependsOn'])? 'style="display:none;"': ''; ?>
		>
			<td><?php echo wp_kses_post($value['description']); ?></td>
			<td><?php  echo PSG_PGSlideshowSettingsHandler::getInputField(PSG_PGSlideshowSettingsHandler::$settingsKey, htmlspecialchars($key), $value); ?></td>
			<td></td>
		</tr>

		<?php endforeach; ?>
		<?php endif; ?>
	</table>
  </div>
	
	
	<div id="pgs-gallery" class="PGsubtab-content PGHiddenTab">
		<p><?php _e('To use this slideshow in your website, add these shortcode to your posts or pages', 'portfolio-gallery'); ?>:</p>
	<p style="font-style: italic;"><?php echo esc_html($data->shortCode2); ?>(Gallery with Lightbox)<br>
	</p>
	<p><?php _e('Or insert Slideshow-Gallery block in the Gutenberg editor and select its type.', 'portfolio-gallery'); ?>:</p>
	
	
		<table>
		<?php $groups = array(); ?>
		<?php if(count($data->settings) > 0): ?>
		<?php foreach($data->settings as $key => $value): ?>

		<?php if($value['group']!="Gallery") continue;  if( !isset($value, $value['type'], $value['default'], $value['description']) || !is_array($value)) continue; ?>

		<?php if(!empty($value['group']) && !isset($groups[$value['group']])  ): $groups[$value['group']] = true; ?>
		<tr>
			<td colspan="3" style="border-bottom: 1px solid #e5e5e5; text-align: center;">
				<span style="display: inline-block; position: relative; top: 14px; padding: 0 12px;   background-color:#BCCDEF;">
					<?php echo esc_html($value['group']); ?> <?php _e('settings', 'portfolio-gallery'); ?>
				</span>
			</td>
		</tr>
		<tr>
			<td colspan="3"></td>
		</tr>
		<?php endif; ?>
		<tr
			<?php echo !empty($value['group'])? 'class="group-' . strtolower(str_replace(' ', '-', $value['group'])) . '"': ''; ?>
			<?php echo !empty($value['dependsOn'])? 'style="display:none;"': ''; ?>
		>
			<td><?php echo wp_kses_post($value['description']); ?></td>
			<td><?php  echo PSG_PGSlideshowSettingsHandler::getInputField(PSG_PGSlideshowSettingsHandler::$settingsKey, htmlspecialchars($key), $value); ?></td>
			<td></td>
		</tr>

		<?php endforeach; ?>
		<?php endif; ?>
	</table>
    </div>
	
	
		
	<div id="pgs-skitter" class="PGsubtab-content PGHiddenTab">
		<p><?php _e('To use this slideshow in your website, add these shortcode to your posts or pages', 'portfolio-gallery'); ?>:</p>
	<p style="font-style: italic;"><?php echo esc_html($data->shortCode3); ?> (For images only slideshows with multiple animation effects)<br>
	</p>
	<p><?php _e('Or insert Slideshow-Gallery block in the Gutenberg editor and select its type.', 'portfolio-gallery'); ?>:</p>
	
	<p>
	<b>Skitter Animation Styles:</b> cube,cubeRandom,block,cubeStop,cubeStopRandom,cubeHide,cubeSize,horizontal,<br>showBars,showBarsRandom,tube,fade,fadeFour,paralell,blind,blindHeight,blindWidth,directionTop,directionBottom,<br>directionRight,directionLeft,cubeSpread,glassCube,glassBlock,circles,circlesInside,circlesRotate,cubeShow,upBars,<br>
	downBars,hideBars,swapBars,swapBarsBack,swapBlocks,cut
	</p>
	
		<table>
		<?php $groups = array(); ?>
		<?php if(count($data->settings) > 0): ?>
		<?php foreach($data->settings as $key => $value): ?>

		<?php if($value['group']!="Skitter") continue; if( !isset($value, $value['type'], $value['default'], $value['description']) || !is_array($value)) continue; ?>

		<?php if(!empty($value['group']) && !isset($groups[$value['group']]) ): $groups[$value['group']] = true; ?>
		<tr>
			<td colspan="3" style="border-bottom: 1px solid #e5e5e5; text-align: center;">
				<span style="display: inline-block; position: relative; top: 14px; padding: 0 12px;   background-color:#BCCDEF;">
					<?php echo esc_html($value['group']); ?> <?php _e('settings', 'portfolio-gallery'); ?>
				</span>
			</td>
		</tr>
		<tr>
			<td colspan="3"></td>
		</tr>
		<?php endif; ?>
		<tr
			<?php echo !empty($value['group'])? 'class="group-' . strtolower(str_replace(' ', '-', $value['group'])) . '"': ''; ?>
			<?php echo !empty($value['dependsOn'])? 'style="display:none;"': ''; ?>
		>
			<td><?php echo wp_kses_post($value['description']); ?></td>
			<td><?php  echo PSG_PGSlideshowSettingsHandler::getInputField(PSG_PGSlideshowSettingsHandler::$settingsKey, htmlspecialchars($key), $value); ?></td>
			<td></td>
		</tr>

		<?php endforeach; ?>
		<?php endif; ?>
	</table>
    </div>
	
	







 <div id="pgs-theme" class="PGsubtab-content PGHiddenTab">
	

<div><h2>--------------Style Theme Settings----------------</2></div>
<?php 

global $post;

		$data           = new stdClass();
		$data->settings = PSG_PGSlideshowSettingsHandler::getStyleSettings($post->ID, true);

		PSG_PGMAIN::outputView(__CLASS__ . DIRECTORY_SEPARATOR . 'style-settings.php', $data);


if ($data instanceof stdClass) : ?>
	<table>
		<?php if(count($data->settings) > 0): $i = 0; ?>

		<?php foreach($data->settings as $key => $value): ?>

		<?php if( !isset($value, $value['type'], $value['default'], $value['description']) || !is_array($value)) continue; ?>

		<tr <?php if(isset($value['dependsOn'])) echo 'style="display:none;"'; ?>>
			<td><?php echo wp_kses_post($value['description']); ?></td>
			<td><?php echo PSG_PGSlideshowSettingsHandler::getInputField(htmlspecialchars(PSG_PGSlideshowSettingsHandler::$styleSettingsKey), $key, $value); ?></td>
			<td><?php _e('Default', 'portfolio-gallery'); ?>: &#39;<?php echo (isset($value['options']) )? esc_html($value['options'][$value['default']]): esc_html($value['default']); ?>&#39;</td>
		</tr>

		<?php endforeach; ?>

		<?php endif; ?>
	</table>

	<p>
		<?php
			echo sprintf(__(
					'Style css files are inside the plugin->css folder',
					'portfolio-gallery'
				),
				'',
				''
			);
		?>
	</p>
<?php endif; ?>


</div>

	</div>
	
	

<?php endif; ?>

