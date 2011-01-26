<?php $this->load->view('header_view'); ?>

            <div id="sidebar">
            	<div class="sidebar_top">
            		<div class="sidebar_bottom">
		            	<?php $this->load->view('sidebar/sidebar_group_view'); ?>
					</div>
            	</div>
            </div>
            
            
            <div id="content">
            	<div class="content_top">
            		<div class="content_bottom">
						<div class="form_div">
							
								<p>
									<label for="group_name">友群名称</label>
									<input type="text" id="group_name" name="group_name" />
								</p>
								
								<p>
									<label for="group_category">友群类别</label>
									<select id="group_category" name="group_category">
									
									<?php foreach ($group_categories as $cat) {?>
										<option value="<?=$cat->id;?>"><?=$cat->name;?></option>
									<?php } ?>
									
									</select>
								</p>
								
								<p>
									<label for="group_privacy">公开程度</label>
		
									<input id="group_privacy" type="radio" checked="checked" name="privacy" value="public" />公开
									<input id="group_privacy" type="radio" name="privacy" value="private" />私密
								</p>
								
								<p>
									<label for="group_verify">加入友群</label>
									<select id="group_verify" name="group_verify">
										<option value="request">需要管理员审核加入</option>
										<option value="everyone">任何人都可以直接加入</option>
										<option value="closed">不允许任何人加入</option>
		
									
									</select>
								</p>
							
							<br />
							
							<form method="post">
								<a href="<?=current_url();?>" onclick="return false;" class="medium blue awesome" href="#" id="submit_btn">
									<span><span>申请创建新友群</span></span>
								</a>
							</form>
							<script type="text/javascript">
								$(function(){
									$('#submit_btn').click(function(){
										$.post(
											$(this).attr('href'),
											{
												group_name : $('#group_name').val(),
												group_category : $("#group_category").val(),
												group_privacy : $('#group_privacy:checked').val(),
												group_verify : $('#group_verify').val()
											},
											function(data) {
												//alert(data);
												data = $.parseJSON(data);
												
												session_message(data.info);
												
												if ( data.status == 1 ) {
													window.location = data.data.group_id;
												}
												
											}
										);
										return false;
									});
								});
							</script>
						</div>
					</div>
    			</div>
            </div>
            
            
<?php $this->load->view('footer_view'); ?>