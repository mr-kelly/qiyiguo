<?php 
	$this->load->view('header_view'); 
	$ci =& get_instance();
?>
	
	<div id="content" class="two_columns">
		<div class="content_top">
			<div class="content_bottom">
				
				
					<?php
						// 管理员、发布的用户可以删除
						if ( is_group_admin( $topic['model_id'] , get_current_user_id() ) 
								|| $topic['user_id'] == get_current_user_id() 
								):
					?>
					<div class="float_right">
						<a href="#" onclick="return delete_btn(this, '<?= get_group_url( $topic['model_id'] ) ;?>');" class="icon icon_delete" ajax="<?=site_url('topic/ajax_delete/' . $topic['id']);?>">
							删除
						</a>
					</div>
					<div class="clearboth"></div>
					
					<?php
						endif;
					?>
				
				
				<div class="float_right">
					<div class="topic_lookup_attach_img">
					<?php if ( isset( $topic['Attach_Img'] ) ): // 话题图片 ?>
						<a class="sexybox" href="<?= static_url( 'upload/attach_img' . $topic['Attach_Img']['file'] );?>">
							<img width="100" src="<?= static_url( 'upload/attach_img' . $topic['Attach_Img']['file'] );?>" />
						</a>
					<?php endif; ?>
					</div>
					
					<div class="topic_lookup_attach_file">
					
					<?php if ( isset( $topic['Attach_File'] ) ) : // 话题附件?>
					
					<a class="icon icon_<?=substr( $topic['Attach_File']['file_ext'], 1 );?>" target="_blank" href="<?= static_url( 'upload/attach_file' . $topic['Attach_File']['file'] );?>">
						<?=$topic['Attach_File']['file_name'];?>
					</a>
					<?php endif ;?>
					
					</div>
				</div>
				
				
				<h2><?=$topic['title'];?></h2>
				
				
				<div>
					<?=$topic['content'];?>
				</div>
				
				

				
				
				<div class="clearboth"></div>
				
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
				
					<?php
						$this->load->view('sidebar/sidebar_group_profile', array(
							'group'=> $group,
							'group_members_count' => $group_members_count,
						));
					?>
				
				<?php endif; ?>
				
				<?php
					$this->load->view('sidebar/sidebar_user_profile', array(
						'user' => kk_get_user( $topic['user_id'] ),
					));
				?>
			</div>
		</div>	
	</div>
<?php $this->load->view('footer_view'); ?>