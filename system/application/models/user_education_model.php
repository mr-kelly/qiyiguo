<?php
	
	/**
	 *	用户教育信息设置的数据模型
	 */
	class User_Education_Model extends KK_Model {
		
		/**
		 *	创建教育信息
		 */
		function create_education( $user_id, $data ) {
			$this->db->insert('user_education', $data + array(
				'user_id' => $user_id,
				'created' => date('Y-m-d H:i:s'),
			));
			
			return $this->db->insert_id();
		}
		
		/**
		 *	删除用户所有关联的教育信息
		 */
		function del_user_education( $user_id ) {
			return $this->db->delete('user_education', array(
				'user_id' => $user_id,
			));
		}
		
		
		function get_user_education( $user_id ) {
			$query = $this->db->get_where('user_education', array(
				'user_id' => $user_id,
			));
			if ( $query->num_rows() == 0 ) {
				return false;
			} else {
				return $query->result_array();
			}
		}
		
		
	
	}