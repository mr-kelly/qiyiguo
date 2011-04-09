<?php
	$this->load->view('header_view');
?>
	
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h1>转送</h1>
				<div class="grey" style="margin-bottom: 10px;">
					&gt;向你加入过的群转送
				</div>
				<?php if ( !empty( $user_groups) ) :?>
				<ul class="groups_list">
				<?php
					foreach( $user_groups as $group ) : 
						$user_group_url = get_group_url( $group['id'] );
				?>
					<li>
						<div>
							<a href="<?=$user_group_url;?>">
								<img class="avatar" width="18" src="<?=get_group_logo_url( $group['id'] ); ?>" />
							</a>
							
							<a class="tipsy_s" href="<?=$user_group_url;?>"  title="<?=$group['name'];?> <?=$group['intro'];?>">
								<?= $group['name'];?>
							</a>
							
							<?php
								// 如果是关系群，那么判断两个群是否双向关系..
								if ( isset( $group_id ) ) :
									$ci =& get_instance();
									$ci->load->model('relation_model');
									if ( $ci->relation_model->is_group_relation_mutual( $group_id, $group['id'] ) ) :
									// 双向关系
							?>
								<span class="icon icon_mutual tipsy_s" title="双向关系"></span>
							<?php
									endif;
								endif;
								
							?>
							
							
							
							<a href="<?=site_url('topic/transfer/' . $topic['id'] . '/'. $group['id'] );?>" class="btn">
								转送
							</a>
						</div>
					</li>
				<?php endforeach; ?>
				</ul>
				<?php
					else:
				?>
					你还没有加入任何群组...没办法转送
				<?php
					endif;
				?>
				
				
				<?php
					//$this->load->view('group/general_groups_list', array(
					//	'groups' => $user_groups,
					//));
				?>
			</div>
		</div>
	</div>


<?php
	$this->load->view('footer_view');
?>