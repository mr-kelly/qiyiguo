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
				
				
				
				<div id="search_groups">
				<?php if ( ! empty( $search_groups ) ) :?>
					<h2>搜到的果群</h2>
					<?php
						$this->load->view('group/general_groups_show', array(
							'groups' => $search_groups,
						));
					?>
				<?php else: ?>
					<div class="grey align_center">
						搜不到相关的果群
					</div>
				<?php endif; ?>	
				</div>
				
				
				
				
				
				<div id="search_users">
				<?php if ( ! empty ( $search_users ) ) :?>
					<h2>搜到的人</h2>
					<?php
						$this->load->view('user/general_users_show', array(
							'users' => $search_users,
						));
					?>
				<?php else: ?>
					<div class="grey align_center">
						搜不到相关的人
					</div>
				<?php endif; ?>
				</div>

				
				<div class="clearboth"></div>
				
				
				<?php
					$this->load->view('stream/general_stream_list', array(
						'stream' => $search_stream,
					));
				?>
				
				<?php 
					// ,找不到时，推荐
					if ( empty ( $search_stream ) ) :
				?>
				<div class="align_center" style="width: 100%">
					<h2 style="font-size: 25px;">搜索不到话题或活动...</h2>
				</div>
				
				<h2 class="grey">看看其他...</h2>
					<?php
						$ci =& get_instance();
						$ci->load->model('stream_model');
						$random_stream = $ci->stream_model->get_random_stream( 50 );
						
						$this->load->view('stream/general_stream_list', array(
							'stream' => $random_stream,
						));
					?>
				
				<?php endif; ?>
					
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
