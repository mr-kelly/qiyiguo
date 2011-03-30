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
	
		function add_notice( $user_id, $title, $content, $link, $model, $model_id, $type="notice" , $from_user_id = null ) {
			$this->db->insert('notice', array(
				'user_id' => $user_id,
				'from_user_id' => $from_user_id,
				'title' => $title,
				'content' => $content,
				'link' => $link,
				'type' => $type,
				'model' => $model,
				'model_id' => $model_id,
				'created' => date('Y-m-d H:i:s'),
			));
			
			return $this->db->insert_id();
		}
		
		/**
		 *		清楚指定提醒...
		 */
		function clean_notices( $user_id, $model, $model_id ) {
			$this->db->where( array(
				'user_id' => $user_id,
				'model' => $model,
				'model_id' => $model_id,
			));
			return $this->db->update('notice', array(
				'status' => 1 , // 已读
				
// 				'model' => $model,
// 				'model_id' => $model_id,
// 				
// 				'user_id' => $user_id,
			));
		}
		/**
		 *	清楚所有提醒
		 */
		function clear_notices( $user_id ) {
			$this->db->where('user_id', $user_id);
			return $this->db->update('notice', array(
				'status' => 1,
			));
		}
		
		/**
		 *	获取指定Notice
		 */
		function get_notice_by_id( $notice_id ) {
			$query = $this->db->get_where('notice', array(
				'id' => $notice_id,
			));
			if ( $query->num_rows() == 0 ) {
				return false;
			}
			
			return $query->row_array();
			
		}
		/**
		 *	获得指定用户的notice
		 */
		function get_notices( $user_id, $status=0, $limit=10, $start=0 ) {
			$query = $this->db->get_where('notice', array(
				'user_id' => $user_id,
				'status' => $status, // 获取未处理(0)的notice...
			), $limit, $start );
			$notices = $query->result_array();
			
			// 添加用户  TODO
			foreach( $notices as $key=>$notice ) {
				$notices[$key]['user_avatar_url'] =  get_user_avatar_url( $notice['from_user_id'] );
			}
			
			return $notices;
			
		}
		
		/**
		 *	获取指定用户的notice数目...
		 */
		function get_notices_count( $user_id ) {
			$query = $this->db->get_where('notice', array(
				'user_id' => $user_id,
				'status' => 0,
			));
			
			return $query->num_rows();
			
		}
		/**
		 *	获取指定类型的未读提醒的数量
		 */
		function get_unread_notice_count( $user_id, $type='group' ) {
			
		}
		
		
		/**
		 *	  （过期）戳一下notice， 令notice变为 已读  (update)  ( 更新:直接删除， 以免数据库滞留太多没用东西
		 
			 戳一下notice，令status变为1(已经处理)
		 */
		function poke_notice_by_id( $notice_id ) {
			//$notice = $this->get_notice_by_id ( $notice_id );
			
			$this->db->where('id', $notice_id );
			return $this->db->update('notice', array(
				'status' => 1,  // 已处理
			));
			
// 			return $this->db->delete('notice', array(
// 				'id' => $notice_id,
// 			));
			
			//$this->db->where('id', $notice_id );
// 			return $this->db->update('notice', array(
// 				'status' => 'read',
// 			));

		}
		
		
// 		function del_notice( $notice_id ) {
// 			return $this->db->delete('notice', array(
// 				'id' => $notice_id,
// 			));
// 		}
		
		
		
		
		
	}
