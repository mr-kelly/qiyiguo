<?php
	$this->load->view('header_view');
	
?>
	
<?=import_css('css/app/user/user_lookup.css');?>

<script type="text/javascript">
	$ajax_get_user_relation_btn_url = '<?=site_url("relation/ajax_get_user_relation_btn/" . $user["id"] );?>';
</script>
<?=import_js('js/app/user/user_lookup.js');?>


	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				

            	
            	<div id="lookup_head">
            		<?php $this->load->view('user/general_user_lookup_head');?>

            	</div>
            	
            	<div id="lookup_main">

						<div>
							<h2>聊天</h2>
							<ul class="chats_container">
								
							</ul>
						</div>

					<script>
						$(function(){
							$('.chats_container').load('<?=site_url("chat/ajax_get_chats/user/" . $user["id"] );?>');
						});
					</script>
				</div>
	

				
				
			</div>
		</div>

		
	</div>
	
	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				<?php $this->load->view('sidebar/sidebar_user_view');?>
			</div>
		</div>
	</div>
<?php
	$this->load->view('footer_view');
?>