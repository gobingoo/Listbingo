function myaccordion(indexid){
	
	if(isNaN(parseInt(indexid)))
	{
		indexid = 0;
		
	}
	else
	{
		//alert(indexid);
		indexid= parseInt(indexid);
	}
	
	if(window.ie6) var heightValue='100%';
	else var heightValue='';
	
	var togglerName='dt.accordion_toggler_';
	var contentName='dd.accordion_content_';

	var counter=1;	
	var toggler=$$(togglerName+counter);
	var content=$$(contentName+counter);
	
	while(toggler.length>0)
	{

		new Accordion(toggler, content, {
			opacity: false,
			show: indexid,
			alwaysHide: true,
			onComplete: function() { 
				var element=$(this.elements[this.previous]);
				if(element && element.offsetHeight>0) element.setStyle('height', heightValue);			
			},
			onActive: function(toggler, content) {
				toggler.addClass('open');
			},
			onBackground: function(toggler, content) {
				toggler.removeClass('open');
			}
		});
		

		toggler.addEvent('mouseenter', function() { this.fireEvent('click'); });
		

		counter++;
		toggler=$$(togglerName+counter);
		content=$$(contentName+counter);
	}
}