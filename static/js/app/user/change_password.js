$(function(){

	$('#change_password_form').validate({
			submitHandler: function(form) {
				$('#change_password_form').ajaxSubmit({
					dataType: 'json',
					success: function(json) {
						if ( json.status == 1 ) {
							kk_growl.success(json.info);
							
						} else {
							kk_growl.error(json.info);
						}
					}
				});
			},
			success: function(label) {
				label.text('').addClass('success');
			},
			error: function() {
				alert('error');
			}
	});
	
});