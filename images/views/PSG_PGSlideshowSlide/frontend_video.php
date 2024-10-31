<?php

if ($data instanceof stdClass) :

	$properties = $data->properties;
$settings=$data->settings;

	$videoId           = '';
	$showRelatedVideos = 0;

	if (isset($properties['videoId']))
	{
		$videoId = htmlspecialchars($properties['videoId']);
	}

	if (isset($properties['showRelatedVideos']) && $properties['showRelatedVideos'] === 'true')
	{
		$showRelatedVideos = 1;
	}

	// If the video ID contains 'v=', it means a URL has been passed. Retrieve the video ID.
	$idPosition = null;

	if (($idPosition = stripos($videoId, 'v=')) !== false)
	{
		// The video ID, which perhaps still has some arguments behind it.
		$videoId = substr($videoId, $idPosition + 2);

		// Explode on extra arguments (&).
		$videoId = explode('&', $videoId);

		// The first element is the video ID
		if (is_array($videoId) && isset($videoId[0]))
		{
			$videoId = $videoId[0];
		}
	}
	 $atts='';
	

	if($settings['vheight']) $atts.=' vh="'.(int)$settings['vheight'].'"';
	if($settings['vwidth']) $atts.=' vw="'.(int)$settings['vwidth'].'"';

	?>

	<div class="slideshow_slide slideshow_slide_video" style="<?php if($settings['vheight']) echo "height:".(int)$settings['vheight']."px;";if($settings['vwidth']) echo "width:".(int)$settings['vwidth']."px;";?>">
		<div class="slideshow_slide_video_id" style="display: none;" data-show-related-videos="<?php echo esc_attr($showRelatedVideos); ?>" <?php echo esc_attr($atts);?>><?php echo esc_attr($videoId); ?></div>
	</div>
<?php endif; ?>