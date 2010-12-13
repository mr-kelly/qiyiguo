/**
 *	修正IE6的CSS问题， 用jQuery
 *   input[type=text] 这种选择器在ie无效的
 */
 
 $(function(){
 	$('input[type=text]').addClass('input_text');
 });