<?php

/**
 * Render callback for the dynamic block. All this does is call the show function
 * of the PG class.
 * 
 * @since 2.5.0
 * @param mixed $attributes
*/
function portfolio_gallery_render_slideshowgal_block ( $attributes ) {
	ob_start(); // start buffering to avoid the already-sent-headers error


	PSG_PG::show($attributes['selectedSlideshow'],$attributes['selectedType']);

	return ob_get_clean();
}
