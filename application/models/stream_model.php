<?php

	/**
	 *	用户 Stream流的数据模型..
	 */
	class Stream_Model extends KK_Model {
		
		/**
		 *	获取用户的活动、任务。。不论参与与否.
		 */
		function get_user_groups_events( $user_id, $limit=20, $start=0, $privacy=null ) {
			$groups_sql = sprintf( 'SELECT kk_group_user.group_id FROM kk_group_user INNER JOIN kk_group
							WHERE kk_group_user.user_id = %d
							AND kk_group_user.group_id = kk_group.id',
							$user_id );  // 不限制~获取全部群组～
							
			if ( !empty ( $privacy ) ) { // 获取关注的公开？私有群组？
				$groups_sql .= sprintf( ' AND kk_group.privacy = "%s"', $privacy );
			}
			
			$user_groups = $this->db->query( $groups_sql );
							
							
			if ( $user_groups->num_rows() == 0 ) {
				return false;
			}
			
			// 抓取events...
			$query_sql = 'SELECT * FROM kk_event WHERE';
			foreach ( $user_groups->result_array() as $key=>$user_group ) {
				if ( $key == 0 ) { // 第一次首行不加or
					$query_sql .= sprintf( ' ( model = "group" AND model_id = %d )', $user_group['group_id'] );
				} else {
					$query_sql .= sprintf( ' OR ( model = "group" AND model_id = %d )', $user_group['group_id'] );
				}
			}
			
			// 排序
			$query_sql .= 'ORDER BY created DESC';
			
			return $this->db->query( $query_sql )->result_array() ;
			
		}
		
		/**
		 *	获取用户的关注的群组的话题...
		 	
		 		// 是否搜查指定的群组。..public ? private?
		 */
		function get_user_groups_topics( $user_id, $limit=20, $start=0 , $privacy=null ) {
			// 先获得用户关注的群组~ // 获取全部，
			$groups_sql = sprintf( 'SELECT kk_group_user.group_id FROM kk_group_user INNER JOIN kk_group
											WHERE kk_group_user.user_id = %d
											AND kk_group_user.group_id = kk_group.id', 
											$user_id  );
			if ( ! empty ($privacy ) ) {
				// 指定获取 公开或私有的群组
				$groups_sql .= sprintf( ' AND kk_group.privacy = "%s"', $privacy );
			}
			
			
			
			//$groups_sql = .sprintf( ' LIMIT %d,%d', $start, $limit ); 不限制
			$user_groups = $this->db->query( $groups_sql );
			
			
			if ( $user_groups->num_rows() == 0 ) {
				return false;  //没有关注群组，返回空
			}
			
			// 抓取对应群组的topics..
			
			$query_sql = 'SELECT * FROM kk_topic WHERE';
			foreach ( $user_groups->result_array() as $key=>$user_group ) {
// 				$this->db->or_like( array(
// 					'model' => 'group',
// 					'model_id' => $user_group['group_id'],
// 				) );
				if ( $key == 0 ) { //第一次，不加 OR 查询
					$query_sql .= sprintf('( model = "%s" AND model_id = %d )', 'group', $user_group['group_id'] );
				} else {
					$query_sql .= sprintf(' OR ( model = "%s" AND model_id = %d )', 'group', $user_group['group_id'] );
				}
				
			}
			
			// 排序, 最新放前面
			$query_sql .= ' ORDER BY created DESC';
			// 限制
			$query_sql .= sprintf( ' LIMIT %d,%d', $start , $limit );
			
			
			return $this->db->query( $query_sql )->result_array();
			
//			return $this->db->get('topic', $limit, $start)->result_array();
			
			
		}
	
	}