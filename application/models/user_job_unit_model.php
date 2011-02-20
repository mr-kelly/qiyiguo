<?php

	class User_Job_Unit_Model extends KK_Model {
		/**
		 *	创建工作单位信息
		 */
		function create_job_unit( $user_id, $data ) {
			$this->db->insert('user_job_unit', $data + array(
				'user_id' => $user_id,
				'created' => date('Y-m-d H:i:s'),
			));
			
			return $this->db->insert_id();
		}
		
		/**
		 *	删除用户所有关联的教育信息
		 */
		function del_user_job_units( $user_id ) {
			return $this->db->delete('user_job_unit', array(
				'user_id' => $user_id,
			));
		}
		
		
		function get_user_job_units( $user_id ) {
			$query = $this->db->get_where('user_job_unit', array(
				'user_id' => $user_id,
			));
			if ( $query->num_rows() == 0 ) {
				return false;
			} else {
				return $query->result_array();
			}
		}
	}