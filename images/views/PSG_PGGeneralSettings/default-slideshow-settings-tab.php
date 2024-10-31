<?php

if ($data instanceof stdClass) :

	// Default settings
	$defaultSettings      = PSG_PGSlideshowSettingsHandler::getDefaultSettings(true);
	$defaultStyleSettings = PSG_PGSlideshowSettingsHandler::getDefaultStyleSettings(true);


	?>

	<div class="default-slideshow-settings-tab" style="display: none; float: none;">
		<p>
			<strong><?php _e('Note', 'portfolio-gallery'); ?>:</strong>
		</p>

		<p style="width: 500px;">
			<?php

			echo sprintf(__(
				'The settings set on this page apply only to newly created slideshows and therefore do not alter any existing ones. To adapt a slideshow\'s settings, %sclick here.%s', 'portfolio-gallery'),
				'<a href="' . get_admin_url(null, 'edit.php?post_type=' . PSG_PGPostType::$postType) . '">',
				'</a>'
			);

			?>
		</p>
	</div>

	<div class="default-slideshow-settings-tab feature-filter" style="display: none;">

		<h4><?php _e('Default Settings', 'portfolio-gallery'); ?></h4>

		<table>

			<?php $groups = array(); ?>
			<?php foreach($defaultSettings as $defaultSettingKey => $defaultSettingValue): ?>

			<?php if(!empty($defaultSettingValue['group']) && !isset($groups[$defaultSettingValue['group']])): $groups[$defaultSettingValue['group']] = true; ?>

			<tr>
				<td colspan="3" style="border-bottom: 1px solid #dfdfdf; text-align: center;">
					<span style="display: inline-block; position: relative; top: 14px; padding: 0 12px; background: #fff;">
						<?php echo esc_html($defaultSettingValue['group']); ?> <?php _e('settings', 'portfolio-gallery'); ?> <?php if($defaultSettingValue['grouphelper']) echo esc_html($defaultSettingValue['grouphelper']);?>
					</span>
				</td>
			</tr>
			<tr>
				<td colspan="3"></td>
			</tr>

			<?php endif; ?>

			<tr>
				<td>
					<?php echo esc_html($defaultSettingValue['description']); ?>
				</td>
				<td>
					<?php

					echo PSG_PGSlideshowSettingsHandler::getInputField(
						PSG_PGGeneralSettings::$defaultSettings,
						$defaultSettingKey,
						$defaultSettingValue,
						/* hideDependentValues = */ false
					);

					?>
				</td>
			</tr>

			<?php endforeach; ?>
			<?php unset($groups); ?>

		</table>
	</div>

	<div class="default-slideshow-settings-tab feature-filter" style="display: none;">

		<h4><?php _e('Default Stylesheet', 'portfolio-gallery'); ?></h4>

		<table>

			<?php



			foreach($defaultStyleSettings as $defaultStyleSettingKey => $defaultStyleSettingValue): ?>

			<tr>
				<td>
					<?php echo esc_html($defaultStyleSettingValue['description']); ?>
				</td>
				<td>
					<?php

					echo PSG_PGSlideshowSettingsHandler::getInputField(
						PSG_PGGeneralSettings::$defaultStyleSettings,
						$defaultStyleSettingKey,
						$defaultStyleSettingValue,
						/* hideDependentValues = */ false
					);

					?>
				</td>
			</tr>

			<?php endforeach; ?>

		</table>
	</div>

	<div style="clear: both;"></div>
<?php endif; ?>