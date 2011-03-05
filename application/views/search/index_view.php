<?php
	$this->load->view('header_view');
?>
	<script>
		$(function(){
			$('#search_page_input').focus();
		});
	</script>

	<div id="content">
		<div class="content_top">
			<div class="content_bottom">
				
				<div class="center">
					<form method="get" action="<?=site_url('search');?>">
					
						<input id="search_page_input" tabindex="1" style="width: 550px;" type="text" name="q" value="<?=$q;?>" />
						<button type="submit" class="btn">
							<span><span>搜索</span></span>
						</button>
						
					</form>
				</div>
				
				
				<?php if ( ! empty( $search_groups ) ) :?>
				<div>
					<h2>搜到的果群</h2>
					<ul class="sidebar_groups_list">
					<?php foreach( $search_groups as $search_group ) : ?>
						<li>
							<div>
								<a href="<?=get_group_url( $search_group['id'] );?>">
									<img width="30" src="<?=get_group_logo_url( $search_group['id'] );?>" />
								</a>
							</div>
							
							<div>
								<a href="<?=get_group_url( $search_group['id'] );?>">
									<?= $search_group['name'];?>
								</a>
							</div>
						</li>
					<?php endforeach; ?>
					
						<div class="clearboth"></div>
						
					</ul>
				</div>
				<?php endif; ?>
				
				
				<?php if ( ! empty ( $search_users ) ) :?>
				<div>
					<h2>搜到的人</h2>
					<ul>
					<?php foreach( $search_users as $search_user ) : ?>
						<li>
							<?= $search_user['name'];?>
						</li>
					<?php endforeach; ?>
					</ul>
				</div>
				<?php endif; ?>
				
				<?php //print_r( $search_groups ); ?>
				
			</div>
		</div>
	</div>
	
	
	<div id="sidebar">
		<div class="sidebar_top">
			<div class="sidebar_bottom">

				<?php $this->load->view('sidebar/sidebar_ad_pic');?>
			
			</div>
		</div>
	</div>
	
	
	
	


<?php
	$this->load->view('footer_view');
?>