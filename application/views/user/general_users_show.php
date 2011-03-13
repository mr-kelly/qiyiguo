					<ul class="users_show">
					<?php foreach( $users as $user ) : 
								$user_url = get_user_url( $user['id'] );
					?>
						<li class="tipsy_s" title="<?=$user['description'];?>">
							<div>
								<a href="<?=$user_url;?>">
									<img class="avatar" width="40" src="<?=get_user_avatar_url( $user['id'] ); ?>" />
								</a>
							</div>
							
							<div>
								<a href="<?=$user_url;?>">
									<?= $user['name'];?>
								</a>
							</div>
							
						</li>
					<?php endforeach; ?>
					</ul>