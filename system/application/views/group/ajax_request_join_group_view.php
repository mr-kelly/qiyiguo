<div class="form_div left" style="width: 350px;">
	<form id="join_group_message_form" method="post" action="<?=site_url("group/ajax_join_group/". $group_id );?>">
		<p>
			<label>验证信息</label>
			<textarea name="message" class="required"></textarea>
		</p>
		
		<p class="center">
			<a id="join_group_message_btn" href="#" class="awesome">
				请求加入
			</a>
		</p>
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
					}
				}
			});
		},
		success: function(label) {
			label.text('').addClass('success');
		}
	});
		


	
</script>