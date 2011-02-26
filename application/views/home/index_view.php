<?php $this->load->view('header_view'); ?>
			
			
		<?=import_css('css/app/home/index.css');?>
		<?=import_js('js/app/home/index.js');?>
            
            <div id="content">
        		<div class="content_top">
        			<div class="content_bottom">

						<div id="home_pic">
							<div id="home_intro" class="hidden">
								奇异果介绍
							</div>
							
						</div>
						
						<div id="home_show">
						<?php
							$ci =& get_instance();
							$ci->load->library('Douban');
							//print_r( $ci->douban->get_request_token() );
							//$douban_url =  $ci->douban->get_authorize_url( 'http://' . $_SERVER["HTTP_HOST"] . site_url('user/login_by_douban') );
							//echo $ci->douban->get_access_token( 'f6f948f992d489d6e4ebdaecb87d9d82' );
						?>

						
							<h2>奇异果的奇异之处</h2>
							<p>
								看微博 连接 新发现 创造生活
							</p>
							
							
							<div class="home_block">
								<h2>活跃群组</h2>
								<ul>
									<li>某个</li>
								</ul>
							</div>
							
							
							<div class="home_block">
								<h2 class="tipsy_s" title="这些都是奇异果的用户哦~">他们在奇异果...</h2>
								<ul>
								
								</ul>
							</div>
							
							<div class="home_block">
								<h2 class="tipsy_w" title="消息盒子整合了用户、果群的各种信息">消息盒子</h2>
								<ul>
								
								</ul>
							</div>
							
							<div class="home_block">
								<h2>活动</h2>
								<ul>
								
								</ul>
							</div>
							

						</div>
						
						<div style="height:500px;"></div>
					</div>
        		</div>
            </div>
            
            
            

            <div id="sidebar">
            	<div class="sidebar_top">
            		<div class="sidebar_bottom">
            		
						<?php $this->load->view('sidebar/sidebar_homepage');?>
						
            		</div> <!-- sidebar_bottom -->
            	</div>	<!-- sidebar top-->
            </div><!-- sidebar -->
            
<?php $this->load->view('footer_view'); ?>