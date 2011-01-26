<?php $this->load->view('header_view'); ?>

            <div id="sidebar">
            	<div class="sidebar_top">
            		<div class="sidebar_bottom">
            		
            		
            			<?php $this->load->view('sidebar/sidebar_group_view'); ?>
            			
            			<br /><br /><br /><br /><br /><br />
            		
            		
            		
            		</div>
            	</div>
            	
            </div>
            
            
            <div id="content" class="three_columns">
            	<div class="content_top">
            	
            		<div class="content_bottom">
            	
            	
						<ul class="group_list">
						
						<?php foreach ( $groups as $g ) { ?>
							<li>
								<a href="<?=site_url('group/'.$g->id);?>">
									<img class="avatar" height="100" width="100" src="<?=get_group_logo_url( $g->id );?>" />
									
									<br />
								
								
									<?=$g->name;?>
								</a>
							</li>
						<?php } ?>
						
						</ul>
						
						
						<div class="clearboth"></div>
						
						
						
					</div>
    			
    			</div>
            </div>
            
            
<?php $this->load->view('footer_view'); ?>