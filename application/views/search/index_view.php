<?php
	$this->load->view('header_view');
?>

	<?=import_css('css/app/search/index.css');?>
	
	<script>
		$(function(){
			$('#search_page_input').focus();
		});
	</script>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				
				<div class="center">
					<form method="get" action="<?=site_url('search');?>">
					
						<input id="search_page_input" tabindex="1" style="width: 550px;" type="text" name="q" value="<?=$q;?>" />
						<button type="submit" class="kk_btn">
							搜索
						</button>
						
					</form>
				</div>
				
				
				<?php if ( ! empty( $search_groups ) ) :?>
				<div id="search_groups">
					<h2>搜到的果群</h2>
					<?php
						$this->load->view('group/general_groups_show', array(
							'groups' => $search_groups,
						));
					?>
					
				</div>
				<?php endif; ?>
				
				
				<?php if ( ! empty ( $search_users ) ) :?>
				<div id="search_users">
					<h2>搜到的人</h2>
					<?php
						$this->load->view('user/general_users_show', array(
							'users' => $search_users,
						));
					?>

				</div>
				<?php endif; ?>
				
				<?php //print_r( $search_stream ); ?>
				
				<?php
					$this->load->view('stream/general_stream_list', array(
						'stream' => $search_stream,
					));
				?>
					
			</div>
		</div>
	</div>
	
	
	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">

				<?php $this->load->view('sidebar/sidebar_ad_pic');?>
			
			</div>
		</div>
	</div>
	
	
	
	


<?php
	$this->load->view('footer_view');
?>
