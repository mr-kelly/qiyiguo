<div style="width: 500px;min-height: 500px;">
	<div class="form_div">
		<form method="post">
			<p>
				<label>输入群号</label>
				<input class="add_group_id" type="text" name="group_id" />
			</p>
			
			<p>
				<label>输入群名</label>
				<input class="search_groups" type="text" name="search_groups" />
			</p>
			
			
			<div class="search_result">
				<!--Search Result-->
			</div>
			
		</form>
	</div>
	
	<script>
		$js_from_group_id = <?=$from_group_id;?>; // From Group ID
		
		$(function() {
			
			
			
			$('.add_group_id').keyup(function(){
				
				$('.search_result').load( '<?=site_url("search/ajax_search_group_by_id");?>' + '/' + $(this).val() + '?ajax=<?=rand();?>' );
			});
			
			
			$('.search_groups').keyup(function() {
				$('.search_result').load( '<?=site_url("search/ajax_search_groups_by_string");?>?q=' + $(this).val()  + '&ajax=<?=rand();?>' );
				
			});
		});
		
		
		/**
		 *	Ajax Function 添加组群关系
		 */
		function add_group_relation( from_group_id, to_group_id ) {
			//alert( '<?=site_url("relation/ajax_add_group_relation/");?>' + '/' + from_group_id + '/' + to_group_id );
			//return false;
			
			$.getJSON( 
				'<?=site_url("relation/ajax_add_group_relation/");?>' + '/' + from_group_id + '/' + to_group_id, 
				function( json ){
					if ( json.status == 1 ) {
						kk_growl.success( json.info );
						setInterval( 'location.reload()', 800 );
					} else {
						kk_growl.error( json.info );
					}
			});
			return false;
		}
	</script>
	
</div>