<?php $this->load->view('header_view'); ?>
			
			
		<?=import_css('css/app/home/index.css');?>
		<?=import_js('js/app/home/index.js');?>
            
            <div id="content">
        		<div class="content_top">
        			<div class="content_bottom">

						<div id="home_pic">
							<div id="home_intro" class="">
								奇异果介绍 - 世界上第一个群组网络、生活网络，并且它是原产于中国制造。
								
								
							</div>
							

							
						</div>
						
						<div id="home_show" style="width:100%;">
							
							<div class="align_center">
								<img src="<?=static_url('img/howto_0.jpg');?>" />
							</div>
							
							<div class="align_center">
								<a target="_blank" class=" kk_btn tipsy_n" title="看看奇异果怎么用" href="<?=site_url('home/demo');?>">
									演示一下呗
								</a>
							</div>
							
						<?php
							$ci =& get_instance();
							$ci->load->library('Douban');
							//print_r( $ci->douban->get_request_token() );
							//$douban_url =  $ci->douban->get_authorize_url( 'http://' . $_SERVER["HTTP_HOST"] . site_url('user/login_by_douban') );
							//echo $ci->douban->get_access_token( 'f6f948f992d489d6e4ebdaecb87d9d82' );
						?>
							<h2>奇异果目前仅向以下学校开放</h2>
							<div class="align_center">
								<img src="<?=static_url('img/bnu_uic.jpg');?>" />
							</div>

							
							

							
							
							
							<div style="margin: 20px 0 0 0;">
								<h2>这些群组在奇异果...</h2>
								<?php
									$this->load->view('group/general_groups_show', array(
										'groups' => $random_groups,
									));
								?>
								<!--
								<?php if ( !empty( $random_groups ) ) :?>
								<ul class="groups_show">
								<?php foreach ( $random_groups as $random_group ) : ?>
									<li>
										<div class="group_logo">
											<a href="<?=site_url('group/' . $random_group['id']);?>">
												<img class="avatar" src="<?=get_group_logo_url( $random_group['id'] );?>" width="40" height="40" />
											</a>
										</div>
										
										<div class="group_name">
											
											<a class="tipsy_n" title="<?=$random_group['intro'];?>" href="<?=site_url('group/' . $random_group['id'] );?>">
												<?=$random_group['name'];?>
											</a>
										</div>
									</li>
								<?php endforeach; ?>
								</ul>
								<?php endif; ?>
								-->
								
								<div class="clearboth align_right" style="margin-right: 30px;">
									<a href="<?=site_url('group');?>">
										&gt;&gt;查看更多
									</a>
								</div>
								
								<div class="clearboth"></div>
								
							</div>
							
							<!-- 

							
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
							
 -->

						</div>
						
						<div style="height:1600px;"></div>
					</div>
        		</div>
            </div>
            
            
            

            <div id="sidebar">
            	<div class="sidebar_top">
            		<div class="sidebar_bottom">
            		
						<?php $this->load->view('sidebar/sidebar_homepage');?>
						
						
						<?php //$this->load->view('sidebar/sidebar_ad_pic');?>

						
            		</div> <!-- sidebar_bottom -->
            	</div>	<!-- sidebar top-->
            </div><!-- sidebar -->
            
<?php $this->load->view('footer_view'); ?>