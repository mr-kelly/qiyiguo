    <div id="navigator">
    	<a href="#" id="nav_close" class="hidden"></a>
    	
    	<div class="nav_content">
    		<div class="nav_content_top">
    			<div class="nav_content_bottom">
					<ul>
						<li class="nav_h">个人</li>
						
						<li>
							<a href="<?=get_user_url( get_current_user_id() );?>">
								<span class="icon icon_person"></span>
								个人主页
							</a>
						</li>
						<li>
							<a href="#">
								<span class="icon icon_person"></span>
								我的朋友
							</a>
						</li>
						<li>
							<a href="#">
								<span class="icon icon_person"></span>
								我的朋友
							</a>
						</li>
						
						
						<li class="nav_h">果群</li>
						
						<li>
							<a href="<?=site_url('user/my_groups');?>">
								<span class="icon icon_joined_group"></span>
								我加入的果群
							</a>
						</li>
					</ul>
				</div>
			</div>
    	</div>
    	
		<div class="clearboth"></div>
		
		
    	<!-- <div id="nav_btn"> -->
    	<a href="#" id="nav_btn" class="autohide_btn" onclick="return false;">导航菜单</a>
    	<!-- </div> -->