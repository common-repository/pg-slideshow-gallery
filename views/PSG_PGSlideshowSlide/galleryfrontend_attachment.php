<?php
$allowed_html = [
    'a'      => [
        'href'  => [],
        'title' => [],'rel' => [],'style' => [],'target' => [],
    ],
    'br'     => [],
    'em'     => [],
    'strong' => [],
];
if ($data instanceof stdClass):

	$properties = $data->properties;

	$title = $description = $url = $urlTarget = $alternativeText = $noFollow = $postId = '';

	$titleElementTag = $descriptionElementTag = PSG_PGSlideInserter::getElementTag();

	if (isset($properties['title']))
	{
		$title = trim(PSG_PGSecurity::htmlspecialchars_allow_exceptions($properties['title']));
	}

	if (isset($properties['titleElementTagID']))
	{
		$titleElementTag = PSG_PGSlideInserter::getElementTag($properties['titleElementTagID']);
	}

	if (isset($properties['description']))
	{
		$description = trim(PSG_PGSecurity::htmlspecialchars_allow_exceptions($properties['description']));
	}

	if (isset($properties['descriptionElementTagID']))
	{
		$descriptionElementTag = PSG_PGSlideInserter::getElementTag($properties['descriptionElementTagID']);
	}

	if (isset($properties['url']))
	{
		$url = htmlspecialchars($properties['url']);
	}

	if (isset($properties['urlTarget']))
	{
		$urlTarget = htmlspecialchars($properties['urlTarget']);
	}

	if (isset($properties['alternativeText']))
	{
		$alternativeText = htmlspecialchars($properties['alternativeText']);
	}

	if (isset($properties['noFollow']))
	{
		$noFollow = ' rel="nofollow" ';
	}

	if (isset($properties['postId']))
	{
		$postId = $properties['postId'];
	}

	// Post ID should always be numeric
	if (is_numeric($postId)):

		$anchorTag = $endAnchorTag = $anchorTagAttributes = '';

		if (strlen($url) > 0)
		{
			$anchorTagAttributes =
				'href="' . $url . '" ' .
				(strlen($urlTarget) > 0 ? 'target="' . $urlTarget . '" ' : '') .
				$noFollow;

			$anchorTag    = '<a ' . $anchorTagAttributes . '>';
			$endAnchorTag = '</a>';
		}

		// Get post from post id. Post should be able to load
		$attachment = get_post($postId);

		if (!empty($attachment)):

			// If no alternative text is set, get the alt from the original image
			if (empty($alternativeText))
			{
				$alternativeText = $title;

				if (empty($alternativeText))
				{
					$alternativeText = htmlspecialchars($attachment->post_title);
				}

				if (empty($alternativeText))
				{
					$alternativeText = htmlspecialchars($attachment->post_content);
				}
			}

			// Prepare image need a settings to select which size to use for gallery...
			$image          = wp_get_attachment_image_src($attachment->ID, 'thumb');
			$imageSrc       = '';
			$imageWidth     = 0;
			$imageHeight    = 0;
			$imageAvailable = true;

			if (!is_array($image) ||
				!$image ||
				!isset($image[0]))
			{
				if (!empty($attachment->guid))
				{
					$imageSrc = $attachment->guid;
				}
				else
				{
					$imageAvailable = false;
				}
			}
			else
			{
				$imageSrc = $image[0];

				if (isset($image[1], $image[2]))
				{
					$imageWidth  = $image[1];
					$imageHeight = $image[2];
				}
			}

/////use only for lightbox//////////////////

if($data->settings['glightbox'])
{
			// Prepare image
			$limage          = wp_get_attachment_image_src($attachment->ID, 'large');
			$limageSrc       = '';
			$limageWidth     = 0;
			$limageHeight    = 0;
			$limageAvailable = true;

			if (!is_array($limage) ||
				!$limage ||
				!isset($limage[0]))
			{
				if (!empty($attachment->guid))
				{
					$limageSrc = $attachment->guid;
				}
				else
				{
					$limageAvailable = false;
				}
			}
			else
			{
				$limageSrc = $image[0];

				if (isset($image[1], $image[2]))
				{
					$limageWidth  = $image[1];
					$limageHeight = $image[2];
				}
			}
			
}	
if($data->settings['glightbox'])
{
		//lightbox gallery	
			// If image is available
			if ($imageAvailable): ?>

				<li class="slideshow_slide slideshow_slide_image <?php echo esc_attr($data->settings['galignment']);?>">
				
				<a href="<?php echo esc_url($limageSrc);?>" class="glightbox<?php echo (int)$data->postid;?>" data-gallery="gallery1"  data-glightbox="title: <?php echo esc_attr($title);?> description: <?php echo esc_html($description);?> ">
				
						<img src="<?php echo htmlspecialchars($imageSrc); ?>" alt="<?php echo esc_attr($alternativeText); ?>" <?php echo ($imageWidth > 0) ? 'width="' . (int)$imageWidth . '"' : ''; ?> <?php echo ($imageHeight > 0) ? 'height="' . (int)$imageHeight . '"' : ''; ?> />
					</a>
					<?php 
					
					
					if($title || $description){?><div class="slideshow_description_box slideshow_transparent">
						<?php 
						if($data->settings['galleryTitle']){
						echo !empty($title) ? '<' . esc_html($titleElementTag) . ' class="slideshow_title">' . wp_kses( $anchorTag, $allowed_html ) . esc_html($title) . '</a>' . '</' . esc_html($titleElementTag) . '>' : '';
						}
						?>
						
						
						<?php 
						
						if($data->settings['galleryDesc']){

						echo !empty($description) ? '<' . esc_html($descriptionElementTag) . ' class="slideshow_description">' . wp_kses( $anchorTag, $allowed_html ) . wp_kses_post($description) . '</a>' . '</' .  esc_html($descriptionElementTag). '>' : ''; 
						}
						
						?>
					</div><?php }


					?>
				</li>
			<?php endif; 
			
			
			
}else{
	//plain gallery use 
				// If image is available
			if ($imageAvailable): ?>

				<li class="slideshow_slide slideshow_slide_image <?php echo $data->settings['galignment'];?>">
					<?php echo wp_kses( $anchorTag, $allowed_html ); ?>
						<img src="<?php echo htmlspecialchars($imageSrc); ?>" alt="<?php echo esc_attr($alternativeText); ?>" <?php echo ($imageWidth > 0) ? 'width="' . (int)$imageWidth . '"' : ''; ?> <?php echo ($imageHeight > 0) ? 'height="' . (int)$imageHeight . '"' : ''; ?> />
					<?php echo '</a>'; ?>
					<?php if($title || $description){?><div class="slideshow_description_box slideshow_transparent">
						<?php echo !empty($title) ? '<' . esc_attr($titleElementTag) . ' class="slideshow_title">' . wp_kses( $anchorTag, $allowed_html ) . esc_html($title) . '</a>' . '</' . esc_html($titleElementTag) . '>' : ''; ?>
						<?php echo !empty($description) ? '<' . esc_attr($descriptionElementTag) . ' class="slideshow_description">' . wp_kses( $anchorTag, $allowed_html ) . wp_kses_post($description) . '</a>' . '</' . esc_html($descriptionElementTag) . '>' : ''; ?>
					</div><?php } ?>
				</li>
			<?php endif; 
	
	
}
			?>
			
			
			
			
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>