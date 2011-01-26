<?php $this->load->view('header_view'); ?>

            <div id="sidebar">
            	<div class="sidebar_top">
            		<div class="sidebar_bottom">
		            	<?php $this->load->view('sidebar/sidebar_group_view');?>
            		</div>
            	</div>
            </div>
            
            
            <div id="content">
            	<div class="content_top">
            		<div class="content_bottom">
            
						<?php
							if ( !$this->tank_auth->is_logged_in() ) {
								show_login_box();
						?>		
							尚未登录哦~
						<?php
							} else {
						?>
						
						
						
							<ul>
						<?php
								foreach ( $user_groups as $group ) {
						?>
						
								<li>
									<a href="<?=site_url('group/'.$group->id );?>">
										<?=$group->name;?>
									</a>
								</li>
						<?php
								}
						?>
							</ul>
						
						<?php
						
							} 
						 ?>
						 
						 
					</div>
				</div>
            </div>
            
<?php $this->load->view('footer_view'); ?>