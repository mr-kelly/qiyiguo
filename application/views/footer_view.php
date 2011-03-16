            
        </div>
        <!--Container End-->
        
        
        
        


    </div>
    <!--Wrapper End-->
    
    <?php if ( isset( $footer_ad ) ) : ?>
	<div id="footer_ad">
		<script type="text/javascript"><!--
		google_ad_client = "pub-9928587148743461";
		/* 468x60, 创建于 10-12-3 */
		google_ad_slot = "0195707447";
		google_ad_width = 468;
		google_ad_height = 60;
		//-->
		</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
	</div>
	<?php endif; ?>
	
    	<?php if ( !isset( $hide_footer ) ) : ?>
        <div id="kk_footer">
        	<div id="kk_footer_container">
				<div class="footer_column">
					<h2>关于我们</h2>
					<ul>

						<li>
							<a href="<?=site_url('g/qiyiguo');?>" class="tipsy_sw" title="我们的团队也是奇异果的使用者！来看看我们~">
								官方果群
							</a>
						</li>
						<li>
							<a href="<?=site_url('page/recruit');?>">加入我们</a>
						</li>
						<li>
							<a href="<?=site_url('page/about_why_qiyiguo');?>">为什么叫“奇异果”</a>
						</li>
						<li>
							<a href="<?=site_url('page/about_design_qiyiguo');?>">设计之禅</a>
						</li>
						<li>
							<a href="<?=site_url('page/invest_us');?>">投资我们</a>
						</li>
						
						<li>
							<a href="<?=site_url('page/patent');?>">
								版权专利保护
							</a>
						</li>
						
					</ul>
				</div>
				
				<div class="footer_column">
					<h2>联系方式</h2>
					<ul>
						<li>
							<a href="#">意见反馈</a>
						</li>
						<li>
							<a href="#">广告投放</a>
						</li>
						<li>
							<a href="#">新浪微博</a>
						</li>
						<li>
							<a href="#">免责条款</a>
						</li>
						<li>
							<a href="#">隐私条款</a>
						</li>
					</ul>
				</div>
				
				<div class="footer_column">
					<h2>实验室</h2>
					<ul>
						<li>
							<a href="#">什么是实验室?</a>
						</li>
						
						<li>
							<a href="<?=site_url('page/labs_recruit');?>">人才招募</a>
						</li>
						
						<li>
							<a href="#">更多实验项目</a>
						</li>
					</ul>
					<!--
					<h2>认证</h2>
					<ul>
						<li>
							<a href="#">个人认证</a>
						</li>
						<li>
							<a href="#">果群认证</a>
						</li>
					</ul>
					-->
				</div>
				
				<div id="footer_copyright">
					<div id="kk"></div>
					<!--<img src="<?=static_url('img/kk_logo.png');?>" />-->
<!-- 
					<a href="<?=site_url('u/mrkelly');?>" class="tipsy_s" title="知道吗？用「谷歌浏览器」会有最完整的网页效果哦">
						MrKelly 出品
					</a>
 -->
 					<a href="<?=site_url('g/qiyiguo');?>">
 						奇异果.嘻嘻
 					</a>
					
					&copy;
					
					<span>
						version 0.90
					</span>
					
					<span>
						<?php
							$ci =& get_instance();
							$ci->load->library('benchmark');
							echo $ci->benchmark->elapsed_time();
							echo ' ';
							echo $ci->benchmark->memory_usage();
						?>
					</span>
					
					<a href="<?=base_url();?>wiki/">
						帮助
					</a>
					
					<div>

						
						<a href="http://www.cyberpolice.cn/">
							<img src="<?=static_url('img/gfw/net110.gif');?>" />
							<!--网络110-->
						</a>
						
						<a href="http://www.miibeian.gov.cn/">
							<img src="<?=static_url('img/gfw/jingying.gif');?>" />
							<!--经营性网站备案-->
						</a>
					</div>
				</div>
			</div>
        
        
        </div>
    	<?php endif; ?>




<!-- Piwik --> 
<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "https://piwik.qiyiguo.cc/" : "http://piwik.qiyiguo.cc/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
piwikTracker.trackPageView();
piwikTracker.enableLinkTracking();
} catch( err ) {}
</script><noscript><p><img src="http://piwik.qiyiguo.cc/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
<!-- End Piwik Tracking Code -->
        
</body>
</html>



<script>
	// 页面读取完毕，关闭loading
	$('#loading').fadeOut();
</script>