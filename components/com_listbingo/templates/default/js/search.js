Window.onDomReady(function(){
	
	$('q').addEvent('focus',function(){
		if(this.value==searchexampletxt)
		{
this.value="";
			}
		});
	
	$('q').addEvent('blur',function(){
		if(this.value=='')
		{
this.value=searchexampletxt;
			}
		});
       

    $('search_from_price').addEvent('focus',function(){
		if(this.value=='min')
		{
this.value="";
			}
		});

	$('search_from_price').addEvent('blur',function(){
		if(this.value=='')
		{
this.value="min";
			}
		});
	
	$('search_to_price').addEvent('focus',function(){
		if(this.value=='max')
		{
this.value="";
			}
		});

	$('search_to_price').addEvent('blur',function(){
		if(this.value=='')
		{
this.value="max";
			}
		});

    
});


function checkForm()
{
	var searchtxt = document.frmGBSearch.q.value;
	if(searchtxt == searchexampletxt)
	{
		document.frmGBSearch.q.value = "";
	}
	
}