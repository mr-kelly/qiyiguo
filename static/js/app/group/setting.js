$(function(){
	$('#group_setting_submit').click(function(){
		$('#group_setting_form').submit();
	});
	
	
	$('#group_setting_form').validate({
			submitHandler: function(form) {

				
				
				$('#group_setting_form').ajaxSubmit({
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

		