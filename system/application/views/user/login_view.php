<?php
	// 正式登录页面
?>

<?php $this->load->view('header_view'); ?>


            <div id="sidebar">

            </div>
            
            
            <div id="content">
            	你尚未登录哦～
				<script>
					$(function(){
						$('#login_btn').trigger('click');
					});
				</script>
            </div>

<?php $this->load->view('footer_view'); ?>