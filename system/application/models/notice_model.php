<?php
	/**
	 *		提醒系统
	 
	 	提醒用户，有多少是未事件
	 	例子：
	 		群组有多少新的话题、聊天、活动 （不growl)
	 		
	 		聊天被人回复了，提示到指定页面查看～ (growl)
	 		
	 		被人发邮件了(growl)
	 */
	class Notice_Model extends KK_Model {
	
		function add_notice( $content, $link, $user_id ) {
			$this->db->insert('notice', array(
				
				'created' => date('Y-m-d H:i:s'),
			));
			
			return $this->db->insert_id();
		}
		
		
		function get_notice_count( $user_id, $type='group' ) {
			
		}
		
		
		/**
		 *	戳一下notice， 令notice变为已读
		 */
		function poke_notice( $data ) {
			
		}
		
		
		//function del_notice( $data ) {
			
		//}
		
		
		
		
		
	}