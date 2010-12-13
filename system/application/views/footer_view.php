            
        </div>
        <!--Container End-->
        
        
        
        


    </div>
    <!--Wrapper End-->
    
    
        <div id="footer">
        	
        	<div class="footer_column">
        		<h2>关于我们</h2>
        		<ul>
        			<li>
        				<a href="#">官方部落格</a>
        			</li>
        			<li>
        				<a href="#">加入我们</a>
        			</li>
        			<li>
        				<a href="#">为什么叫“奇异果”</a>
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
        		</ul>
        	</div>
        	
        	<div id="footer_copyright">
        	
			   {elapsed_time}
			   
			   <a href="<?=base_url();?>wiki/">
				   帮助
			   </a>
            
            </div>

        
        
        </div>
    
<? // {// Google analysts 统计} ?>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-2467823-3");
pageTracker._trackPageview();
} catch(err) {}</script>



        

    
<?php
	$ci =& get_instance();
	// 未登录，放上登录box
	if ( !$ci->tank_auth->is_logged_in() ) :
?>


<!--登录窗口-->

        <!-- ui-dialog for login -->
        <div id="login_box" class="hidden">
			<div class="ui-overlay">
				<div class="ui-widget-overlay"></div>
				<div class="ui-widget-shadow ui-corner-all" style="width: 422px; height: 422px; position: absolute; left: 30%; top: 20%;"></div>
	
			</div>
			<div style="position: absolute; width: 400px; height: 400px;left: 30%; top: 20%; padding: 10px;" class="ui-widget ui-widget-content ui-corner-all">
					<div class="right"><a href="#" onclick="$('#login_box').fadeOut();return false;">X</a></div>
					
					<div class="ui-dialog-content ui-widget-content" style="background: none; border: 0;">

						<?php $this->load->view('user/login'); ?>

					</div>
					
					
			</div>
        </div>
        
        <div id="register_box" class="hidden"> 
			<div class="ui-overlay">
				<div class="ui-widget-overlay"></div>
				<div class="ui-widget-shadow ui-corner-all" style="width: 422px; height: 322px; position: absolute; left: 30%; top: 20%;"></div>
	
			</div>
			<div style="position: absolute; width: 400px; height: 300px;left: 30%; top: 20%; padding: 10px;" class="ui-widget ui-widget-content ui-corner-all">
					<div class="right"><a href="#" onclick="$('#register_box').fadeOut();return false;">X</a></div>
					<div class="ui-dialog-content ui-widget-content" style="background: none; border: 0;">
						
						<?php $this->load->view('user/register'); ?>
						

						
					</div>
			</div>
        </div>

<?php
	endif;
?>
        
</body>
</html>

<!-- 然后将以下这段代码放到网页页尾 -->
<!-- JiaThis Button BEGIN -->
<script type="text/javascript" src="http://www.jiathis.com/code/jia.js" charset=utf-8></script>
<!-- JiaThis Button END -->


<script>
	// 页面读取完毕，关闭loading
	$('#loading').fadeOut();
</script>