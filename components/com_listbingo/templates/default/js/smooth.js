/**
 * 
 * JS Assisting Smooth Gallery
 * 
 */
function startGallery() 
{
	var myGallery = new gallery($('myGallery'), {
		timed: false,
		showInfopane:false,
		embedLinks:false,
		showCarouselLabel:false,
		textShowCarousel:"More Pictures"
	});
}

window.addEvent('domready',startGallery);
