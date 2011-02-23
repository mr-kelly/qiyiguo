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
	
		function add_notice( $user_id, $content, $link, $type="notice" ) {
			$this->db->insert('notice', array(
				'user_id' => $user_id,
				'content' => $content,
				'link' => $link,
				'type' => $type,
				
				'created' => date('Y-m-d H:i:s'),
			));
			
			return $this->db->insert_id();
		}
		
		
		/**
		 *	获取指定类型的未读提醒的数量
		 */
		function get_unread_notice_count( $user_id, $type='group' ) {
			
		}
		
		
		/**
		 *	戳一下notice， 令notice变为 已读  (update)  ( 更新:直接删除， 以免数据库滞留太多没用东西
		 */
		function poke_notice_by_id( $notice_id ) {
			return $this->db->delete('notice', array(
				'id' => $notice_id,
			));
			
			//$this->db->where('id', $notice_id );
// 			return $this->db->update('notice', array(
// 				'status' => 'read',
// 			));

		}
		
		
		//function del_notice( $data ) {
			
		//}
		
		
		
		
		
	}
