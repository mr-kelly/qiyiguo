<div class="form_div align_left" style="width: 350px;">
	<div class="align_center grey">
		告诉管理员你为什么要加入
	</div>
	
	<form id="join_group_message_form" method="post" action="<?=site_url("group/ajax_join_group/". $group_id );?>">
		<p>
			<label>验证信息</label>
			<textarea name="message" class="required"></textarea>
		</p>
		
		<div class="align_center">
			<a id="join_group_message_btn" href="#" class="kk_btn">
				请求加入
			</a>
		</div>
	</form>
</div>

<script>
	$('#join_group_message_btn').click(function(){
		$('#join_group_message_form').submit();
		return false;
	});

	$('#join_group_message_form').validate({
		submitHandler: function(form) {
			$('#join_group_message_form').ajaxSubmit({
				dataType: 'json',
				success: function(data) {
					if ( data.status == 1 ) {
						kk_growl.success('您的请求发送给管理员了！');
						$.fancybox.close();
						location.reload();
					}
				}
			});
		},
		success: function(label) {
			label.text('').addClass('success');
		}
	});
		


	
</script>