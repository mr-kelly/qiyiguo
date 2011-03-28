            
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
							<a href="<?=site_url('page/about_why_qiyiguo');?>">
								“奇异果”的来源
							</a>
						</li>
						<!--
						<li>
							<a href="<?=site_url('page/about_design_qiyiguo');?>">设计之禅</a>
						</li>
						-->
						
						<!--
						<li>
							<a href="<?=site_url('page/invest_us');?>">投资我们</a>
						</li>
						-->
						<li>
							<a href="<?=site_url('page/rule');?>">
								免责条款
							</a>
						</li>
						<li>
							<a href="<?=site_url('page/rule');?>">
								隐私条款
							</a>
						</li>
						
						<li>
							<a href="<?=site_url('page/patent');?>">
								版权专利声明
							</a>
						</li>
						
					</ul>
				</div>
				
				<div class="footer_column">
					<h2>联系方式</h2>
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
							<a href="<?=site_url('g/qiyiguo');?>">意见反馈</a>
						</li>
						<li>
							<a href="#">新浪微博</a>
						</li>

					</ul>
				</div>
				
				<!--
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
					<h2>认证</h2>
					<ul>
						<li>
							<a href="#">个人认证</a>
						</li>
						<li>
							<a href="#">果群认证</a>
						</li>
					</ul>
				</div>
				-->
				
				<div id="footer_copyright">
					<div id="kk"></div>
					<!--<img src="<?=static_url('img/kk_logo.png');?>" />-->
<!-- 
					<a href="<?=site_url('u/mrkelly');?>" class="tipsy_s" title="知道吗？用「谷歌浏览器」会有最完整的网页效果哦">
						MrKelly 出品
					</a>
 -->

					<div>
						<span>
							&copy; 2011
						</span>
						
						<span>
							<a title="qiyiguo.cc" class="tipsy_s" href="<?=site_url('g/qiyiguo');?>">
								奇异果.嘻嘻
							</a>
						</span>
					</div>
					
					<div>
						<span class="footer_grey">
							<a href="#">
								<!--边度网络科技有限公司-->
							</a>
						</span>
					</div>
					
					<div>
						<span class="footer_grey">
							<a target="_blank" href="http://www.miibeian.gov.cn/">
								粤ICP备07053148号
							</a>
						</span>
					</div>
					<!--
					<span>
						version 0.97
					</span>
					-->
					
					<!--
					<span>
						<?php
							$ci =& get_instance();
							$ci->load->library('benchmark');
							echo $ci->benchmark->elapsed_time();
							echo ' ';
							echo $ci->benchmark->memory_usage();
						?>
					</span>
					-->
					
					<!-- Chrome -->
					<a target="_blank" class="tipsy_s grey" href="http://www.google.com/chrome" title="使用谷歌浏览器会有意想不到的特效">
						<img src="<?=static_url('img/websites/chrome.png');?>" />
					</a>
					<a href="<?=site_url('home/demo');?>">
						帮助
					</a>
					
					
					
					<div>
						<br />
						<!--网络110-->
						<!--
						<a target="_blank" href="http://www.cyberpolice.cn/">
							<img src="<?=static_url('img/gfw/net110.gif');?>" />
							
						</a>
						
						<a target="_blank" href="http://www.miibeian.gov.cn/">
							<img src="<?=static_url('img/gfw/jingying.gif');?>" />
							
						</a>
						--><!--经营性网站备案-->
						
						
						<a target="_blank" href="http://qiyiguo.cc/g/qiyiguo">
							<img width="48" height="48" src="<?=static_url('img/kk_logo.png');?>" />
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