<?php

if ($data instanceof stdClass) :

	$properties = $data->properties;

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


	if (isset($properties['title']))
	{
		$title = htmlspecialchars($properties['title']);
	}
	
	
	if (isset($properties['videoId']))
	{
		$description = htmlspecialchars($properties['description']);
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

		
	if($data->settings['glightbox'])
{ ?>
	<li class="slideshow_slide slideshow_slide_video <?php echo esc_attr($data->settings['galignment']);?>">
		<a href="https://youtu.be/<?php echo (int)$videoId; ?>" class="glightbox<?php echo (int)$data->postid;?>" data-gallery="gallery<?php echo (int)$data->postid;?>"  data-glightbox="title: <?php echo esc_html($title);?> description: <?php echo wp_kses_post($description);?> "><img src="https://img.youtube.com/vi/<?php echo (int)$videoId; ?>/3.jpg"></a>
		
					<?php if($title || $description){?>
						<?php echo (!empty($title)&& $data->settings['galleryTitle']) ? '<div><b>'. esc_html($title) .'</b></div>' : ''; ?>
						<?php echo (!empty($description) && $data->settings['galleryDesc']) ? '<div>'.esc_html($data->settings['galleryDesc']). wp_kses_post($description) .'</div>': ''; ?>
					<?php } ?>

	</li>
<?php 
}else{ ?>
<li class="slideshow_slide slideshow_slide_video <?php echo esc_attr($data->settings['galignment']);?>">
		<div class="slideshow_slide_video_id" style="display: none;" data-show-related-videos="<?php echo esc_attr($showRelatedVideos); ?>"><?php echo esc_html($videoId); ?></div>
	</li>
<?php } 
	

endif; ?>