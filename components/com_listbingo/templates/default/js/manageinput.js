/**
 * @author bruce@gobingoo.com
 * @project Gobingoo.com
 * @subproject LISTBINGO
 * @date April 2010
 * 
 * JS Assisting Ad More Image Input for manageimage form
 * 
 */


var currentcount_m=0;

window.addEvent('domready',function(){
	
	$('addb_m').addEvent('click',function(){
		if(imgcount_m<maxlimit_m)
		{
		
			var x_m=currentcount_m;
			currentcount_m++;
		
		var div_main_container = new Element('li',{'class':'imageholder','id':'img_'+currentcount_m}).injectInside($('manageImageUpload'));
				
		var file_input = new Element('input',{'name':'images[]','type':'file'});
		
		file_input.injectInside(div_main_container);

		var div_remove_holder = new Element('div',{'class':'remove','id':'gb_manage_remove_image'}).injectInside(div_main_container);
		var anchor= new Element('a');
		anchor.setText('Remove');
		anchor.injectInside(div_remove_holder);
		anchor.addEvent('click',function(){
			div_main_container.remove();
			imgcount_m--;
		});
		
		imgcount_m++;
		
				
		}
		else
		{
			alert(alertmsg_m);
		}
			 
	});	


	
});