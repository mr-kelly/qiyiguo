				<?php if ( !empty ( $groups ) ) : ?>
				
				<ul class="groups_list">
				<?php
					foreach( $groups as $group ) : 
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
							
						</div>
					</li>
				<?php endforeach; ?>
				</ul>
				
				<div class="clearboth"></div>
				
				
				<?php endif; ?>