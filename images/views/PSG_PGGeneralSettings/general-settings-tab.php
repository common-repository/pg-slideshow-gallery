<?php

if ($data instanceof stdClass) :

	// General settings
	$stylesheetLocation = PSG_PGGeneralSettings::getStylesheetLocation();
	$enableLazyLoading  = PSG_PGGeneralSettings::getEnableLazyLoading();

	// Roles
	global $wp_roles;

	// Capabilities
	$capabilities = array(
		PSG_PGGeneralSettings::$capabilities['addSlideshows']    => __('Add Gallery', 'portfolio-gallery'),
		PSG_PGGeneralSettings::$capabilities['editSlideshows']   => __('Edit Gallery', 'portfolio-gallery'),
		PSG_PGGeneralSettings::$capabilities['deleteSlideshows'] => __('Delete Gallery', 'portfolio-gallery')
	);

	?>

	<div class="general-settings-tab feature-filter">

		<h4><?php _e('User Capabilities', 'portfolio-gallery'); ?></h4>

		<p><?php _e('Select the user roles that will able to perform certain actions.', 'portfolio-gallery');  ?></p>

		<table>

			<?php foreach($capabilities as $capability => $capabilityName): ?>

			<tr valign="top">
				<th><?php echo esc_html($capabilityName); ?></th>
				<td>
					<?php

					if(isset($wp_roles->roles) && is_array($wp_roles->roles)):
						foreach($wp_roles->roles as $roleSlug => $values):

							$disabled = ($roleSlug == 'administrator') ? 'disabled="disabled"' : '';
							$checked = ((isset($values['capabilities']) && array_key_exists($capability, $values['capabilities']) && $values['capabilities'][$capability] == true) || $roleSlug == 'administrator') ? 'checked="checked"' : '';
							$name = (isset($values['name'])) ? htmlspecialchars($values['name']) : __('Untitled role', 'portfolio-gallery');

							?>

							<input
								type="checkbox"
								name="<?php echo htmlspecialchars($capability); ?>[<?php echo htmlspecialchars($roleSlug); ?>]"
								id="<?php echo htmlspecialchars($capability . '_' . $roleSlug); ?>"
								<?php echo $disabled; ?>
								<?php echo $checked; ?>
							/>
							<label for="<?php echo htmlspecialchars($capability . '_' . $roleSlug); ?>"><?php echo esc_html($name); ?></label>
							<br />

							<?php endforeach; ?>
						<?php endif; ?>

				</td>
			</tr>

			<?php endforeach; ?>

		</table>
	</div>

	<div class="general-settings-tab feature-filter">

		<h4><?php _e('Settings', 'portfolio-gallery'); ?></h4>

		<table>
			<tr>
				<td><?php _e('Stylesheet location', 'portfolio-gallery'); ?></td>
				<td>
					<select name="<?php echo esc_attr(PSG_PGGeneralSettings::$stylesheetLocation); ?>">
						<option value="head" <?php selected('head', $stylesheetLocation); ?>>Head (<?php _e('top', 'portfolio-gallery'); ?>)</option>
						<option value="footer" <?php selected('footer', $stylesheetLocation); ?>>Footer (<?php _e('bottom', 'portfolio-gallery'); ?>)</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><?php _e('Enable lazy loading', 'portfolio-gallery'); ?></td>
				<td>
					<input type="radio" name="<?php echo esc_attr(PSG_PGGeneralSettings::$enableLazyLoading); ?>" <?php checked(true, $enableLazyLoading); ?> value="true" /> <?php _e('Yes', 'portfolio-gallery'); ?>
					<input type="radio" name="<?php echo esc_attr(PSG_PGGeneralSettings::$enableLazyLoading); ?>" <?php checked(false, $enableLazyLoading); ?> value="false" /> <?php _e('No', 'portfolio-gallery'); ?>
				</td>
			</tr>
		</table>

	</div>
<?php endif; ?>