var documentonce=0;
jQuery(document).ready(function(){

if(documentonce==0){
documentonce=1;

jQuery('.slideshow_slide_video_id').each(function(i, obj) {
    //test
var h='100%';
var w='100%';

if(jQuery(this).attr('vh'))h=jQuery(this).attr('vh');
if(jQuery(this).attr('vw'))w=jQuery(this).attr('vw');

var vid=jQuery(this).html();

if(vid)
{
var video_url= 'https://www.youtube.com/embed/'+vid;
//alert(video_url);

var html='<p><iframe height="'+h+'" width="'+w+'" src="'+video_url+'" frameborder="0"></iframe></p>';

jQuery(this).html(html);
jQuery(this).show();

}
});
}
});