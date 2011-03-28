<?php

	class User_douban_Model extends KK_Model {
	
		function is_user_douban( $data ){
			$query = $this->db->get_where( 'user_douban', $data );
			if ( $query->num_rows() == 0 ) {
				// 不存在 豆瓣登录...
				return false;
			} else {
				return $query->num_rows();
			}
		}
		
		/**
		 *	删除豆瓣...
		 */
		function del_user_douban( $user_id ) {
			$this->db->where('user_id', $user_id);
			return $this->db->delete('user_douban');
		}
		
		
		function create_user_douban( $data ) {
			$this->db->insert( 'user_douban', $data + array(
				'created' => date('Y-m-d H:i:s'),
			));
			
			return $this->db->insert_id();
		}
		
		
		/**
		 *	获取单个用户~
		 */
		function get_user_douban( $data ) {
			$query = $this->db->get_where( 'user_douban', $data );
			
			if ( $query->num_rows != 0 ) {
				return $query->row_array();
			} else {
				return false;
			}
		}
	}