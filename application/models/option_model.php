<?php
	class Option_Model extends KK_Model {
		
		/**
		 *	用户自定义的连接 depreciated,  应该创建一个 link_model
		 */
		function create_custom_website($name, $slug, $url, $logo =null) {
			$data = array(
				'website_name' => $name,
				'website_slug' => $slug,
				'website_url' => $url,
				'website_logo' => $logo,
			);
			
			$this->db->insert('option_custom_website', $data);
		}
		
		
		/**
		 *	创建网站 key => value式的option配置
		 */
		function create_or_update_option( $key, $value ) {
			// 检查该key option是否已经存在，存在的话，不创建，update
			$query = $this->db->get_where('option', array(
				'key' => $key,
			));
			if ( $query->num_rows() != 0 ) {
				// 不存在，创建
				$this->db->insert('option', array(
					'option_key' => $key,
					'option_value' => $value,
				));
			
				return $this->db->insert_id();
				
			} else {
			
				// 存在, update
				$this->db->where('option_key', $key );
				return $this->db->update('option', array(
					'option_value' => $value,
				));
				
			}
			
		}
		
		
		
		/**
		 *	获得指定key值的option value，  如果没设置，返回false
		 */
		function get_option( $key ) {
			$query = $this->db->get_where('option', array(
				'option_key' => $key,
			));
			
			if ( $query->num_rows() == ) {
				return false;
			} else {
				$option = $query->row_array();
				
				return $option['option_value'];
			}
			
		}
	}
