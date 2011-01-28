<?php
	// 正式登录页面
?>

<?php $this->load->view('header_view'); ?>


            <div id="sidebar">
				<div class="sidebar_top">
					<div class="sidebar_bottom">
						Sidebar
					</div>
				</div>
            </div>
            
            
            <div id="content">
            	<div class="content_top">
            		<div class="content_bottom">
						你尚未登录哦～
						<script>
							$(function(){
								$('#login_btn').trigger('click');
							});
						</script>
					</div>
				</div>
            </div>

<?php $this->load->view('footer_view'); ?>