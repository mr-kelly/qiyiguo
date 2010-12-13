<?php
		$this->load->view('header_view'); 
?>

            <div id="sidebar">
				<?php
					
					$this->load->view('sidebar/sidebar_group_view'); 
				?>
            </div>
            
            <div id="content">
            
	
            
			<?php
				if ( $request_groups ) {
					foreach ( $request_groups as $rg ) {
			?>
					<div class="request_group">
						<a href="<?=site_url('user/'.$rg['User']['id']);?>">
							<?=$rg['User']['name'];?> 
						</a>
							想加入
						<a href="<?=site_url('group/'.$rg['Group']['id']);?>">
							<?=$rg['Group']['name'];?>
						</a>
						<div class="buttons">
							<a class="accept_request positive" onclick="return false;" href="<?=site_url('request/group/' . $rg['id']. '/accept');?>">
								允许
							</a>
							<a class="reject_request negative" onclick="return false;" href="<?=site_url('request/group/' . $rg['id']. '/reject');?>">
								拒绝
							</a>
							<a class="ignore_request regular" onclick="return false;" href="<?=site_url('request/group/' . $rg['id']. '/ignore');?>">
								忽略
							</a>
						</div>
					</div>
			<?php
					}
				}
            ?>
            
            <script>
            	$(function(){
            		// 用于统一拒绝、忽略按钮
					function request_ajax($ele,$message) {
            			$.post(
            				$ele.attr('href'),
            				function(data){
            					data = $.parseJSON(data);
            					alert(data.info);
            					
            					  // div.buttons // div.request_group
            					$ele.parent().html($message);
            				}
            			);
					}
					
            		$('.accept_request').click(function(){
						request_ajax($(this),'你允许了加入');
            			return false;
            		});
            		
            		

					
            		$('.reject_request').click(function(){
						request_ajax($(this), '拒绝了他加入');
            			return false;
            		});
            		$('.ignore_request').click(function(){
						request_ajax($(this), '忽略了他的申请');
            			return false;
            		});
            	});
            </script>
            
            
            </div>


<?php
		$this->load->view('footer_view'); 
?>