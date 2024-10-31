<?php if ($data instanceof stdClass) : ?>


	<div class="text-slide-template" style="display: none;">
			<div class="pg-list-item sortable-slides-list-item">
			<div class="slideshow-group slideshow-delete-slide">
					<span><a><?php _e('Delete', 'portfolio-gallery'); ?></a></span>
				</div>
		<div class="widefat  postbox">

			<div class="handlediv" title="<?php _e('Click to toggle'); ?>"><br></div>

			<div class="hndle">
				<div class="slide-icon text-slide-icon"></div>
				<div class="slide-title">
					<?php _e('New Text content', 'portfolio-gallery'); ?>
				</div>
				<div class="clear"></div>
			</div>

			<div class="inside">

				<div class="slideshow-group">

					<div class="slideshow-left slideshow-label"><?php _e('Title', 'portfolio-gallery'); ?></div>
					<div class="slideshow-right">
									</div>
					<div class="clear"></div>
					<input type="text" class="title" style="width: 100%;" />

				</div>

				<div class="slideshow-group">

					<div class="slideshow-left slideshow-label"><?php _e('Description', 'portfolio-gallery'); ?></div>
					<div class="slideshow-right">

					</div>
					<div clear="clear"></div>
					<textarea class="description" cols="" rows="7" style="width: 100%;"></textarea>
						<?php //wp_editor( $description, 'listingeditor'. $data->index, $settings = array('textarea_name' => $name.'[description]','media_buttons' => false,'editor_height' => 155) ); ?>
				</div>

				<div class="slideshow-group">

					<div class="slideshow-label"><?php _e('Text color', 'portfolio-gallery'); ?></div>
					<input type="text" class="textColor" value="000000" />
					<div class="slideshow-label"><?php _e('Background color', 'portfolio-gallery'); ?></div>
					<input type="text" class="color" value="FFFFFF" />
					<div style="font-style: italic;"><?php _e('(Leave empty for a transparent background)', 'portfolio-gallery'); ?></div>

				</div>

				<div class="slideshow-group">

					<div class="slideshow-label"><?php _e('URL', 'portfolio-gallery'); ?></div>
					<input type="text" class="url" value="" style="width: 100%;" />

					<div class="slideshow-label slideshow-left"><?php _e('Open URL in', 'portfolio-gallery'); ?></div>
					<select class="urlTarget slideshow-right">
						<option value="_self"><?php _e('Same window', 'portfolio-gallery'); ?></option>
						<option value="_blank"><?php _e('New window', 'portfolio-gallery'); ?></option>
					</select>
					<div class="clear"></div>

					<div class="slideshow-label slideshow-left"><?php _e('Don\'t let search engines follow link', 'portfolio-gallery'); ?></div>
		            <input type="checkbox" class="noFollow slideshow-right" />
					<div class="clear"></div>

		        </div>

			

				<input type="hidden" class="type" value="text" />

			</div>

		</div>
		</div>
	</div>

	<div class="video-slide-template" style="display: none;">
	
			<div class="pg-list-item sortable-slides-list-item">
				<div class="slideshow-group slideshow-delete-slide">
					<span><a><?php _e('Delete', 'portfolio-gallery'); ?></a></span>
				</div>
		<div class="widefat postbox">

			<div class="handlediv" title="<?php _e('Click to toggle'); ?>"><br></div>

			<div class="hndle">
				<div class="slide-icon video-slide-icon"></div>
				<div class="slide-title">
					<?php _e('New Youtube Video', 'portfolio-gallery'); ?>
				</div>
				<div class="clear"></div>
			</div>

			<div class="inside">

				<div class="slideshow-group">

					<div class="slideshow-label"><?php _e('Youtube Video ID', 'portfolio-gallery'); ?></div>
					<input type="text" class="videoId" style="width: 100%;" />

				</div>
				<div class="slideshow-group">
<div class="slideshow-label"><?php _e('Title', 'portfolio-gallery'); ?></div>
	<input type="text" class="title"  value="" style="width: 100%;" /><br />
</div>
				<div class="slideshow-group">
<div class="slideshow-label"><?php _e('Description', 'portfolio-gallery'); ?></div>
	<input type="text" class="description" value="" style="width: 100%;" /><br />
</div>
				<div class="slideshow-group">

					<div class="slideshow-label"><?php _e('Show related videos', 'portfolio-gallery'); ?></div>
					<label><input type="radio" class="showRelatedVideos" value="true"><?php _e('Yes', 'portfolio-gallery'); ?></label>
					<label><input type="radio" class="showRelatedVideos" value="false" checked="checked"><?php _e('No', 'portfolio-gallery'); ?></label>

				</div>


				<input type="hidden" class="type" value="video" />

			</div>

		</div>
	</div>

</div>



	<div class="image-slide-template" style="display: none;">
		<div class="pg-list-item sortable-slides-list-item">
				<div class="slideshow-group slideshow-delete-slide">
					<span><a><?php _e('Delete', 'portfolio-gallery'); ?></a></span>
				</div>
		<div class="widefat postbox">
	
			<div class="handlediv" title="<?php _e('Click to toggle'); ?>"><br></div>

			<div class="hndle">
				<div class="slide-icon image-slide-icon"></div>
				<div class="slide-title">
					<?php _e('New Image', 'portfolio-gallery'); ?>
				</div>
				<div class="clear"></div>
			</div>

			<div class="inside">

				<div class="slideshow-group">

					<img width="80"  src="" class="attachment attachment-80x60" alt="" title="" style="float: none; margin: 0; padding: 0;" />

				</div>

				<div class="slideshow-group">

					<div class="slideshow-left slideshow-label"><?php _e('Title', 'portfolio-gallery'); ?></div>
					<div class="slideshow-right">

					</div>
					<div class="clear"></div>
					<input type="text" class="title" style="width: 100%;" />

				</div>

				<div class="slideshow-group">

					<div class="slideshow-left slideshow-label"><?php _e('Description', 'portfolio-gallery'); ?></div>
					<div class="slideshow-right">

					</div>
					<div class="clear"></div>
					<textarea class="description" rows="3" cols="" style="width: 100%;"></textarea><br />

				</div>

				<div class="slideshow-group">

					<div class="slideshow-label"><?php _e('URL', 'portfolio-gallery'); ?></div>
					<input type="text" class="url" value="" style="width: 100%;" /><br />

					<div class="slideshow-label slideshow-left"><?php _e('Open URL in', 'portfolio-gallery'); ?></div>
					<select class="urlTarget slideshow-right">
						<option value="_self"><?php _e('Same window', 'portfolio-gallery'); ?></option>
						<option value="_blank"><?php _e('New window', 'portfolio-gallery'); ?></option>
					</select>
					<div class="clear"></div>

					<div class="slideshow-label slideshow-left"><?php _e('Don\'t let search engines follow link', 'portfolio-gallery'); ?></div>
		            <input type="checkbox" class="noFollow slideshow-right" />

		        </div>

				<div class="slideshow-group">

					<div class="slideshow-label"><?php _e('Alternative text', 'portfolio-gallery'); ?></div>
					<input type="text" class="alternativeText" style="width: 100%;" />

				</div>

	

				<input type="hidden" class="type" value="attachment" />
				<input type="hidden" class="postId" value="" />

			</div>

		</div>
	</div>
	</div>
<?php endif; ?>