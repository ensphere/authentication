
jQuery(document).ready(function($){
	$('#screen-loader').fadeOut(200, function(){
		$(this).remove();
	});
	$('.ui.dropdown').dropdown({
		on : 'hover'
	});
});