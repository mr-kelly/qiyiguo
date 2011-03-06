<?php

	class User_Option_Model extends KK_Model {
		
		/**
		 *	添加(没有的时候)、更改用户的option...
		 
		 		JSON 格式
		 */
		function user_option( $user_id, $key, $value ) {
			// 获取用户的option
			$query = $this->db->get_where('user_option', array(
				'user_id' => $user_id,
			));
			
			if ( $query->num_rows() == 0 ) {
				// 用户还没产生option?~ 产生
				$this->db->insert( 'user_option', array(
					'user_id' => $user_id,
					'options' => json_encode(array(
							$key => $value,
					)),
				));
				
				return true;
			}
			
			// 用户已经产生了option了？
			$user_option = $query->row_array();
			
			// 判断当前需要的修改的key，value是否已存在，
			$user_options_array = json_decode( $user_option['options'] , true);

			// 修改...
			$user_options_array[$key] = $value;
			
			// 修改数据库
			$this->db->where('id', $user_option['id'] );
			return $this->db->update('user_option', array(
				'options' => json_encode( $user_options_array ),
				
			));
			
			
		}
	
		function get_user_option( $user_id, $key ) {
			$query = $this->db->get_where('user_option', array(
				'user_id' => $user_id,
			));
			if ( $query->num_rows() == 0 ) {
				return false;
			}
			
			$user_option = $query->row_array();
			$options = json_decode( $user_option['options'], true );
			
			return $options[ $key ];
			
		
		}
	
	
	}