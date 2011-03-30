					<table class="kk_table">
						<thead>
							<th>果号</th>
							<th>名字</th>
							<!--<th>性别</th>-->
						</thead>
						<tbody>
						<?php foreach ( $users as $user ) : ?>
							<tr>
								<td width="100" class="align_center">
									<?= $user['id'] ; ?>
								</td>
								<td>
									<img width="16" src="<?=get_user_avatar_url( $user['id'] );?>" />
									<a href="<?= get_user_url( $user['id'] );?>">
										<?= $user['name'] ;?>
									</a>
									<?php
										if ( isset( $group ) ):
											if ( is_group_admin( $group_id, $user['id'] ) ):?>
										<span title="管理者" class="tipsy_w icon icon_admin"></span>
									<?php 
											endif;
										endif;
									?>
									
									<?= $user['gender'] == 'male' ? '男' : '女' ;?>
								</td>
								<!--
								<td>
									
								</td>-->
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>