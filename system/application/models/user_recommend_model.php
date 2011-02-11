<?php

	class User_Recommend_Model extends KK_Model {
		
		/**
		 *	添加“推荐好友”、“特别关系”
		 */
		function add_user_recommend( $user_id, $recommend_user_id, $relation='friend' ) {
			// 总不能自己推荐自己吧？
			if ( $user_id == $recommend_user_id ) {
				return false;
			}
			
			// 不能添加不存在的用户！
			$query = $this->db->get_where('users', array(
				'id' => $recommend_user_id,
			));
			if ( $query->num_rows() == 0 ) {
				return false;
			}
			
			//首先避免重复
			$query = $this->db->get_where('user_recommend', array(
				'user_id' => $user_id,
				'recommend_user_id' => $recommend_user_id,
				'relation' => $relation,
			));
			if ( $query->num_rows() != 0 ) {
				//有重复！？
				return false;
			}
			
			
			
			
			$this->db->insert('user_recommend', array(
				'user_id' => $user_id,
				'recommend_user_id' => $recommend_user_id,
				'relation' => $relation,
				
				'created' => date('Y-m-d H:i:s'),
			));
			
			return $this->db->insert_id();
			
		}
		
		
		function get_user_recommends( $user_id, $relation = 'friend' ) {
			$query = $this->db->get_where('user_recommend', array(
				'user_id' => $user_id,
				'relation' => $relation,
			));
			
			$recommends = $query->result_array();
			
			// 读取用户, 分别存入数组
			$recommend_users = array();
			foreach( $recommends as $recommend ) {
				array_push( $recommend_users, $this->_get_user( $recommend['recommend_user_id'] ) );
			}
			
			return $recommend_users;
			
		}
	}