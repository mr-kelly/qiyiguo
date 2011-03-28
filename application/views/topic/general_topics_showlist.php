						<?php
						if ( !empty( $topics ) ) : 
						?>
						<ul class="topics_showlist">
						
						<?php
							foreach( $topics as $topic ) : 
								$topic_group = isset( $topic['Group'] ) ? $topic['Group'] : kk_get_group( $topic['model_id'] );
								$topic_user = isset( $topic['User'] ) ? $topic['User'] : kk_get_user( $topic['user_id'] );
								
								//$topic_group = kk_get_group( $topic['model_id'] );
								//$topic_user = kk_get_user( $topic['user_id'] );
						?>
							<li>
								<div class="float_left">

									<span class="tipsy_s" title="来自:<?= $topic_group['name'];?>">
										<a href="<?= get_group_url( $topic_group['id'] );?>">
											<img width="24" src="<?= get_group_logo_url( $topic_group['id'] );?>" />
										</a>
									</span>
				

				
				
				
									<span class="tipsy_s" title="作者:<?= $topic_user['name'];?>">
										<a href="<?= get_user_url( $topic_user['id'] );?>">
											<img width="24" src="<?= get_user_avatar_url( $topic_user['id'] );?>" />
										</a>
									</span>

								</div>
								
									
								<span class="float_right">
									<?php if ( isset( $show_group_name ) ) :?>
									<span>
										<a href="<?= get_group_url( $topic_group['id'] );?>">
											<?= kk_content_preview( $topic_group['name'], 40 );?>
										</a>
									</span>
									<?php endif; ?>
									
									
									<span class="grey">
										<?=$topic['page_view'];?>人看过
									</span>
								</span>
								
								<a class="tipsy_s" href="<?=site_url('topic/' . $topic['id'] );?>" title="<?= $topic_group['name'] . ' 的 ' . $topic_user['name'] . ' 发表: ' . kk_content_preview( $topic['content'], 200 );?>">
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
						