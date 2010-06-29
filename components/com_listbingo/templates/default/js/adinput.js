/**
 * @author bruce@gobingoo.com
 * @project Gobingoo.com
 * @subproject LISTBINGO
 * @date 29 Dec 2009
 * 
 * JS Assisting Ad More Image Input for adpost form
 * 
 */

var currentcount=0;
window.addEvent('domready',function(){
	
	
	$('addb').addEvent('click',function(){
		if(imgcount<maxlimit)
		{
		
		x=currentcount;
		currentcount++;
		
		var div_main_container = new Element('div',{'class':'imageholder','id':'img_'+currentcount}).injectInside($('imageUploader'));
		var div_remove_holder = new Element('div',{'class':'remove','id':'gb_remove_image'}).injectInside(div_main_container);
		var div_input_holder = new Element('div',{'class':'image_upload_input'}).injectInside(div_main_container);
		
		var anchor= new Element('a');
		anchor.setText('Remove');
		anchor.injectInside(div_remove_holder);
		anchor.addEvent('click',function(){
			div_main_container.remove();
			imgcount--;	
			$('imgcounter').setText(imgcount);
		});
		
		var file_input = new Element('input',{'name':'images[]','type':'file'});
		var br_clear = new Element('br',{'class':'clear'});
		
		file_input.injectInside(div_input_holder);
		br_clear.injectInside(div_input_holder);
		imgcount++;
		$('imgcounter').setText(imgcount);
		
		}
		else
		{
			alert(alertmsg);
		}
			 
	});	
	
	
});