<?php

	class User_Mood_Model extends KK_Model {
		
		/**
		 *	添加用户心情
		 */
		function add_mood( $user_id, $text) {
			$this->db->insert('user_mood', array(
				'user_id' => $user_id,
				'text' => $text,
				'created' => date('Y-m-d H:i:s'),
			));
			
			return $this->db->insert_id();
			
		}
		
		
		/**
		 *	获取用户最后一条心情
		 */
		function get_user_last_mood( $user_id ) {
			$this->db->order_by('created', 'desc');
			$query = $this->db->get_where('user_mood', array(
				'user_id' => $user_id,
			));
			
			if ( $query->num_rows() == 0 ) {
				return false;
			}
			
			return $query->row_array();
		}
	
	}