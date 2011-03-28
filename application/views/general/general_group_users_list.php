		<?php if ( !empty( $users ) ) :?>
		<ul class="lookup_group_users_list">
			<?php	
				foreach ($users as $u) {
			?>
				<li>
				
					<div class="user_control">
						<?php
							// 若是群组页
							if ( isset( $group ) ) :
							// 若是管理员
								if ( $this->group_model->is_group_admin($group['id'], $u['id'])) :
						?>
						<a class="tipsy_e icon icon_admin" href="javascript:void(0);" title="管理者"></a>
						<?php
								endif;   
							endif;
						?>
						
						<?php // 发送邮件给指定ID用户的email ?>
						<a class="tipsy_e icon icon_email" href="<?=site_url('mail?' . 'send_to=' . $u['id'] );?>" title="向<?=$u['name'];?>发送电邮"></a>
					</div>
					
					
					<a class="sexybox" href="<?=get_user_avatar_url(  $u['id'], 'big' );?>" title="<?=$u['name'];?>">
						<img width="18" src="<?=get_user_avatar_url(  $u['id'], false );?>" />
					</a>
					
					<a class="tipsy_e" href="<?=get_user_url( $u['id'] );?>" title="<?=$u['id'];?>">
						<?=$u['name'];?> <!--(<?=$u['id'];?>)-->
					</a>
					

					
				</li>
			<?php } ?>
		</ul>
		<?php
			else: // 没有成员？
		?>
		<div class="grey align_center">
			...
		</div>
		<?php endif; ?>