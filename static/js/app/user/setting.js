$(function(){
	$('#submit_user_profiles_form').click(function(){
		$("#user_profiles_form").submit();
		return false;
	});
	
	$('#user_profiles_form').ajaxForm({
		dataType: 'json',
		success: function(data) {
			if ( data.status == 1 ) {
				session_message(data.info, 'normal');
				
			} else {
				session_message(data.info, 'error');
			}
		}
	});
});