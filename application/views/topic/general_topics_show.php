						<?php
						if ( !empty( $topics ) ) : 
						?>
						<ul class="topics_show">
						
						<?php
							foreach( $topics as $topic ) : 
								$topic_group = $topic['Group'];
								$topic_user = $topic['User'];
								//$topic_group = kk_get_group( $topic['model_id'] );
								//$topic_user = kk_get_user( $topic['user_id'] );
						?>
							<li>
								<div class="float_right">
									<span class="tipsy_s" title="作者:<?= $topic_user['name'];?>">
										<a href="<?= get_user_url( $topic_user['id'] );?>">
											<img width="24" src="<?= get_user_avatar_url( $topic_user['id'] );?>" />
										</a>
									</span>
									
									<span class="tipsy_s" title="来自:<?= $topic_group['name'];?>">
										<a href="<?= get_group_url( $topic_group['id'] );?>">
											<img width="24" src="<?= get_group_logo_url( $topic_group['id'] );?>" />
										</a>
									</span>

								</div>
								
								<a href="<?=site_url('topic/' . $topic['id'] );?>">
									<?php if ( $topic['title'] != '' ) : ?>
										<?= $topic['title'];?>
									<?php else: ?>
										<?= kk_content_preview( $topic['content'], 42 );?>
									<?php endif; ?>
								</a>
								
							</li>
						<?php
							endforeach;

						?>
						
						</ul>
						<?php
							endif;
						?>
						