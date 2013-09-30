define(['jquery'], function() {
	var init = function() {
  		$('body').html('Testing Module says Hello World.');
  		console.log('It also shows in the console.');
  	};
  	
  	return {
    	init: init
  	};
});