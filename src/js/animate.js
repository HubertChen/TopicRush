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

/*
 *	Fix width of certain elements
 *	params: N/A
 */
function fixWidth(){
	$('#main input').width($('.items').width() - $('#main .btn1').innerWidth() - 40);
}

/*
 *	Switch old class with new one on element
 *	params: $element=jQuery element, class1=str, class2=str
 */
function switchClass($element, class1, class2){
	if ( $element.hasClass(class1) ){
		$element.removeClass(class1);
		$element.addClass(class2);
	} else {
		$element.removeClass(class2);
		$element.addClass(class1);
	}	
}

/* on page load js */
$(document).ready(function(){
	fixHeight();
	fixWidth();

	/* on window resize */
	$(window).resize(function(){
		fixHeight();
		fixWidth();
	});
	
	$('.options li').click(function(){
		switchClass($(this), 'unchecked', 'checked');
	});
	
	$('header .header h3').click(function(){
		switchClass($(this).children('span'), 'fa-chevron-down', 'fa-chevron-up');
		$(this).parent().next('.dropdown').slideToggle();
		fixHeight();
		$(this).parent().next('.dropdown:hidden').slideToggle();
	});
});