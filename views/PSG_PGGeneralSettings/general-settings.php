<?php

if ($data instanceof stdClass) :

	// Path to the General Settings' views folder
	$generalSettingsViewsPath = PSG_PGMain::getPluginPath() . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'PGGeneralSettings' . DIRECTORY_SEPARATOR;

	?>

	<div class="wrap">
		<form method="post" action="options.php">
			<?php settings_fields(PSG_PGGeneralSettings::$settingsGroup); ?>

			<div class="icon32" style="background: url('<?php echo PSG_PGMain::getPluginUrl() . '/images/PGPostType/adminIcon32.png'; ?>');"></div>
			<h2 class="nav-tab-wrapper">
				<a href="#general-settings-tab" class="nav-tab nav-tab-active"><?php _e('General Settings', 'portfolio-gallery'); ?></a>
				<a href="#default-slideshow-settings-tab" class="nav-tab"><?php _e('Default Settings', 'portfolio-gallery'); ?></a>
				

				<?php submit_button(null, 'primary', null, false, 'style="float: right;"'); ?>
			</h2>

			<?php

			// General Settings
			PSG_PGMain::outputView('PSG_PGGeneralSettings' . DIRECTORY_SEPARATOR . 'general-settings-tab.php');

			// Default slideshow settings
			PSG_PGMain::outputView('PSG_PGGeneralSettings' . DIRECTORY_SEPARATOR . 'default-slideshow-settings-tab.php');

			// Custom styles
			//PSG_PGMain::outputView('PGGeneralSettings' . DIRECTORY_SEPARATOR . 'custom-styles-tab.php');

			?>

			<p>
				<?php submit_button(null, 'primary', null, false); ?>
			</p>
		</form>
	</div>
<?php endif; ?>