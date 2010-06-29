var CurrentElement=new Class(
		{
			
			initialize:function(options){
			   this.setOptions(options);
			this.element=null;
			
		},
			setCurrentElement:function(el)
			{
		
			this.element=el;
			},
			removeCurrentElement:function()
			{
				console.log("removed");
		
			this.element=null;
			},
			getCurrentElement:function(){
				
				return this.element;
			}
		}		
);
CurrentElement.implement(new Chain, new Events, new Options);

ce=new CurrentElement();

var TrackFocus = new Class({
     
                        options: {
                                elementTypes : ['textarea','input','select','button']
                        },

        initialize : function(options){
                this.setOptions(options);
                this.focus = false;
                this.element = null;
                this.elements = [];
                this.options.elementTypes.each(function(type){
                        this.elements.include(document.body.getElements(type));
                }.bind(this));
                this.elements.each(function(el){
                        el.addEvents({
                                focus : function(){
                                        this.focus = true;
                                      //  this.element = el;
                                  
                                 
                                      ce.setCurrentElement(this);
                                       
                                },
                                blur : function(){
                                        this.focus = false;
                                       // this.element = null;
                                      //  ce.removeCurrentElement();
                                       
                                        
                                }
                        })
                });
        },
        getFocusedElement:function(){
        	
        	return ce.getCurrentElement();
        }
        ,
 setCurrentElement:function(el){
        	
        	ce.setCurrentElement(el);
        }

}); 

TrackFocus.implement(new Chain, new Events, new Options);