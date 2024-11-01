
( function( $ ){
	$( document ).on( 'ready widget-added widget-updated', function(){
		$( '#widgets-right .color-field, .inactive-sidebar .color-field' ).wpColorPicker( {
			change: _.throttle( function() {
				$(this).trigger( 'change' );
			}, 1000 ),
	        clear: _.throttle( function() {
				$(this).trigger( 'change' );
			}, 1000 ),
		});
	});
	$(document).ajaxComplete(function() {
	        $('#widgets-right .color-field, .inactive-sidebar .color-field').wpColorPicker();
	});
}( jQuery ) );

( function( $ ){
        $( document ).on('click', '.options-block h4', function(){
          $(this).siblings('.options-block-inner' ).slideToggle();
          $(this).find('span').html($(this).find('span').text() == '-' ? '+' : '-');
        }); 
}( jQuery ) );
