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
            

						<div>
							<h2>管理的群</h2>
							
							<?php
								$this->load->view('group/general_groups_show', array(
									'groups' => $user_admin_groups,
								));
							?>
						</div>
						
						<div class="clearboth"></div>
						
						<div>
							<h2>加入的群</h2>
							<?php
								$this->load->view('group/general_groups_show', array(
									'groups' => $user_groups,
								));
							?>
						</div>
						 
						 
					</div>
				</div>
            </div>
            
<?php $this->load->view('footer_view'); ?>