function checkPriceType(val) {

	if (val > 1) {
		$('price').removeClass('required');
		$('currency').removeClass('required');
		$('price-container').setStyle('display', 'none');
		$('price').setProperty('value', '');
		$('currency').setProperty('value', '');

	} else {
		$('price').addClass('required');
		$('currency').addClass('required');
		$('price-container').setStyle('display', 'block');

	}

}

window.addEvent('domready', function() {
	/*
	 * check if price type is available for the ad
	 */

	if (pricetypecat[catid] > 0) {
		
		$('price').addClass('required');
		$('pricetype-container').setStyle('display', 'block');
		$('price-container').setStyle('display', 'block');
				
		if (pricetype > 1) {
			
			$('price').removeClass('required');
			$('currency').removeClass('required');
			$('price-container').setStyle('display', 'none');
			$('price').setProperty('value', '');
			$('currency').setProperty('value', '');

		} else {
			$('price').addClass('required');
			$('currency').addClass('required');
			$('price-container').setStyle('display', 'block');
		}

	} else {
		$('price').removeClass('required');
		$('currency').removeClass('required');
		$('pricetype-container').setStyle('display', 'none');
		$('price-container').setStyle('display', 'none');
		$('price').setProperty('value', '');
		$('currency').setProperty('value', '');

	}

});