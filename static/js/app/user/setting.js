$(function(){
	$('#submit_user_profiles_form').click(function(){
		$("#user_profiles_form").submit();
		return false;
	});
	
	$('#user_profiles_form').validate({
		submitHandler: function(form) {
			$('#user_profiles_form').ajaxSubmit({
				dataType: 'json',
				success: function(data) {
					if ( data.status == 1 ) {
						kk_growl.success(data.info);
						
					} else {
						kk_growl.error(data.info);
					}
				}
			});
		},
		success: function(label) {
			label.text('').addClass('success');
		}
	});
	

});