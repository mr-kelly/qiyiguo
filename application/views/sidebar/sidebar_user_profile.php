
				<div class="sidebar_widget">
					<div class="sidebar_profile">
						
						<div class="profile_img">
							<img width="50" src="<?=get_user_avatar_url( $user['id'] );?>" />
						</div>
						
						
							<h3>
								<a href="<?=get_user_url( $user['id'] );?>">
									<?=$user['name'];?>
								</a>
							</h3>
							
							<div class="profile_detail">
								
								<div>
									<?= kk_get_province_name( $user['province_id'] ); ?>
									<?= kk_get_city_name( $user['city_id'] );?>
								</div>
								
							</div>
						
						<div class="clearboth"></div>
						
					</div>
				</div>