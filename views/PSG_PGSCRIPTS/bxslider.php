<?php

if ($data instanceof stdClass) :
$boolarr[0]="false";
$boolarr[1]="true";

$pgargs['mode']="string";
$pgargs['speed']="integer";
$pgargs['slideMargin']="boolean";
$pgargs['startSlide']="integer";
//$pgargs['randomStart']="boolean";
$pgargs['slideSelector']="boolean";
$pgargs['infiniteLoop']="boolean";
$pgargs['auto']="boolean";
$pgargs['hideControlOnEnd']="boolean";
$pgargs['captions']="boolean";
$pgargs['adaptiveHeight']="boolean";
$pgargs['video']="boolean";
$pgargs['responsive']="boolean";
$pgargs['preloadImages']="string";
$pgargs['pager']="boolean";
$pgargs['pagerType']="string";
$pgargs['minSlides']="integer";
$pgargs['maxSlides']="integer";
$pgargs['shrinkItems']="boolean";

$pgargs['controls']="boolean";
$pgargs['auto']="boolean";
$pgargs['pause']="string";
$pgargs['slideWidth']="string";


?>

jQuery(document).ready(function(){
  jQuery('.bxslider<?php echo (int)$data->post->ID;?>').bxSlider({
<?php
  foreach($data->settings as $key=>$value)
  {
	  
	  
	  
	  if(isset($pgargs[$key]))
	  { 
  
  
  $tc=$pgargs[$key];
  switch ($tc){
	  
	  case 'string':
 echo  esc_html($key) .":'".esc_html($value)."'," ."\n";
break;
	  case 'integer':
 echo  esc_html($key) .":".(int)$value."," ."\n";
break;
	  case 'boolean':
 echo  esc_html($key) .":".esc_html($boolarr[(bool)$value]). "," ."\n";
break;
	 default:
 echo  esc_html($key) .":'".esc_html($value)."'," ."\n";
break;
	 
	  
	  
  }
  
 
  
	  }
	  
  }
 echo  "Dummy" .":''" ."\n";
	
?>
  }
  );
});




<?php endif; ?>