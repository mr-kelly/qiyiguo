<?php 
	$this->load->view('header_view'); 
	$ci =& get_instance();
?>
	
	<div id="content" class="two_columns">
		<div class="content_top">
			<div class="content_bottom">
				<h2><?=$topic['title'];?></h2>
				<div>
					<?=$topic['content'];?>
				</div>
				
				
				<!-- ajax 评论 -->
				<ul class="chats_container no_scroll" style="margin-left:10px; max-height:none;">
				
				</ul>
				
				<script>
					$(function(){
						$('.chats_container').load('<?=site_url("chat/ajax_get_chats/topic/" . $topic["id"] );?>');
					});
				</script>
			</div>
		</div>
	</div>
	
	






	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				<?php 
					if ( $topic['model'] == 'group' ):
						$ci =& get_instance();
						$ci->load->model('group_model');
						$group = $ci->group_model->get_group_by_id( $topic['model_id'] );
						$group_members_count = $ci->group_model->get_group_users_count( $topic['model_id'] );
				?>
				<div class="sidebar_profile">
					
					<div class="profile_img">
						<img width="50" src="<?=get_group_logo_url( $topic['model_id'] );?>" />
					</div>
					
					
						<h3>
							<a href="<?=site_url('group/' . $group['id'] );?>">
								<?=$group['name'];?>
							</a>
						</h3>
						
						<div class="profile_detail">
							
							<div>
								广东?
								<?=$group_members_count;?>名成员
							</div>
						</div>
					
					<div class="clearboth"></div>
					
				</div>
				<a href="<?=$_SERVER['HTTP_REFERER'];?>">返回上一页</a>
				<?php endif; ?>
			</div>
		</div>	
	</div>
<?php $this->load->view('footer_view'); ?>