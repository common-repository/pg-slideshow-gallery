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
$settings=$data->settings;

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

			// Prepare image
			$image          = wp_get_attachment_image_src($attachment->ID, 'large');
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

			// If image is available
			if ($imageAvailable): ?>

				<li >
					<?php echo wp_kses($anchorTag,$allowed_html); ?>
						<img src="<?php echo htmlspecialchars($imageSrc); ?>" alt="<?php echo esc_attr($alternativeText); ?>" <?php echo ($imageWidth > 0) ? 'width="' . (int)$imageWidth . '"' : ''; ?> <?php /* echo ($imageHeight > 0) ? 'height="' . (int)$imageHeight . '"' : ''; */ ?>  />
					<?php if($anchorTag)echo '</a>'; ?>
					<?php if(($title || $description ) && ($settings['sw_label'])){?><div class="label_text">
						<?php echo !empty($title) ? '<' . esc_html($titleElementTag) . ' class="slideshow_title">' . wp_kses($anchorTag,$allowed_html) . esc_html($title) . '</a>'. '</' . esc_html($titleElementTag) . '>' : ''; ?>
						<?php echo !empty($description) ? '<' . esc_html($descriptionElementTag) . ' class="slideshow_description">' . wp_kses($anchorTag,$allowed_html) . wp_kses_post($description) . '</a>' . '</' . esc_html($descriptionElementTag) . '>' : ''; ?>
					</div><?php } ?>
				</li>
			<?php endif; ?>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>