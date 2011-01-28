<?php $this->load->view('header_view'); ?>

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