<?php if ($data instanceof stdClass) : ?>

	<a
		href="#TB_inline?width=450&inlineId=insertSlideshowShortcode"
		class="button thickbox"
		title="<?php _e('Insert a Gallery', 'portfolio-gallery'); ?>"
	    style="padding-left: .4em;"
	>
		<img
			src="<?php echo PSG_PGMain::getPluginUrl() . '/images/PGPostType/adminIcon.png'; ?>"
			alt="<?php _e('Insert a Gallery', 'portfolio-gallery'); ?>"
		    style="vertical-align: text-top;"
		/>
		<?php _e('Insert Gallery', 'portfolio-gallery'); ?>
	</a>

	<div id="insertSlideshowShortcode" style="display: none;">

		<h3 style="padding: 10px 0; color: #5a5a5a;">
			<?php _e('Insert a Slideshow', 'portfolio-gallery'); ?>
		</h3>

		<div style="border: 1px solid #ddd; padding: 10px; color: #5a5a5a;">

			<?php if($data->slideshows instanceof WP_Query && count($data->slideshows->get_posts()) > 0): ?>
			<table>
				<tr>

					<td><?php _e('Select a Gallery', 'portfolio-gallery'); ?></td>
					<td>
						<select id="insertSlideshowShortcodeSlideshowSelect">

							<?php foreach($data->slideshows->get_posts() as $slideshow): ?>

							<?php if(!is_numeric($slideshow->ID)) continue; ?>

							<option value="<?php echo $slideshow->ID; ?>">
								<?php echo (!empty($slideshow->post_title)) ? htmlspecialchars($slideshow->post_title) : __('Untitled slideshow', 'portfolio-gallery'); ?>
							</option>

							<?php endforeach; ?>

						</select>
					</td>

				</tr>
				<tr>

					<td>
						<input
							type="button"
							class="button-primary insertSlideshowShortcodeSlideshowInsertButton"
							value="<?php _e('Insert Gallery', 'portfolio-gallery'); ?>"
						/>
						<input
							type="button"
							class="button insertSlideshowShortcodeCancelButton"
						    value="<?php _e('Cancel', 'portfolio-gallery'); ?>"
						/>
					</td>

				</tr>
			</table>

			<?php else: ?>

			<p>
				<?php echo sprintf(
					__('It seems you haven\'t created any galleries yet. %sYou can create a gallery here!%s', 'portfolio-gallery'),
					'<a href="' . admin_url('post-new.php?post_type=' . PGPostType::$postType) . '" target="_blank">',
					'</a>'
				); ?>
			</p>

			<?php endif; ?>

	    </div>
	</div>
<?php endif; ?>