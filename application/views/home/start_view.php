<?php
	$this->load->view('header_view');
	
	
?>
	<?=import_css('css/app/home/start.css');?>
	
	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				<h1>欢迎</h1>
						<p>
							内涵指数: <?=$user_inner_index;?>
						</p>
						
				<div id="start_show">
					
					<div class="start_block">
						<h2>话题 <?=count( $user_groups_topics );?></h2>
						<ul>
						<?php foreach( $user_groups_topics as $topic ) : ?>
							<li>
								<?=$topic['content'];?>
							</li>
						<?php endforeach; ?>
						</ul>
					</div>
					
					<div class="start_block">
						<h2>活动 <?= count( $user_groups_events );?></h2>
						<ul>
						<?php foreach( $user_groups_events as $event ) : ?>
							<li>
								<?= $event['name'];?>
							</li>
						<?php endforeach; ?>
						</ul>
					</div>
					
					<div class="start_block">
						<h2>管理的群 <?=$user_admin_groups_count;?></h2>
						<?php
							print_r ( $user_admin_groups );
						?>
					</div>
					
					<div class="start_block">
						<h2>我的群 <?=$user_groups_count;?></h2>
						<?php
							print_r( $user_groups );
						?>
					</div>
				</div>
				
				
				<div class="clearboth"></div>
				
			</div>
			
		</div>
	</div>
	
	
	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">
				
				<div class="sidebar_widget">
					<form method="post" action="<?=site_url('user/ajax_add_mood');?>">
						<input name="mood_text" value="今天心情怎样？" />
						<input type="submit" />
					</form>
				</div>
				
				<div class="sidebar_widget">
					<h2>个人资料</h2>
					
				</div>
				
				<div class="sidebar_widget">
					<h2>快速进入</h2>
					<a class="btn" href="#"><span><span>为社团、班级创建群组</span></span></a>
				</div>
				
				<div class="sidebar_widget">
					<h2>你可能感兴趣...</h2>
					
				</div>
				
				<div class="sidebar_widget">
					<h2>你可能认识...</h2>
					
				</div>
				
				
				<div class="sidebar_widget">
					<h2></h2>
				</div>
				
				
			</div>
		</div>
	</div>

<?php
	$this->load->view('footer_view');
?>