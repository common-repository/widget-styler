
( function( $ ){

	function linksColors() {
		$('[data-links-color]').each( function() {
			var	linksColor 		= $(this).data('links-color');
			var	linksHover 		= $(this).data('links-hover');

			$(this).find('a').css('color', linksColor);
			$(this).find('a').hover(
				function() {
					$( this ).css('color', linksHover);
				}, function() {
					$( this ).css('color', linksColor);
				}
			);
		});		
	}

	$( document ).on( 'ready', function(){
		linksColors();
	});

	$(document).ajaxComplete(function() {
		linksColors();
	});

}( jQuery ) );
