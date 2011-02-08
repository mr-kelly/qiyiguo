<?php $this->load->view('header'); ?>

            <div id="sidebar">
            	<layout name="$sidebar" cache="10" />
            </div>
            
            
            <div id="content">
			<?php
				if ( !$this->tank_auth->is_logged_in() ) {
					show_login_box();
			?>
			
				尚未登录哦~
			
			<?
				}
    		?>
            </div>
            
<?php $this->load->view('footer'); ?>