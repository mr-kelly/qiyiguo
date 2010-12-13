<?php $this->load->view('header_view'); ?>

            <div id="sidebar">
            	<?php $this->load->view('sidebar/sidebar_group_view'); ?>
            </div>
            
            
            <div id="content" class="three_columns">
        		
        		<h2>奇异果， 连接你的友群  ( 这里是微博读取 ) </h2>
        		
        		<?php
        		
					$ci =& get_instance();
					$ci->load->library('t_sina');
					
					$ci->t_sina->weibo->setUser('chepy6','626626');
					
					$tweets = $ci->t_sina->weibo->friends_timeline();
					foreach ( $tweets as $tweet ) {
						echo '<p>'. $tweet['user']['screen_name'] . ': ' . $tweet['text'] . '</p>';
					}
        			
        			

        		?>

            </div>
<?php $this->load->view('footer_view'); ?>