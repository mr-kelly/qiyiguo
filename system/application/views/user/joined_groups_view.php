<?php $this->load->view('header_view'); ?>

            <div id="sidebar">
            	<?php $this->load->view('sidebar/sidebar_group_view');?>
            </div>
            
            
            <div id="content">
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
            
<?php $this->load->view('footer_view'); ?>