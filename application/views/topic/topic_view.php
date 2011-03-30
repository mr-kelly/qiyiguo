<?php 
	$this->load->view('header_view'); 
	$ci =& get_instance();
?>
	<?=import_css('css/app/topic/topic_lookup.css');?>
	
	<div id="content" class="two_columns">
		<div class="content_top">
			<div class="content_bottom">
					<div class="topic_controll_btn">
					<?php
						// 发布者可以修改
						if ( $topic['user_id'] == get_current_user_id() ) :
					?>
						<a href="<?=site_url('topic/edit/' . $topic['id'] );?>" class="icon icon_edit">
							修改
						</a>
					<?php
						endif;
					?>
					<?php
						// 管理员、发布的用户可以删除
						if ( is_group_admin( $topic['model_id'] , get_current_user_id() ) 
								|| $topic['user_id'] == get_current_user_id() 
								):
					?>
					
						<a href="#" onclick="return delete_btn(this, '<?= get_group_url( $topic['model_id'] ) ;?>');" class="icon icon_delete" ajax="<?=site_url('topic/ajax_delete/' . $topic['id']);?>">
							删除
						</a>
					
					<div class="clearboth"></div>
					
					<?php
						endif;
					?>
					</div>
				
				<div class="float_right">
					<div class="topic_lookup_attach_img">
					<?php if ( isset( $topic['Attach_Img'] ) ): // 话题图片 ?>
						<a class="sexybox" href="<?= static_url( 'upload/attach_img' . $topic['Attach_Img']['file'] );?>">
							<img width="200" src="<?= static_url( 'upload/attach_img' . $topic['Attach_Img']['file'] );?>" />
						</a>
					<?php endif; ?>
					</div>
					
					<div class="topic_lookup_attach_file">
					
					<?php if ( isset( $topic['Attach_File'] ) ) : // 话题附件?>
					
					<a class="icon icon_<?=substr( $topic['Attach_File']['file_ext'], 1 );?>" target="_blank" href="<?=site_url('attach/download/' . $topic['attach_file_id'] );?>">
					<!--<?= static_url( 'upload/attach_file' . $topic['Attach_File']['file'] );?>-->
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
			
				<h2>所属群组</h2>
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
				
				<h2>发布者</h2>
				<?php
					$this->load->view('sidebar/sidebar_user_profile', array(
						'user' => kk_get_user( $topic['user_id'] ),
					));
				?>
				
				<div class="align_center">
					<span class="kk_btn_blue">
						<?=$topic['page_view'];?>人看过
					</span>
				</div>
				
				<?php
					$this->load->view('sidebar/sidebar_ad_pic');
				?>
				
				<?php
					$this->load->view('sidebar/sidebar_jiathis');
				?>
				
			</div>
		</div>	
	</div>
<?php $this->load->view('footer_view'); ?>