				<?php if ( !empty ( $groups ) ) : ?>
				
				<ul class="groups_show">
				<?php
					foreach( $groups as $group ) : 
						$user_group_url = get_group_url( $group['id'] );
				?>
					<li>
						<div>
							<a href="<?=$user_group_url;?>">
								<img width="40" src="<?=get_group_logo_url( $group['id'] ); ?>" />
							</a>
						</div>
						
						<div>
							<a href="<?=$user_group_url;?>">
								<?= $group['name'];?>
							</a>
						</div>
					</li>
				<?php endforeach; ?>
				</ul>
				
				
				<?php else: ?>
					没有群组...
				
				<?php endif; ?>