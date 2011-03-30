<?php $this->load->view('header_view'); ?>


            
            
            <div id="content">
            	<div class="content_top">
            	
            		<div class="content_bottom">
            			
            			<h1>果群</h1>
            			
            			<?= kk_pagination( $start, $groups_count, 50 ); ?>
            			
            			<?php
            				$this->load->view('group/general_groups_show', array(
            					'groups' => $groups,
            				));
            			?>
            			
						<div class="clearboth"></div>
						
						
						
						
					</div>
    			
    			</div>
            </div>
            
            <div id="sidebar">
            	<div class="sidebar_top">
            		<div class="sidebar_bottom">
            		
  						<?php 
							if ( is_logged_in() ):
								$this->load->view('sidebar/sidebar_user_profile', array(
									'user' => kk_get_user( get_current_user_id() ),
								)); 
								$this->load->view('sidebar/sidebar_user_view', array(
									'user' => kk_get_user( get_current_user_id() ),
								)); 
							endif;
						?>
						
            			<?php
            				$this->load->view('sidebar/sidebar_ad_pic');
            			?>
            			
            			<?php $this->load->view('sidebar/sidebar_group_view'); ?>
            			
            			
            			

            			
            		
            		
            		
            		</div>
            	</div>
            	
            </div>
            
            
            
<?php $this->load->view('footer_view'); ?>
