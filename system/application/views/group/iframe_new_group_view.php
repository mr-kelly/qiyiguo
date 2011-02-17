<?php
	$this->load->view('general/general_header_view');
?>


	<div class="kk_tabs">
		<ul class="tab_menu">
			<li>
				<a href="#new_group_tab">创建果群</a>
			</li>
		</ul>


		<div id="new_group_tab" class="form_div tab_div">
			
			<form id="new_group_form" method="post" action="<?=site_url('group/iframe_new_group');?>">
				<p>
					<label for="group_name">果群名称</label>
					<input type="text" id="group_name" name="group_name" class="required" />
				</p>
				
				<p>
					<label for="group_category">果群种类</label>
					<select id="group_category" name="group_category">
					
					<?php foreach ($group_categories as $cat) {?>
						<option value="<?=$cat['id'];?>"><?=$cat['name'];?></option>
					<?php } ?>
					
					</select>
				</p>
				
				<p>
					<label for="group_privacy">公开程度</label>

					<input id="group_privacy" type="radio" checked="checked" name="group_privacy" value="public" />公开
					<input id="group_privacy" type="radio" name="group_privacy" value="private" />私密
				</p>
				
				<p>
					<label for="group_verify">加入方式</label>
					<select id="group_verify" name="group_verify" class="tipsy_nw" title="其他人加入你果群的方式">
						<option value="request">需要管理员审核加入</option>
						<option value="everyone">任何人都可以直接加入</option>
						<option value="closed">不允许任何人加入</option>

					
					</select>
				</p>
				
				<p>
					<label>简介(选填)</label>
					<textarea name="intro"></textarea>
				</p>
			
			
				<a href="<?=current_url();?>" onclick="return false;" class="btn" href="#" id="submit_btn">
					<span><span>创建新友群</span></span>
				</a>
			</form>
			<script type="text/javascript">
				$('#submit_btn').click(function() {
					$('#new_group_form').submit();
					return false;
				});
				
				
				// Validation + AjaxForm
				$('#new_group_form').validate({
					
					submitHandler: function(form) {
						$('#new_group_form').ajaxSubmit({
							dataType: 'json',
							success: function(data){
							
								
								if ( data.status == 1) {
									kk_growl.success( data.info );
									
									
									// 由于创建群组的页面网址是group/iframe_new_group, 所以会直接到达指定页面
									window.parent.location = window.location = data.data.group_id;
									
									// 转到群组页
									//window.parent.location = $redirect;
								} else {
									kk_growl.error( data.info );
									//session_message( data.info, 'error');
								}
							}
						});
					},
					success: function(label) {
						// 表单通过验证， 提供一个勾，代表填写正确
						label.text('').addClass('success');
					}
				});
// 								$(function(){
// 									$('#submit_btn').click(function(){
// 										$.post(
// 											$(this).attr('href'),
// 											{
// 												group_name : $('#group_name').val(),
// 												group_category : $("#group_category").val(),
// 												group_privacy : $('#group_privacy:checked').val(),
// 												group_verify : $('#group_verify').val()
// 											},
// 											function(data) {
// 												//alert(data);
// 												data = $.parseJSON(data);
// 												
// 												
// 												
// 												if ( data.status == 1 ) {
// 													kk_growl.success( data.info );
// 													window.location = data.data.group_id;
// 												} else {
// 													kk_growl.error( data.info );
// 												}
// 												
// 											}
// 										);
// 										return false;
// 									});
// 								});
			</script>
		</div>
	</div>				
<?php
	$this->load->view('general/general_footer_view');
?>