<?php

if ($data instanceof stdClass) :


$args['mode']="string";
$args['speed']="integer";
$args['slideMargin']="boolean";
$args['startSlide']="integer";
$args['randomStart']="boolean";
$args['slideSelector']="boolean";
$args['infiniteLoop']="boolean";
$args['auto']="boolean";

?>

jQuery(document).ready(function(){
    var lightboxDescription = GLightbox({
                selector: '.glightbox<?php echo (int)$data->post->ID;?>',

<?php

	
?>
  }
  );
});




<?php endif; ?>