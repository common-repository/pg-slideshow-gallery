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
if ($data instanceof stdClass) :

	$properties = $data->properties;

	$title = $description = $textColor = $color = $url = $urlTarget = $noFollow = '';

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

	if (isset($properties['textColor']))
	{
		$textColor = $properties['textColor'];

		if (substr($textColor, 0, 1) != '#')
		{
			$textColor = '#' . $textColor;
		}

		$textColor = htmlspecialchars($textColor);
	}

	if (isset($properties['color']))
	{
		$color = $properties['color'];

		if (substr($color, 0, 1) != '#')
		{
			$color = '#' . $color;
		}

		$color = htmlspecialchars($color);
	}

	if (isset($properties['url']))
	{
		$url = htmlspecialchars($properties['url']);
	}

	if (isset($properties['urlTarget']))
	{
		$urlTarget = htmlspecialchars($properties['urlTarget']);
	}

	if (isset($properties['noFollow']))
	{
		$noFollow = 'rel="nofollow"';
	}

	$anchorTag = $endAnchorTag = $anchorTagAttributes = '';

	if (strlen($url) > 0)
	{
		$anchorTagAttributes =
			'href="' . $url . '" ' .
			(strlen($urlTarget) > 0 ? 'target="' . $urlTarget . '" ' : '') .
			(strlen($textColor) > 0 ? 'style="color: ' . $textColor . '" ' : '') .
			$noFollow;

		$anchorTag    = '<a ' . $anchorTagAttributes . '>';
		$endAnchorTag = '</a>';
	}

	?>

	<li class="slideshow_slide slideshow_slide_text <?php echo esc_attr($data->settings['galignment']);?>" style="<?php echo strlen($color) > 0 ? 'background-color: ' . esc_attr($color) . ';' : '' ?>">
		<?php if(strlen($title) > 0): ?>
		<<?php echo esc_html($titleElementTag); ?> class="slideshow_title" style="<?php echo strlen($textColor) > 0 ? 'color: ' . esc_html($textColor) . ';' : ''; ?>">
			<?php echo wp_kses( $anchorTag, $allowed_html ); ?>
				<?php echo esc_html($title); ?>
			<?php echo '</a>'; ?>
		</<?php echo esc_html($titleElementTag); ?>>
		<?php endif; ?>

		<?php if(strlen($description) > 0): ?>
		<<?php echo esc_html($descriptionElementTag); ?> class="slideshow_description" style="<?php echo strlen($textColor) > 0 ? 'color: ' . esc_html($textColor) . ';' : ''; ?>">
			<?php echo wp_kses( $anchorTag, $allowed_html ); ?>
				<?php echo wp_kses_post($description); ?>
			<?php echo '</a>'; ?>
		</<?php echo esc_html($descriptionElementTag); ?>>
		<?php endif; ?>

		<a <?php echo esc_html($anchorTagAttributes); ?> class="slideshow_background_anchor"></a>
	</li>
<?php endif; ?>