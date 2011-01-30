<?php $this->load->view('header_view'); ?>
			
			
		<?=import_css('css/app/home/index.css');?>
		<?=import_js('js/app/home/index.js');?>
            <div id="sidebar">
            	<div class="sidebar_top">
            		<div class="sidebar_bottom">
            		
            			<div class="sidebar_widget">
            				<h2>推荐友群</h2>
		            		<?php $this->load->view('sidebar/sidebar_group_view'); ?>
	            		</div>
            		</div>
            	</div>
            </div>
            
            
            <div id="content" class="three_columns">
        		<div class="content_top">
        			<div class="content_bottom">
						
						<div id="home_pic">
							<div id="home_intro" class="hidden">
								奇异果介绍
							</div>
						</div>
						
						
						<div style="height:800px;"></div>
						<?php
						
							// $ci =& get_instance();
// 							$ci->load->library('t_sina');
// 							
// 							$ci->t_sina->weibo->setUser('chepy6','password');
// 							
// 							$tweets = $ci->t_sina->weibo->friends_timeline();
// 							foreach ( $tweets as $tweet ) {
// 								echo '<p>'. $tweet['user']['screen_name'] . ': ' . $tweet['text'] . '</p>';
// 							}
							
							
		
						?>
					</div>
        		</div>

            </div>
<?php $this->load->view('footer_view'); ?>