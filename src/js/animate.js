/* functions TODO: put in separate file when done */

/*
 *	Fix height of certain elements
 *	params: N/A
 */
function fixHeight(){
	/* #topic and #community heights could vary */
	$('#topics .last, #topics .next').css({ "height": $('#topics .slider-page').innerHeight(), "line-height": $('#topics .slider-page').innerHeight() + "px" });
	$('#communities .last, #communities .next').css({ "height": $('#communities .slider-page').innerHeight(), "line-height": $('#communities .slider-page').innerHeight() + "px" });
}

/* on page load js */
$(document).ready(function(){
	fixHeight();

	/* on window resize */
	$(window).resize(function(){
		fixHeight();
	});
});