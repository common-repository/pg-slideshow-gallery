<?php

if ($data instanceof stdClass) :
$boolarr[0]="false";
$boolarr[1]="true";



			
$pgargs['sw_velocity']="float";
$pgargs['sw_interval']="integer";
$pgargs['sw_animation']="string";
$pgargs['sw_numbers']="boolean";
//$pgargs['randomStart']="boolean";
$pgargs['sw_navigation']="boolean";
$pgargs['sw_thumbs']="boolean";
$pgargs['sw_hide_tools']="boolean";
$pgargs['sw_fullscreen']="boolean";
$pgargs['sw_xml']="boolean";
$pgargs['sw_dots']="boolean";
$pgargs['sw_show_randomly']="boolean";
$pgargs['sw_numbers_align']="string";
$pgargs['sw_preview']="boolean";
$pgargs['sw_controls']="boolean";

$pgargs['sw_controls_position']="string";
$pgargs['sw_enable_navigation_keys']="boolean";
$pgargs['sw_with_animations']="array";
$pgargs['sw_stop_over']="boolean";
$pgargs['sw_auto_play']="boolean";
$pgargs['sw_theme']="string";


?>

jQuery(document).ready(function(){
  jQuery('.skitter-large<?php echo (int)$data->post->ID;?>').skitter({
<?php
  foreach($data->settings as $key=>$value)
  {
	 if(($value=='') || ($key=="")) continue;
	 
	  if(isset($pgargs[$key]))
	  { 
  $tc=$pgargs[$key];
  	  $key=str_replace("sw_","",$key);

  
  switch ($tc){
	  
	  case 'string':
 echo  esc_html($key) .":'".esc_html($value)."'," ."\n";
break;
	  case 'integer':
 echo  esc_html($key) .":".(int)$value."," ."\n";
break;
case 'float':
 echo  esc_html($key) .":".(float)$value."," ."\n";
break;
	  case 'boolean':
 echo  esc_html($key) .":".esc_html($boolarr[(bool)$value]). "," ."\n";
break;
case 'array':
$valuearr = explode(",",$value);

$value = '"' . implode ( '", "', $valuearr ) . '"';
 echo  esc_html($key) .":[".str_replace("&quot;",'"',esc_html($value))."]," ."\n";
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