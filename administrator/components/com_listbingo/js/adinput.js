/**
 * @author Alex@gobingoo.com
 * @project Gobingoo.com
 * @subproject LISTBINGO
 * @date 29 Dec 2009
 * 
 * JS Assisting Ad Input
 * 
 */

window.addEvent('domready',function(){
	
	$('country_id').addEvent('change',function(){
		
		$('locality').setHTML('Loading...');
		url='index.php?option=com_listbingo&format=raw&task=regions.load&cid='+this.value;
		req=new Ajax(url,			
				{
				update:'locality',
				method:'get',
					evalscript:true
				}
				);
				
				req.request();
		
	});
	
	
	$('category_id').addEvent('change',function(){
		
		//alert(pricetypecat[this.value]);
		if(pricetypecat[this.value]>0)
		{
			document.getElementById('pricetype-container').style.visibility="visible";
			document.getElementById('price-container').style.visibility="visible";
		}
		else
		{
			//document.getElementById('price').value="";
			document.getElementById('pricetype-container').style.visibility="hidden";
			document.getElementById('price-container').style.visibility="hidden";
		}
		
		$('ef').setHTML('Loading...');
		url='index.php?option=com_listbingo&format=raw&task=categories.loadef&cid='+this.value+'&adid='+ad_id;
		//alert(url);
		req=new Ajax(url,			
				{
				update:'ef',
				method:'get',
					evalscript:true
				}
				);
				
				req.request();
	});
	
/*	$('addb').addEvent('click',function(){
			
			 x=currentcount;
			 currentcount++;
		 $('img_'+x).clone().injectBefore(this).id='img_'+currentcount;
		 imgcount++;

	});*/
	
	$('addb').addEvent('click',function(){
		
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
			
		});
		
		var file_input = new Element('input',{'name':'images[]','type':'file'});
		var br_clear = new Element('br',{'class':'clear'});
		
		file_input.injectInside(div_input_holder);
		br_clear.injectInside(div_input_holder);
		imgcount++;
		
		
			 
	});	
});