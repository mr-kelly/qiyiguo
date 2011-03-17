
							<?php if ( !empty( $stream ) ) : ?>
							<ul class="stream_list">
							<?php foreach( $stream as $s ) : ?>
								<li>
									<div class="stream_logo">
										<img width="50" height="50" src="<?=get_group_logo_url( $s['Group']['id'] );?>" />
									</div>
									<div class="stream_title">
										<?=$s['Object']['title'];?>
										
										<span class="small grey float_right">
											<?php
												$ci =& get_instance();
											?>
											<?=$ci->humanize->datetime( $s['modified'] );?>
										</span>
										
									</div>
									<div class="stream_content">
										<? //$stream['modified'];?>
										<a href="<?=get_user_url( $s['User']['id'] );?>">
											<?= $s['User']['name'];?>
										</a>
										在公开群
										<a href="<?=get_group_url( $s['Group']['id'] );?>">
											<?= $s['Group']['name'];?>
										</a>
										<?=$s['Object']['act'];?>
										<a href="<?=site_url( $s['Object']['link'] );?>">
											<?=$s['Object']['text'];?>
										</a>
									</div>
									
								</li>
							<?php endforeach; ?>
							</ul>
							<?php else: ?>
							<div class="grey">
								他还没有任何个人动态...
							</div>
							<?php endif; ?>
