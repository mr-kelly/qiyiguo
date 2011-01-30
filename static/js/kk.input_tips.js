/**
 *   KK Form Input Tips ( jQuery )  v0.1b
 *
 *	 Author: Mrkelly
 *
 *	 MSN/Gtalk/Email: chepy.v@gmail.com
 *	 QQ: 23110388
 *   Twitter: @mrkelly
 *
 *	 jQuery Plugin Page: http://plugins.jquery.com/project/kk_form_input_tip
 *
 *	 Usage:
 		<input type="text" id="test_input" />
 		
 		<script>
 			$(function(){
 				$('#test_input').input_tips( 'some text to display on it.' );
 			});
 		</script>
 *
 */
 
 
 
(function($) {

	$.fn.input_tips = function( str ) {
	
		initial_target( $(this), str );
		
		$(this).blur(function(){
		
			if ( $(this).val() == '' ) {
				initial_target( $(this), str );
			}
			
		}).focus(function(){
			if ( $(this).val() == str ) {
				clear_target( $(this) );
			}
			
			
		});
	};
	
	// use for focus
	function initial_target( target, str ) {
		target.val( str ).css('color', '#999');
	}
	
	// use for blur
	function clear_target( target ) {
		target.css('color', '#333');
		target.val('');
	}
	
})(jQuery);